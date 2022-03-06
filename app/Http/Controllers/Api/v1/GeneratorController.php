<?php

namespace App\Http\Controllers\Api\v1;

use App\Generators\Backend\ControllerGenerator;
use App\Generators\Backend\LangGenerator;
use App\Generators\Backend\MigrationGenerator;
use App\Generators\Backend\ModelGenerator;
use App\Generators\Backend\RelationshipGenerator;
use App\Generators\Backend\RepositoryGenerator;
use App\Generators\Backend\RequestGenerator;
use App\Generators\Backend\RouteGenerator;
use App\Generators\Backend\SeederGenerator;
use App\Generators\Backend\SwaggerGenerator;
use App\Generators\Backend\SwaggerRelationshipGenerator;
use App\Generators\BackendUpdate\ControllerUpdateGenerator;
use App\Generators\BackendUpdate\LangUpdateGenerator;
use App\Generators\BackendUpdate\MigrationUpdateGenerator;
use App\Generators\BackendUpdate\ModelUpdateGenerator;
use App\Generators\BackendUpdate\RequestUpdateGenerator;
use App\Generators\BackendUpdate\SeederUpdateGenerator;
use App\Generators\BackendUpdate\SwaggerUpdateGenerator;
use App\Generators\Frontend\ApiGenerator;
use App\Generators\Frontend\FormGenerator;
use App\Generators\Frontend\FormHandlerGenerator;
use App\Generators\Frontend\RouteGenerator as RouteGeneratorFe;
use App\Generators\Frontend\ViewTableGenerator;
use App\Generators\FrontendUpdate\FormUpdateGenerator;
use App\Generators\FrontendUpdate\ViewTableUpdateGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGeneratorRelationshipRequest;
use App\Models\Generator;
use App\Services\FileService;
use App\Services\GeneratorService;
use App\Services\QueryService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class GeneratorController extends Controller
{
    /*@var service*/
    private GeneratorService $serviceGenerator;

    public function __construct()
    {
        $this->serviceGenerator = new GeneratorService();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $limit = $request->get('limit', 25);
            $ascending = $request->get('ascending', '');
            $orderBy = $request->get('orderBy', '');
            $search = $request->get('search', '');
            $betweenDate = $request->get('created_at', []);

            $queryService = new QueryService(new Generator());
            $queryService->columnSearch = ['table'];
            $queryService->withRelationship = [];
            $queryService->search = $search;
            $queryService->betweenDate = $betweenDate;
            $queryService->limit = $limit;
            $queryService->ascending = $ascending;
            $queryService->orderBy = $orderBy;

            $query = $queryService->queryTable();
            $query = $query->paginate($limit);
            $generators = $query->toArray();

            return $this->jsonTable($generators);
        } catch (\Exception $e) {
            return $this->jsonError($e);
        }
    }

    /**
     * @param Generator $generator
     * @return JsonResponse
     */
    public function show(Generator $generator): JsonResponse
    {
        try {
            return $this->jsonData($generator);
        } catch (\Exception $e) {
            return $this->jsonError($e);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $fields = $request->get('fields', []);
            $model = $request->get('model', []);
            // git commit
            $this->_gitCommit($model['name']);
            if ($this->serviceGenerator->getOptions(config('generator.model.options.only_migrate'), $model['options'])) {
                $migrationGenerator = new MigrationGenerator($fields, $model);
                new ModelGenerator($fields, $model);
                $files['migration']['file'] = $migrationGenerator->file;
            } else {
                $generateBackend = $this->_generateBackend($fields, $model);
                $this->_generateFrontend($fields, $model);
                $files = $this->_generateFile($model, $generateBackend);
            }

            Generator::create([
                'field' => json_encode($fields),
                'model' => json_encode($model),
                'table' => $this->serviceGenerator->tableName($model['name']),
                'files' => json_encode($files),
            ]);

            $this->_runCommand($model);

            return $this->jsonMessage(trans('messages.success'));
        } catch (\Exception $e) {
            return $this->jsonError($e);
        }
    }

    /**
     * @param Request $request
     * @param Generator $generator
     * @return JsonResponse
     */
    public function update(Request $request, Generator $generator): JsonResponse
    {
        try {
            $fields = $request->get('fields', []);
            $updateFields = $request->get('fields_update', []);
            $model = $request->get('model', []);
            $renameFields = $request->get('rename', []);
            $changeFields = $request->get('change', []);
            $dropFields = $request->get('drop', []);
            $updateFields = [
                'updateFields' => $updateFields,
                'renameFields' => $renameFields,
                'changeFields' => $changeFields,
                'dropFields' => $dropFields,
            ];
            // git commit
            $this->_gitCommit($model['name']);
            if ($this->serviceGenerator->getOptions(config('generator.model.options.only_migrate'), $model['options'])) {
                new MigrationUpdateGenerator($generator, $model, $updateFields);
                new ModelUpdateGenerator($model, $updateFields);
            } else {
                $this->_generateBackendUpdate($generator, $model, $updateFields);
                $this->_generateFrontendUpdate($generator, $model, $updateFields);
            }
            $generator->update([
                'field' => json_encode($fields),
            ]);
            $this->_runCommand();

            return $this->jsonMessage(trans('messages.success'));
        } catch (\Exception $e) {
            return $this->jsonError($e);
        }
    }

    /**
     * @param Generator $generator
     * @return JsonResponse
     */
    public function destroy(Generator $generator): JsonResponse
    {
        try {
            $model = json_decode($generator->model, true);
            $files = json_decode($generator->files, true);
            $generatorService = new GeneratorService();
            $fileService = new FileService();

            $this->_gitCommit($model['name']);
            // START - Remove File
            //            if (file_exists($files['migration'])) {
            //                $fileMigration = str_replace(base_path(), '', $files['migration']);
            //                $fileMigration = ltrim($fileMigration, '/');
            //                Artisan::call("migrate:rollback --path={$fileMigration}");
            //            }
            foreach ($files as $file) {
                if (is_array($file)) {
                    foreach ($file as $fileInside) {
                        if (file_exists(app_path($fileInside))) {
                            unlink(app_path($fileInside));
                        }
                    }
                } else {
                    if (file_exists(app_path($file))) {
                        unlink(app_path($file));
                    }
                }
            }
            // END - Remove File

            // START - search route
            $templateDataRouteReal = $this->serviceGenerator->getFile('api_routes', 'laravel');
            $startRoute = "/*<==> {$model['name']} Route -";
            $endRoute = "'{$model['name']}Controller');";
            $templateDataRoute = $generatorService->searchTemplate($startRoute, $endRoute, 0, strlen($endRoute), $templateDataRouteReal);
            $templateDataRouteReal = str_replace($templateDataRoute, '', $templateDataRouteReal);
            $fileService->createFileReal(config('generator.path.laravel.api_routes'), $templateDataRouteReal);
            // END - search route
            // START - search lang
            $nameLanguages = ['route', 'table'];
            $languages = config('generator.not_delete.laravel.lang');
            $tableName = $this->serviceGenerator->tableNameNotPlural($model['name']);
            foreach ($languages as $key => $langComment) {
                foreach ($nameLanguages as $nameLang) {
                    $templateDataLangReal = $this->serviceGenerator->getFile('lang', 'laravel', $key . '/' . $nameLang . '.php');
                    if ($nameLang === 'route') {
                        $startRouteTable = "// START - {$generatorService->tableNameNotPlural($model['name'])}\n";
                        $endRouteTable = "// END - {$generatorService->tableNameNotPlural($model['name'])}\n";
                        $templateDataLangRoute = $generatorService->searchTemplate($startRouteTable, $endRouteTable, 0, strlen($endRouteTable), $templateDataLangReal);
                        $templateDataLangReal = str_replace($templateDataLangRoute, '', $templateDataLangReal);
                    }

                    if ($nameLang === 'table') {
                        $quoteTable = "'" . $tableName . "' => [";
                        $templateDataLangTable = $this->serviceGenerator->searchTemplate($quoteTable, '],', 0, 4, $templateDataLangReal);
                        $templateDataLangReal = str_replace($templateDataLangTable, '', $templateDataLangReal);
                    }
                    $fileService->createFileReal(config('generator.path.laravel.lang') . $key . '/' . $nameLang . '.php', $templateDataLangReal);
                }
            }
            // END - search lang

            // START - api route VueJS
            $pathApiRouteVueJSReal = config('generator.path.vuejs.router') . 'index.js';
            $templateDataApiRouteVueJSReal = $this->serviceGenerator->getFile('router', 'vuejs', 'index.js');
            $templateDataApiRouteVueJSReal = str_replace(
                "import {$generatorService->modelNameNotPluralFe($model['name'])} from './modules/{$generatorService->nameAttribute($model['name'])}';\n",
                '',
                $templateDataApiRouteVueJSReal
            );
            $templateDataApiRouteVueJSReal = str_replace("{$generatorService->modelNameNotPluralFe($model['name'])},\n", '', $templateDataApiRouteVueJSReal);
            $fileService->createFileReal($pathApiRouteVueJSReal, $templateDataApiRouteVueJSReal);
            // END - api route VueJS

            $generator->delete();

            return $this->jsonMessage(trans('messages.success'));
        } catch (\Exception $e) {
            return $this->jsonError($e);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkModel(Request $request): JsonResponse
    {
        $serviceGenerator = new GeneratorService();
        $name = $request->get('name', '');
        try {
            if ($name) {
                $name = $serviceGenerator->tableName($name);
                if (Schema::hasTable($name)) {
                    //table exist
                    return $this->jsonMessage(1);
                }
                // table not exist
                return $this->jsonMessage(2);
            }
            //name null
            return $this->jsonMessage(3);
        } catch (\Exception $e) {
            return $this->jsonError($e);
        }
    }

    /**
     * @param StoreGeneratorRelationshipRequest $request
     * @return JsonResponse
     */
    public function generateRelationship(StoreGeneratorRelationshipRequest $request): JsonResponse
    {
        try {
            $relationship = $request->get('relationship');
            $model = $request->get('model');
            $modelCurrent = $request->get('model_current');
            $column = $request->get('column');
            $column2 = $request->get('column2');
            $options = $request->get('options', []);
            // git commit
            $this->_gitCommit($model);
            new RelationshipGenerator($relationship, $model, $modelCurrent, $column, $column2, $options);
            new SwaggerRelationshipGenerator($relationship, $model, $modelCurrent);
            $this->_runCommand();

            return $this->jsonMessage(trans('messages.success'));
        } catch (\Exception $e) {
            return $this->jsonError($e);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function generateDiagram(Request $request): JsonResponse
    {
        try {
            $model = $request->get('model');
            $diagram = $this->serviceGenerator->getRelations($model);

            return $this->jsonData($diagram);
        } catch (\Exception $e) {
            return $this->jsonError($e);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getModels(Request $request): JsonResponse
    {
        try {
            $table = $request->get('model', []);
            $table = json_decode($table, true);
            $modelTable = $table['name'];
            $pathModel = config('generator.path.laravel.model');
            $ignoreModel = config('generator.relationship.ignore_model');
            $models = \File::files($pathModel);
            $modelData = [];
            foreach ($models as $model) {
                $modelName = $model->getBasename('.php');
                if ($modelName !== $modelTable) {
                    if (!in_array($modelName, $ignoreModel)) {
                        $modelData[] = $modelName;
                    }
                }
            }
            return $this->jsonData($modelData);
        } catch (\Exception $e) {
            return $this->jsonError($e);
        }
    }

    /**
     * @return JsonResponse
     */
    public function getAllModels(): JsonResponse
    {
        try {
            $whiteList = ['BaseModel', 'Generator'];
            $allFiles = \File::allFiles(app_path('Models'));
            $files = [];
            foreach ($allFiles as $key => $file) {
                $model = basename($file->getFilename(), '.php');
                !in_array($model, $whiteList) && ($files[] = $model);
            }

            return $this->jsonData($files);
        } catch (\Exception $e) {
            return $this->jsonError($e);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getColumns(Request $request): JsonResponse
    {
        try {
            $table = $request->get('table');
            $table = \Str::snake(\Str::plural($table));
            $columns = \Schema::getColumnListing($table);

            return $this->jsonData($columns);
        } catch (\Exception $e) {
            return $this->jsonError($e);
        }
    }

    /**
     * @param $fields
     * @param $model
     * @return array
     */
    private function _generateBackend($fields, $model): array
    {
        $migrationGenerator = new MigrationGenerator($fields, $model);
        new ControllerGenerator($fields, $model);
        new SeederGenerator($fields, $model);
        new ModelGenerator($fields, $model);
        new RepositoryGenerator($model);
        new LangGenerator($fields, $model);
        new RouteGenerator($model);
        new RequestGenerator($fields, $model);
        new SwaggerGenerator($fields, $model);

        return [
            'migration' => [
                'file' => $migrationGenerator->file,
            ],
        ];
    }

    /**
     * @param $fields
     * @param $model
     */
    private function _generateFrontend($fields, $model)
    {
        new RouteGeneratorFe($model);
        new ApiGenerator($model);
        new ViewTableGenerator($fields, $model);
        new FormGenerator($fields, $model);
        new FormHandlerGenerator($fields, $model);
    }

    /**
     * @param $model
     * @param $generateBackend
     * @return array
     */
    private function _generateFile($model, $generateBackend): array
    {
        $files = [];
        $configGeneratorLaravel = config('generator')['path']['delete_files']['laravel'];
        $configGeneratorVueJS = config('generator')['path']['delete_files']['vuejs'];

        $files['api_controller'] = $configGeneratorLaravel['api_controller'] . $model['name'] . 'Controller.php';
        $files['request'] = $configGeneratorLaravel['request'] . 'Store' . $model['name'] . 'Request.php';
        $files['swagger'] = $configGeneratorLaravel['swagger'] . $model['name'] . '.php';
        $files['model'] = $configGeneratorLaravel['model'] . $model['name'] . '.php';
        $files['repositories']['interface'] = $configGeneratorLaravel['repositories'] . $model['name'] . '/' . $model['name'] . 'Interface.php';
        $files['repositories']['repository'] = $configGeneratorLaravel['repositories'] . $model['name'] . '/' . $model['name'] . 'Repository.php';
        $files['migration'] = $configGeneratorLaravel['migration'] . $generateBackend['migration']['file'];
        $files['seeder'] = $configGeneratorLaravel['seeder'] . $model['name'] . 'TableSeeder.php';

        $files['api'] = $configGeneratorVueJS['api'] . $this->serviceGenerator->folderPages($model['name']) . '.js';
        $files['router_modules'] = $configGeneratorVueJS['router_modules'] . $this->serviceGenerator->folderPages($model['name']) . '.js';
        $files['views']['form'] = $configGeneratorVueJS['views'] . lcfirst(\Str::kebab($model['name'])) . '/Form.vue';
        $files['views']['index'] = $configGeneratorVueJS['views'] . lcfirst(\Str::kebab($model['name'])) . '/index.vue';

        return $files;
    }

    /**
     * @param $generator
     * @param $model
     * @param $updateFields
     */
    private function _generateBackendUpdate($generator, $model, $updateFields)
    {
        new MigrationUpdateGenerator($generator, $model, $updateFields);
        new ModelUpdateGenerator($model, $updateFields);
        new SeederUpdateGenerator($generator, $model, $updateFields);
        new ControllerUpdateGenerator($model, $updateFields);
        new LangUpdateGenerator($model, $updateFields);
        new RequestUpdateGenerator($generator, $model, $updateFields);
        new SwaggerUpdateGenerator($generator, $model, $updateFields);
    }

    /**
     * @param $generator
     * @param $model
     * @param $updateFields
     */
    private function _generateFrontendUpdate($generator, $model, $updateFields)
    {
        new ViewTableUpdateGenerator($generator, $model, $updateFields);
        new FormUpdateGenerator($generator, $model, $updateFields);
    }

    /**
     * @param array $model
     */
    private function _runCommand(array $model = [])
    {
        if (!isset($model['options'])) {
            $model['options'] = [];
        }
        if (!$this->serviceGenerator->getOptions(config('generator.model.options.ignore_migrate'), $model['options'])) {
            Artisan::call('migrate --force');
        }
        $basePath = base_path();
        Artisan::call('vue-i18n:generate');
        exec("cd $basePath && ./swagger.sh");
        exec("cd $basePath && composer dump-autoload");
        // php artisan generate:erd /Applications/MAMP/htdocs/tanmnt/larajs/resources/js/assets/images/diagram-erd.png
        //        $resourcePath = resource_path('js/assets/images/diagram-erd.png');
        //        exec("cd $basePath && php artisan generate:erd $resourcePath");
        //        $this->_gitResetHEAD();
    }

    private function _exportDataGenerator()
    {
        $generators = Generator::where('table', '!=', 'users')
            ->get()
            ->toArray();
        $template = 'INSERT INTO `generators` VALUES ';
        foreach ($generators as $index => $generator) {
            $template .=
                "({$generator['id']},'" .
                $generator['field'] .
                "','" .
                $generator['model'] .
                "','" .
                $generator['table'] .
                "','" .
                $generator['files'] .
                "','" .
                Carbon::parse($generator['created_at'])->toDateTimeString() .
                "','" .
                Carbon::parse($generator['updated_at'])->toDateTimeString() .
                "','" .
                $generator['deleted_at']
                    ? Carbon::parse($generator['deleted_at'])->toDateTimeString()
                    : null . "')";
            if ($index !== count($generators) - 1) {
                $template .= ',';
            }
        }
        $disk = \Storage::disk('local');
        $fileName = env('DB_DATABASE') . '-' . date('YmdHis') . '.sql';
        $disk->put("/backup/generators/$fileName", $template);
        $files = $disk->files('/backup/generators');
        $numberFileDeletes = count($files) - Generator::NUMBER_FILE_DELETES;
        if ($numberFileDeletes > 0) {
            for ($i = 0; $i < $numberFileDeletes; $i++) {
                $disk->delete($files[$i]);
            }
        }
    }

    /**
     * @param $model
     */
    private function _gitCommit($model)
    {
        $basePath = base_path();
        $now = \Carbon\Carbon::now()->toDateTimeString();
        $commit = '"' . $model . ' - ' . $now . '"';

        $gitAdd = new Process(['git', 'add', '.'], $basePath);
        $gitAdd->run();
        $gitCommit = new Process(['git', 'commit', '-m', $commit, '--no-verify'], $basePath);
        $gitCommit->run();
    }

    private function _gitResetHEAD()
    {
        $basePath = base_path();
        $gitResetHEAD = new Process(['git', 'reset', 'HEAD^'], $basePath);

        $gitResetHEAD->run();
        if (!$gitResetHEAD->isSuccessful()) {
            throw new ProcessFailedException($gitResetHEAD);
        }
    }
}
