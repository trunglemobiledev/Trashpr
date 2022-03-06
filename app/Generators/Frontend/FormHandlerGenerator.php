<?php

namespace App\Generators\Frontend;

use App\Generators\BaseGenerator;

class FormHandlerGenerator extends BaseGenerator
{
    public function __construct($fields, $model)
    {
        parent::__construct();
        $this->path = config('generator.path.vuejs.views');
        $this->notDelete = config('generator.not_delete.vuejs.form');

        $this->generate($fields, $model);
    }

    private function generate($fields, $model)
    {
        $dbType = config('generator.db_type');
        $defaultValue = config('generator.default_value');
        $folderName = $this->serviceGenerator->folderPages($model['name']);
        $fileNameReal = "views/$folderName/form.vue";
        $templateDataReal = $this->serviceGenerator->getFileReal($fileNameReal, 'vuejs');
        $flags = [
            'long_text' => true,
            'json' => true,
        ];
        foreach ($fields as $index => $field) {
            if ($index > 0) {
                if ($field['default_value'] === $defaultValue['none']) {
                    $templateRules = $this->getHandlerTemplate('rules');
                    $templateDataReal = $this->serviceGenerator->replaceNotDelete($this->notDelete['rules'], $templateRules, 4, $templateDataReal, 2);
                    $templateDataReal = $this->replaceField($field, $model, $templateDataReal);
                }
                if ($field['db_type'] === $dbType['enum']) {
                    $enum = '';
                    foreach ($field['enum'] as $keyEnum => $value) {
                        $value = is_numeric($value) ? $value : "'$value'";
                        if ($keyEnum === count($field['enum']) - 1) {
                            $enum .= $value;
                        } else {
                            $enum .= "$value,";
                        }
                    }
                    $name = $field['field_name'] . 'List: [' . $enum . '],';
                    $templateDataReal = $this->serviceGenerator->replaceNotDelete($this->notDelete['data'], $name, 3, $templateDataReal, 2);
                }
                // START - IMPORT FILE
                $importVuejs = config('generator.import.vuejs');
                if ($field['db_type'] === $dbType['longtext'] && $flags['long_text']) {
                    $templateDataReal = $this->serviceGenerator->replaceNotDelete($this->notDelete['import_component'], $importVuejs['tinymce']['file'], 0, $templateDataReal, 2);
                    $templateDataReal = $this->serviceGenerator->replaceNotDelete($this->notDelete['import_component_name'], $importVuejs['tinymce']['name'], 2, $templateDataReal, 2);
                    $flags['long_text'] = false;
                } elseif ($field['db_type'] === $dbType['json'] && $flags['json']) {
                    $templateDataReal = $this->serviceGenerator->replaceNotDelete($this->notDelete['import_component'], $importVuejs['json_editor']['file'], 0, $templateDataReal, 2);
                    $templateDataReal = $this->serviceGenerator->replaceNotDelete($this->notDelete['import_component_name'], $importVuejs['json_editor']['name'], 2, $templateDataReal, 2);
                    $flags['json'] = false;
                }
                // END - IMPORT FILE
            }
        }
        $pathReal = config('generator.path.vuejs.resource_js') . $fileNameReal;
        $this->serviceFile->createFileReal($pathReal, $templateDataReal);
    }

    private function getHandlerTemplate($nameForm)
    {
        $pathTemplate = 'Handler/';
        return $this->serviceGenerator->get_template($nameForm, $pathTemplate, 'vuejs');
    }

    private function replaceField($field, $model, $formTemplate)
    {
        $attribute = 'this.$t(\'table.' . $this->serviceGenerator->tableNameNotPlural($model['name']) . '.' . $field['field_name'] . "')";
        $formTemplate = str_replace('{{$ATTRIBUTE_FIELD$}}', $attribute, $formTemplate);
        return str_replace('{{$FIELD$}}', $field['field_name'], $formTemplate);
    }
}
