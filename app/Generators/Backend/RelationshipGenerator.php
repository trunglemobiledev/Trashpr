<?php

namespace App\Generators\Backend;

use App\Generators\BaseGenerator;
use Carbon\Carbon;

class RelationshipGenerator extends BaseGenerator
{
    public const REF_UPPER = 'Ref';
    public const _REF_LOWER = 'ref_';
    public const SORT_COLUMN = 'sortable="custom"';
    public const _ID = '_id';

    /** @var string */
    protected $relationship;

    /** @var array */
    protected array $tableCurrent;

    /** @var array */
    protected array $tableDiff;

    public function __construct($relationship, $model, $modelCurrent, $column, $column2, $options)
    {
        parent::__construct();
        $this->path = config('generator.path.laravel.migration');
        $this->notDelete = config('generator.not_delete.laravel.model');
        $this->relationship = config('generator.relationship.relationship');

        // check datatable
        //        $tableCurrent = Generator::where('table', $this->serviceGenerator->tableName($modelCurrent))->first();
        //        $this->tableCurrent = json_decode($tableCurrent->model, true);
        //        $tableDiff = Generator::where('table', $this->serviceGenerator->tableName($model))->first();
        //        $this->tableDiff = json_decode($tableDiff->model, true);
        // end check datatable

        $this->generate($relationship, $model, $modelCurrent, $column, $column2, $options);
    }

    private function generate($relationship, $model, $modelCurrent, $column, $column2, $options)
    {
        $pathTemplate = 'Models/';
        $template = $this->serviceGenerator->get_template('relationship', $pathTemplate);
        // Model Relationship
        if ($relationship === $this->relationship['has_one']) {
            $templateModel = str_replace('{{FUNCTION_NAME}}', \Str::camel($model), $template);
            $templateInverse = str_replace('{{FUNCTION_NAME}}', \Str::camel($modelCurrent), $template);
        } elseif ($relationship === $this->relationship['has_many']) {
            $templateModel = str_replace('{{FUNCTION_NAME}}', $this->serviceGenerator->modelNamePluralFe($model), $template);
            $templateInverse = str_replace('{{FUNCTION_NAME}}', \Str::camel($modelCurrent), $template);
        } else {
            $templateModel = str_replace('{{FUNCTION_NAME}}', $this->serviceGenerator->modelNamePluralFe($model), $template);
            $templateInverse = str_replace('{{FUNCTION_NAME}}', $this->serviceGenerator->modelNamePluralFe($modelCurrent), $template);
        }
        $templateModel = str_replace('{{RELATION}}', $relationship, $templateModel);
        $templateModel = str_replace('{{RELATION_MODEL_CLASS}}', $model, $templateModel);
        //ModelCurrent Relationship

        $templateInverse = str_replace('{{RELATION_MODEL_CLASS}}', $modelCurrent, $templateInverse);
        if ($relationship === $this->relationship['belongs_to_many']) {
            $templateInverse = str_replace('{{RELATION}}', 'belongsToMany', $templateInverse);
            $templateModel = str_replace(
                '{{FIELD_RELATIONSHIP}}',
                "'" . self::_REF_LOWER . \Str::snake($modelCurrent) . '_' . \Str::snake($model) . "', '" . \Str::snake($modelCurrent) . "_id', '" . \Str::snake($model) . "_id'",
                $templateModel
            );
            $templateModel = str_replace(", 'id'", '', $templateModel);
            $templateInverse = str_replace(
                '{{FIELD_RELATIONSHIP}}',
                "'" . self::_REF_LOWER . \Str::snake($modelCurrent) . '_' . \Str::snake($model) . "', '" . \Str::snake($model) . "_id', '" . \Str::snake($modelCurrent) . "_id'",
                $templateInverse
            );
            $templateInverse = str_replace(", 'id'", '', $templateInverse);
        } else {
            $templateModel = str_replace('{{FIELD_RELATIONSHIP}}', "'" . \Str::snake($modelCurrent) . self::_ID . "'", $templateModel);
            $templateInverse = str_replace('{{FIELD_RELATIONSHIP}}', "'" . \Str::snake($modelCurrent) . self::_ID . "'", $templateInverse);
            $templateInverse = str_replace('{{RELATION}}', 'belongsTo', $templateInverse);
        }
        $this->_migrateRelationship($relationship, $model, $modelCurrent, $column, $column2, $options);
        //replace file model real
        $templateModelReal = $this->serviceGenerator->getFile('model', 'laravel', $model . '.php');
        $this->_replaceFile($model, $templateInverse, $templateModelReal);
        //replace file model current real
        $templateModelCurrentReal = $this->serviceGenerator->getFile('model', 'laravel', $modelCurrent . '.php');
        $this->_replaceFile($modelCurrent, $templateModel, $templateModelCurrentReal);
    }

    private function _migrateRelationship($relationship, $model, $modelCurrent, $column, $column2, $options)
    {
        $now = Carbon::now();
        $pathTemplate = 'Databases/Migrations/';
        $templateData = $this->serviceGenerator->get_template('migrationRelationship', $pathTemplate);
        $templateData = str_replace('{{DATE_TIME}}', $now->toDateTimeString(), $templateData);
        if ($relationship === $this->relationship['belongs_to_many']) {
            //belongsToMany
            $templateData = $this->serviceGenerator->get_template('migrationRelationshipMTM', $pathTemplate);
            //if belongsToMany replace table to create
            $templateData = $this->_replaceTemplateRelationshipMTM($model, $modelCurrent, $templateData);
            $fileName = date('Y_m_d_His') . '_relationship_' . self::_REF_LOWER . \Str::snake($modelCurrent) . '_' . \Str::snake($model) . '_table.php';
            $this->_generateModelMTM($model, $modelCurrent);
            $this->_generateSeederMTM($model, $modelCurrent);
            $this->_generateRoute($modelCurrent);
            $this->_generateRoute($model);
            $this->_generateController($modelCurrent, $model, $options, $column, $relationship);
            $this->_generateController($model, $modelCurrent, $options, $column2, $relationship);
            //generate frontend
            $this->_generateIndexTableFe($modelCurrent, $column2, $options, \Str::snake($model), $relationship);
            $this->_generateIndexTableFe($model, $column, $options, \Str::snake($modelCurrent), $relationship);

            $this->_generateFormFe($modelCurrent, $model, $column, $relationship);
            $this->_generateFormFe($model, $modelCurrent, $column2, $relationship);
        } else {
            //hasOne or hasMany
            $templateData = $this->_replaceTemplateRelationship($model, $modelCurrent, $templateData);
            $fileName = date('Y_m_d_His') . '_relationship_' . $this->serviceGenerator->tableName($modelCurrent) . '_' . $this->serviceGenerator->tableName($model) . '_table.php';
            $this->_generateModel($modelCurrent, $model);
            $this->_generateSeeder($modelCurrent, $model);
            $this->_generateRoute($modelCurrent);
            $this->_generateController($modelCurrent, $model, $options, $column, $relationship);
            //generate frontend
            $this->_generateIndexTableFe($model, $column, $options, \Str::snake($modelCurrent), $relationship);
            $this->_generateFormFe($modelCurrent, $model, $column, $relationship);
        }

        $this->serviceFile->createFile($this->path, $fileName, $templateData);
    }

    private function _generateFormFe($model, $modelRelationship, $columnRelationship, $relationship)
    {
        $notDelete = config('generator.not_delete.vuejs.form');
        $fileName = $this->serviceGenerator->folderPages($modelRelationship) . '/Form.vue';
        $templateDataReal = $this->serviceGenerator->getFile('views', 'vuejs', $fileName);
        $dataForm = 'form:';
        //create form
        $templateDataForm = $this->serviceGenerator->searchTemplateX($dataForm, 1, $notDelete['this_check'], strlen($dataForm), -strlen($dataForm) - 4, $templateDataReal);
        $dataForms = explode(',', trim($templateDataForm));
        $fieldsGenerateDataForm = [];
        foreach ($dataForms as $form) {
            if (strlen($form) > 0) {
                $form = trim($form);
                [$keyForm, $valForm] = array_pad(explode(':', $form, 2), 2, '');
                $name = $keyForm . ":$valForm,";
                $fieldsGenerateDataForm[] = $name;
            }
        }
        $columnDidGenerate = \Str::snake($model) . self::_ID . ": '',";
        $fieldsGenerateDataForm[] = $columnDidGenerate;
        $templateDataReal = str_replace($templateDataForm, ltrim($this->replaceTemplate($fieldsGenerateDataForm, 2, 3, 2, 0), PHP_EOL), $templateDataReal);
        //create form item
        $templateDataReal = $this->serviceGenerator->replaceNotDelete(
            $notDelete['item'],
            $this->_generateSelect(\Str::snake($model), \Str::snake($model) . self::_ID, $columnRelationship, $relationship),
            3,
            $templateDataReal
        );

        //create rules
        if ($relationship !== $this->relationship['belongs_to_many']) {
            $templateRules = $this->getHandlerTemplate('rules');
            $templateRules = str_replace('{{$FIELD$}}', \Str::snake($model) . self::_ID, $templateRules);
            $templateRules = str_replace('{{$ATTRIBUTE_FIELD$}}', 'this.$t(\'route.' . \Str::snake($model) . '\')', $templateRules);
            $templateDataReal = $this->serviceGenerator->replaceNotDelete($notDelete['rules'], $templateRules, 2, $templateDataReal);
        }
        //generate api
        $this->_generateApi($model);
        //add generate api
        $templateDataReal = $this->_generateAddApi($model, $modelRelationship, $templateDataReal, $notDelete);
        $fileName = config('generator.path.vuejs.views') . $fileName;
        $this->serviceFile->createFileReal($fileName, $templateDataReal);
        return $templateDataReal;
    }

    private function _generateAddApi($model, $modelRelationship, $templateDataReal, $notDelete)
    {
        $stubGetData = $this->serviceGenerator->get_template('getDataRelationship', 'Handler/', 'vuejs');
        $stubGetData = str_replace('{{$MODEL$}}', \Str::camel($model), $stubGetData);
        $stubGetData = str_replace('{{$MODEL_RELATIONSHIP$}}', \Str::camel($model), $stubGetData);
        $stubGetData = str_replace('{{$MODEL_UPPERCASE$}}', ucfirst(\Str::camel($model)), $stubGetData);
        $templateDataReal = $this->serviceGenerator->replaceNotDelete($notDelete['created'], $stubGetData, 0, $templateDataReal, 2);
        $templateDataReal = $this->serviceGenerator->replaceNotDelete($notDelete['data'], \Str::camel($model) . 'List: [],', 3, $templateDataReal, 2);
        $importStub =
            'import ' .
            $this->serviceGenerator->modelNameNotPlural($model) .
            'Resource' .
            " from '@/api/" .
            env('API_VERSION_GENERATOR', 'v1') .
            '/' .
            $this->serviceGenerator->nameAttribute($model) .
            "';";
        if (!stripos($templateDataReal, $importStub)) {
            $templateDataReal = $this->serviceGenerator->replaceNotDelete($notDelete['import_component'], $importStub, 0, $templateDataReal, 2);
            //relationship
            $stubRelationship = 'const ' . \Str::camel($model) . 'Resource = new ' . $this->serviceGenerator->modelNameNotPlural($model) . 'Resource();';
            // current
            $stubRCurrent = 'const ' . \Str::camel($modelRelationship) . 'Resource = new ' . $this->serviceGenerator->modelNameNotPlural($modelRelationship) . 'Resource();';
            $templateDataReal = str_replace($stubRCurrent, $stubRCurrent . $this->serviceGenerator->infy_nl_tab(1, 0) . $stubRelationship, $templateDataReal);
        }
        return $templateDataReal;
    }

    private function _generateApi($model)
    {
        $checkFuncName = 'get' . $model;
        $notDelete = config('generator.not_delete.vuejs.form');
        $fileName = $this->serviceGenerator->folderPages($model) . '.js';
        $templateDataReal = $this->serviceGenerator->getFile('api', 'vuejs', $fileName);
        if (strpos($templateDataReal, $checkFuncName)) {
            return $templateDataReal;
        }
        $stubAPI = $this->serviceGenerator->get_template('apiRelationship', 'Api/', 'vuejs');
        $templateAPI = str_replace('{{$FUNCTION$}}', $model, $stubAPI);
        $templateAPI = str_replace('{{$MODEL$}}', $this->serviceGenerator->urlResource($model), $templateAPI);
        $templateAPI = str_replace('{{$API_VERSION$}}', env('API_VERSION_GENERATOR', 'v1'), $templateAPI);
        $templateAPI = str_replace('{{$MODEL_RELATIONSHIP$}}', $this->serviceGenerator->urlResource($model), $templateAPI);
        $templateDataReal = $this->serviceGenerator->replaceNotDelete($notDelete['api'], $templateAPI, 1, $templateDataReal, 2);
        //check import
        $importStub = "import request from '@/utils/request';";
        $resourceStub = "import Resource from '@/api/resource';";
        $checkImport = strpos($templateDataReal, $importStub);
        if (!$checkImport) {
            $templateDataReal = str_replace($resourceStub, $resourceStub . $this->serviceGenerator->infy_nl_tab(1, 0) . $importStub, $templateDataReal);
        }

        $this->serviceFile->createFile(config('generator.path.vuejs.api'), $fileName, $templateDataReal);
        return $templateDataReal;
    }

    private function _generateIndexTableFe($modelRelationship, $columnRelationship, $options, $funcName, $relationship)
    {
        $configOptions = config('generator.relationship.options');
        $notDelete = config('generator.not_delete.vuejs.views');
        $fileName = $this->serviceGenerator->folderPages($modelRelationship) . '/index.vue';
        $templateDataReal = $this->serviceGenerator->getFile('views', 'vuejs', $fileName);
        $pathTemplate = 'Handler/';

        if (in_array($configOptions['show'], $options)) {
            if ($relationship === $this->relationship['belongs_to_many']) {
                $templateTableColumn = $this->serviceGenerator->get_template('tableTagRelationshipMTM', $pathTemplate, 'vuejs');
                $fileNameTag = $funcName . '.' . $columnRelationship;
                $templateTableColumn = str_replace('{{$FIELD_NAME$}}', $fileNameTag, $templateTableColumn);
                $templateTableColumn = str_replace('{{$TABLE_MODEL_CLASS$}}', $funcName, $templateTableColumn);
                $templateTableColumn = str_replace('{{$ALIGN$}}', 'left', $templateTableColumn);
                $templateTableColumn = str_replace('{{$MODEL_RELATIONSHIP$}}', $this->serviceGenerator->tableName($funcName), $templateTableColumn);
                $templateTableColumn = str_replace('{{$COLUMN_DISPLAY$}}', $columnRelationship, $templateTableColumn);
            } else {
                $templateTableColumn = $this->serviceGenerator->get_template('tableColumnRelationship', $pathTemplate, 'vuejs');
                $templateTableColumn = str_replace('{{$FIELD_NAME_RELATIONSHIP$}}', $funcName . self::_ID, $templateTableColumn);
                $templateTableColumn = str_replace('{{$MODEL_RELATIONSHIP$}}', $this->serviceGenerator->tableNameNotPlural($funcName), $templateTableColumn);
                $templateTableColumn = str_replace('{{$FIELD_NAME$}}', $columnRelationship, $templateTableColumn);
                $templateTableColumn = str_replace('{{$TABLE_MODEL_CLASS$}}', $funcName, $templateTableColumn);
                $templateTableColumn = str_replace('{{$ALIGN$}}', 'left', $templateTableColumn);
            }

            if (in_array($configOptions['sort'], $options)) {
                $templateTableColumn = str_replace('{{$SORT$}}', self::SORT_COLUMN, $templateTableColumn);
            } else {
                $templateTableColumn = str_replace('{{$SORT$}}', '', $templateTableColumn);
            }
            $templateDataReal = $this->serviceGenerator->replaceNotDelete($notDelete['templates'], $templateTableColumn, 6, $templateDataReal, 2);
            // replace file
            $fileName = config('generator.path.vuejs.views') . $fileName;
            $this->serviceFile->createFileReal($fileName, $templateDataReal);
        }
    }

    private function _generateOptions($modelRelationship, $options, $templateDataReal, $columnRelationship, $relationship)
    {
        $configOptions = config('generator.relationship.options');
        foreach ($options as $option) {
            if ($option === $configOptions['show']) {
                $columnsWith = '$queryService->withRelationship = [';
                $templateColumnWith = $this->serviceGenerator->searchTemplate($columnsWith, '];', 0, 0, $templateDataReal);
                if (!$templateColumnWith) {
                    return false;
                }
                $commaColumnWith = ',';
                if (\Str::endsWith($templateColumnWith, ',') || strlen($templateColumnWith) === strlen($columnsWith)) {
                    $commaColumnWith = '';
                }
                if ($relationship === $this->relationship['has_one'] || $relationship === $this->relationship['has_many']) {
                    $withRelationship = "'" . $this->serviceGenerator->modelNameNotPluralFe($modelRelationship) . "'";
                } else {
                    $withRelationship = "'" . $this->serviceGenerator->modelNamePluralFe($modelRelationship) . "'";
                }

                $templateDataReal = str_replace("$templateColumnWith]", "{$templateColumnWith}{$commaColumnWith}{$withRelationship}]", $templateDataReal);
            } elseif ($option === $configOptions['search']) {
                $columnSearch = '$queryService->columnSearch = [';
                $templateColumnSearch = $this->serviceGenerator->searchTemplate($columnSearch, '];', 0, 0, $templateDataReal);
                if (!$templateColumnSearch) {
                    return false;
                }
                $commaSearch = ',';
                if (\Str::endsWith($templateColumnSearch, ',') || strlen($templateColumnSearch) === strlen($columnSearch)) {
                    $commaSearch = '';
                }
                if ($relationship === $this->relationship['belongs_to_many']) {
                    $columnDidGenerate = "'" . \Str::camel($modelRelationship) . '.' . $columnRelationship . "'";
                } else {
                    $columnDidGenerate = "'" . \Str::snake($modelRelationship) . self::_ID . "'";
                }
                $templateDataReal = str_replace("$templateColumnSearch]", "{$templateColumnSearch}{$commaSearch}{$columnDidGenerate}]", $templateDataReal);
            }
        }
        return $templateDataReal;
    }

    private function _generateController($modelRelationship, $model, $options, $column, $relationship)
    {
        $notDelete = config('generator.not_delete.laravel.controller');
        $pathTemplate = 'Controllers/';
        $fileName = $model . 'Controller.php';
        $templateDataReal = $this->serviceGenerator->getFile('api_controller', 'laravel', $fileName);
        //if belongs_to_many
        if ($relationship === $this->relationship['belongs_to_many']) {
            $templateCreateUpdate = $this->serviceGenerator->get_template('createUpdateRelationship', $pathTemplate);
            //replace create or update
            $paramCreateUpdateStub = $this->serviceGenerator->modelNameNotPluralFe($modelRelationship) . 'Id';
            $templateCreateUpdate = str_replace('{{FIELD_MODEL_ID}}', $paramCreateUpdateStub, $templateCreateUpdate);
            $templateCreateUpdate = str_replace('{{SNAKE_FIELD_MODEL_ID}}', $this->serviceGenerator->tableNameNotPlural($modelRelationship) . self::_ID, $templateCreateUpdate);
            $templateCreateUpdate = str_replace('{{SNAKE_FIELD_MODEL_ID}}', $this->serviceGenerator->tableNameNotPlural($modelRelationship) . self::_ID, $templateCreateUpdate);
            $templateCreateUpdate = str_replace('{{MODEL}}', $this->serviceGenerator->modelNameNotPluralFe($model), $templateCreateUpdate);
            $templateCreateUpdate = str_replace('{{MODEL_RELATIONSHIP}}', $this->serviceGenerator->modelNamePluralFe($modelRelationship), $templateCreateUpdate);
            $templateCreate = str_replace('{{ATTACH_ASYNC}}', 'attach', $templateCreateUpdate);
            $templateUpdate = str_replace('{{ATTACH_ASYNC}}', 'sync', $templateCreateUpdate);
            //replace create
            $templateDataReal = $this->serviceGenerator->replaceNotDelete($notDelete['relationship_mtm_create'], $templateCreate, 3, $templateDataReal);
            //replace update
            $templateDataReal = $this->serviceGenerator->replaceNotDelete($notDelete['relationship_mtm_update'], $templateUpdate, 3, $templateDataReal);
            //replace show
            $templateShow = $this->serviceGenerator->get_template('showRelationship', $pathTemplate);
            $templateShow = str_replace('{{MODEL}}', $this->serviceGenerator->modelNameNotPluralFe($model), $templateShow);
            $templateShow = str_replace('{{SNAKE_MODEL_RELATIONSHIP_ID}}', $this->serviceGenerator->tableNameNotPlural($modelRelationship) . self::_ID, $templateShow);
            $templateShow = str_replace('{{MODEL_RELATIONSHIP}}', $this->serviceGenerator->modelNamePluralFe($modelRelationship), $templateShow);
            $templateDataReal = $this->serviceGenerator->replaceNotDelete($notDelete['relationship_mtm_show'], $templateShow, 3, $templateDataReal);
            //replace delete
            $templateDelete = $this->serviceGenerator->get_template('deleteRelationship', $pathTemplate);
            $templateDelete = str_replace('{{MODEL}}', $this->serviceGenerator->modelNameNotPluralFe($model), $templateDelete);
            $templateDelete = str_replace('{{MODEL_RELATIONSHIP}}', $this->serviceGenerator->modelNamePluralFe($modelRelationship), $templateDelete);
            $templateDataReal = $this->serviceGenerator->replaceNotDelete($notDelete['relationship_mtm_delete'], $templateDelete, 3, $templateDataReal);
        }
        //generate options
        $templateDataReal = $this->_generateOptions($modelRelationship, $options, $templateDataReal, $column, $relationship);
        $path = config('generator.path.laravel.api_controller');
        $fileName = $path . $fileName;
        $this->serviceFile->createFileReal($fileName, $templateDataReal);
        //generate controller
        $fileNameFunc = $modelRelationship . 'Controller.php';
        $templateDataRealFunc = $this->serviceGenerator->getFile('api_controller', 'laravel', $fileNameFunc);
        if (!stripos($templateDataRealFunc, 'get' . $modelRelationship)) {
            $templateDataFunc = $this->serviceGenerator->get_template('relationship', $pathTemplate);
            $templateDataFunc = str_replace('{{MODEL_RELATIONSHIP}}', $modelRelationship, $templateDataFunc);
            $templateDataFunc = str_replace('{{PARAM_MODEL_RELATIONSHIP}}', $this->serviceGenerator->modelNamePluralFe($modelRelationship), $templateDataFunc);
            $templateDataRealFunc = $this->serviceGenerator->replaceNotDelete($notDelete['relationship'], $templateDataFunc, 1, $templateDataRealFunc);
            $fileNameFunc = $path . $fileNameFunc;
            $this->serviceFile->createFileReal($fileNameFunc, $templateDataRealFunc);
        }
    }

    private function _generateRoute($modelRelationship)
    {
        $templateDataReal = $this->serviceGenerator->getFile('api_routes', 'laravel');
        if (!stripos($templateDataReal, 'get' . $modelRelationship)) {
            $stubResource = "Route::apiResource('{{RESOURCE}}', '{{MODEL_CLASS}}Controller');";
            $stubRoute = "Route::get('/{{MODEL}}/get-{{MODEL_RELATIONSHIP}}', '{{CONTROLLER}}Controller@get{{ACTION}}');";
            $templateResource = str_replace('{{RESOURCE}}', $this->serviceGenerator->urlResource($modelRelationship), $stubResource);
            $templateResource = str_replace('{{MODEL_CLASS}}', $modelRelationship, $templateResource);
            $templateRoute = str_replace('{{MODEL}}', $this->serviceGenerator->urlResource($modelRelationship), $stubRoute);
            $templateRoute = str_replace('{{MODEL_RELATIONSHIP}}', $this->serviceGenerator->urlResource($modelRelationship), $templateRoute);
            $templateRoute = str_replace('{{CONTROLLER}}', $modelRelationship, $templateRoute);
            $templateRoute = str_replace('{{ACTION}}', $modelRelationship, $templateRoute);
            $templateDataReal = str_replace($templateResource, $templateRoute . $this->serviceGenerator->infy_nl_tab(1, 3) . $templateResource, $templateDataReal);
            $path = config('generator.path.laravel.api_routes');
            $this->serviceFile->createFileReal($path, $templateDataReal);
        }
    }

    private function _replaceFile($model, $templateModel, $templateReal)
    {
        $templateReal = $this->serviceGenerator->replaceNotDelete($this->notDelete['relationship'], $templateModel, 1, $templateReal);
        $path = config('generator.path.laravel.model') . $model . '.php';
        $this->serviceFile->createFileReal($path, $templateReal);
    }

    private function _replaceTemplateRelationship($model, $modelDif, $templateData)
    {
        $templateData = str_replace('{{TABLE_NAME_TITLE}}', \Str::plural($modelDif) . \Str::plural($model), $templateData);
        $templateData = str_replace('{{TABLE_NAME}}', $this->serviceGenerator->tableName($model), $templateData);
        $templateData = str_replace('{{FOREIGN_KEY}}', \Str::snake($modelDif) . self::_ID, $templateData);
        return str_replace('{{TABLE_FOREIGN_KEY}}', $this->serviceGenerator->tableName($modelDif), $templateData);
    }

    private function _replaceTemplateRelationshipMTM($model, $modelCurrent, $templateData)
    {
        $now = Carbon::now();
        $templateData = str_replace('{{DATE_TIME}}', $now->toDateTimeString(), $templateData);
        $templateData = str_replace('{{TABLE_NAME_TITLE}}', self::REF_UPPER . $modelCurrent . $model, $templateData);
        $templateData = str_replace('{{TABLE_NAME}}', self::_REF_LOWER . \Str::snake($modelCurrent) . '_' . \Str::snake($model), $templateData);
        $templateData = str_replace('{{FOREIGN_KEY_1}}', \Str::snake($model) . self::_ID, $templateData);
        $templateData = str_replace('{{FOREIGN_KEY_2}}', \Str::snake($modelCurrent) . self::_ID, $templateData);
        $templateData = str_replace('{{TABLE_FOREIGN_KEY_1}}', $this->serviceGenerator->tableName($model), $templateData);
        return str_replace('{{TABLE_FOREIGN_KEY_2}}', $this->serviceGenerator->tableName($modelCurrent), $templateData);
    }

    private function _generateModel($model, $modelRelationship)
    {
        $field = \Str::snake($model) . self::_ID;
        $fieldsGenerate = [];
        $fieldAble = 'protected $fillable = [';
        $templateDataReal = $this->serviceGenerator->getFile('model', 'laravel', $modelRelationship . '.php');
        $template = $this->serviceGenerator->searchTemplate($fieldAble, '];', strlen($fieldAble), -strlen($fieldAble), $templateDataReal);
        if (!$template) {
            return $templateDataReal;
        }
        $arTemplate = explode(',', trim($template));
        foreach ($arTemplate as $tpl) {
            if (strlen($tpl) > 0) {
                $fieldsGenerate[] = trim($tpl) . ',';
            }
        }
        $fieldsGenerate[] = "'" . $field . "',";
        $implodeString = implode($this->serviceGenerator->infy_nl_tab(1, 2), $fieldsGenerate);
        $templateDataReal = str_replace($template, $this->serviceGenerator->infy_nl_tab(1, 2) . $implodeString . $this->serviceGenerator->infy_nl_tab(1, 1), $templateDataReal);
        $this->_createFileAll('model', $modelRelationship, $templateDataReal);
        return $templateDataReal;
    }

    private function _generateModelMTM($model, $modelCurrent)
    {
        $fieldModel = \Str::snake($model) . self::_ID;
        $fieldModelCurrent = \Str::snake($modelCurrent) . self::_ID;
        $now = Carbon::now();
        $pathTemplate = 'Models/';
        $templateData = $this->serviceGenerator->get_template('model', $pathTemplate);
        $templateData = str_replace('{{DATE}}', $now->toDateTimeString(), $templateData);
        $templateData = str_replace('{{MODEL_CLASS}}', self::REF_UPPER . $modelCurrent . $model, $templateData);
        $arFields = ["'" . $fieldModel . "',", "'" . $fieldModelCurrent . "',"];
        $implodeFields = implode($this->serviceGenerator->infy_nl_tab(1, 2), $arFields);
        $templateData = str_replace('{{FIELDS}}', $implodeFields, $templateData);
        $templateData = str_replace('{{TABLE_NAME}}', self::_REF_LOWER . \Str::snake($modelCurrent) . '_' . \Str::snake($model), $templateData);
        $templateData = str_replace('{{CATS}}', '', $templateData);
        $fileName = self::REF_UPPER . $modelCurrent . $model . '.php';
        $path = config('generator.path.laravel.model');
        $this->serviceFile->createFile($path, $fileName, $templateData);

        return $templateData;
    }

    private function _generateSeeder($model, $modelRelationship)
    {
        $field = \Str::snake($model) . self::_ID;
        $notDelete = config('generator.not_delete.laravel.db');
        $fileName = $modelRelationship . 'TableSeeder.php';
        $templateDataReal = $this->serviceGenerator->getFile('seeder', 'laravel', $fileName);
        $fakerCreate = '$faker = \Faker\Factory::create();';
        $param = '$' . \Str::camel(\Str::plural($model));
        $fieldRelationship = $param . ' = \App\Models\\' . $model . "::all()->pluck('id')->toArray();";
        $templateDataReal = str_replace($fakerCreate, $fakerCreate . $this->serviceGenerator->infy_nl_tab(1, 2) . $fieldRelationship, $templateDataReal);
        $templateDataReal = $this->serviceGenerator->replaceNotDelete($notDelete['seeder'], "'" . $field . "' => " . '$faker->randomElement(' . $param . '),', 4, $templateDataReal);
        $this->_createFileAll('seeder', $modelRelationship . 'TableSeeder', $templateDataReal);
        return $templateDataReal;
    }

    private function _generateSeederMTM($model, $modelCurrent)
    {
        $now = Carbon::now();
        $notDelete = config('generator.not_delete.laravel.db');
        $fieldModel = \Str::snake($model) . self::_ID;
        $fieldModelCurrent = \Str::snake($modelCurrent) . self::_ID;
        $fileName = self::REF_UPPER . $modelCurrent . $model . 'TableSeeder.php';
        $pathTemplate = 'Databases/Seeds/';
        $templateData = $this->serviceGenerator->get_template('seeder', $pathTemplate);
        $fakerCreate = '$faker = \Faker\Factory::create();';
        $paramModel = '$' . \Str::camel(\Str::plural($model));
        $paramModelCurrent = '$' . \Str::camel(\Str::plural($modelCurrent));
        $fieldRelationshipModel = $paramModel . ' = \App\Models\\' . $model . "::all()->pluck('id')->toArray();";
        $fieldRelationshipModelCurrent = $paramModelCurrent . ' = \App\Models\\' . $modelCurrent . "::all()->pluck('id')->toArray();";
        $templateData = str_replace(
            $fakerCreate,
            $fakerCreate . $this->serviceGenerator->infy_nl_tab(1, 2) . $fieldRelationshipModel . $this->serviceGenerator->infy_nl_tab(1, 2) . $fieldRelationshipModelCurrent,
            $templateData
        );
        $templateData = str_replace('{{DATE_TIME}}', $now->toDateTimeString(), $templateData);
        $templateData = str_replace('{{TABLE_NAME_TITLE}}', self::REF_UPPER . $modelCurrent . $model, $templateData);
        $templateData = str_replace('{{MODEL_CLASS}}', self::REF_UPPER . $modelCurrent . $model, $templateData);
        $templateData = str_replace(
            '{{FIELDS}}',
            "'" .
                $fieldModel .
                "' => " .
                '$faker->randomElement(' .
                $paramModel .
                '),' .
                $this->serviceGenerator->infy_nl_tab(1, 4) .
                "'" .
                $fieldModelCurrent .
                "' => " .
                '$faker->randomElement(' .
                $paramModelCurrent .
                '),',
            $templateData
        );
        $templateData = str_replace($notDelete['seeder'], '', $templateData);
        $path = config('generator.path.laravel.seeder');
        $this->serviceFile->createFile($path, $fileName, $templateData);

        return $templateData;
    }

    private function _createFileAll($namePath, $model, $templateDataReal)
    {
        $path = config('generator.path.laravel.' . $namePath);
        $fileName = $path . $model . '.php';
        $this->serviceFile->createFileReal($fileName, $templateDataReal);
    }

    private function replaceTemplateHeading($fieldsGenerate, $tab)
    {
        return $this->serviceGenerator->infy_nl_tab(1, $tab) . implode($this->serviceGenerator->infy_nl_tab(1, 3), $fieldsGenerate) . $this->serviceGenerator->infy_nl_tab(1, $tab);
    }

    private function replaceTemplate($fieldsGenerate, $tabStart, $tabEnd, $tabFields, $space = 2)
    {
        return $this->serviceGenerator->infy_nl_tab(1, $tabStart) .
            implode($this->serviceGenerator->infy_nl_tab(1, $tabFields), $fieldsGenerate) .
            $this->serviceGenerator->infy_nl_tab(1, $tabEnd, $space);
    }

    private function _generateSelect($funcName, $field, $column, $relationship)
    {
        $pathTemplate = 'Forms/';
        if ($relationship === $this->relationship['belongs_to_many']) {
            $formTemplate = $this->serviceGenerator->get_template('selectMTM', $pathTemplate, 'vuejs');
        } else {
            $formTemplate = $this->serviceGenerator->get_template('select', $pathTemplate, 'vuejs');
        }
        $formTemplate = str_replace('{{$FORM_FIELD$}}', $field, $formTemplate);
        $formTemplate = str_replace('{{$LABEL_NAME_INPUT$}}', '$t(\'route.' . $funcName . '\')', $formTemplate);
        $formTemplate = str_replace('{{$PROP_NAME$}}', 'prop="' . $field . '"', $formTemplate);
        $formTemplate = str_replace('{{$LIST_SELECT$}}', \Str::camel($funcName), $formTemplate);
        $formTemplate = str_replace('{{$LABEL_OPTION$}}', 'item.' . $column, $formTemplate);
        return str_replace('{{$VALUE_OPTION$}}', 'item.id', $formTemplate);
    }

    private function getHandlerTemplate($nameForm)
    {
        $pathTemplate = 'Handler/';
        return $this->serviceGenerator->get_template($nameForm, $pathTemplate, 'vuejs');
    }
}
