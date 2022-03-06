<?php

namespace App\Generators\FrontendUpdate;

use App\Generators\BaseGenerator;

class FormUpdateGenerator extends BaseGenerator
{
    public const TEMPLATE_END = '</el-form-item>';
    public const DATA_GENERATOR = 'data-generator=';
    public const DATA_FORM = 'form:';
    public const RULES = 'rules() {';

    /** @var string */
    protected string $labelNameForm;

    /** @var string */
    protected string $propNameForm;

    /** @var string */
    protected $dbType;

    /** @var string */
    protected $defaultValue;

    public function __construct($generator, $model, $updateFields)
    {
        parent::__construct();
        $this->path = config('generator.path.vuejs.views');
        $this->dbType = config('generator.db_type');
        $this->notDelete = config('generator.not_delete.vuejs.form');
        $this->defaultValue = config('generator.default_value');

        $this->generate($generator, $model, $updateFields);
    }

    private function generate($generator, $model, $updateFields)
    {
        $fileName = $this->serviceGenerator->folderPages($model['name']) . '/Form.vue';
        $templateDataReal = $this->serviceGenerator->getFile('views', 'vuejs', $fileName);
        $templateDataReal = $this->generateFieldsRename($updateFields['renameFields'], $templateDataReal);
        $templateDataReal = $this->generateFieldsDrop($updateFields['dropFields'], $templateDataReal);
        $templateDataReal = $this->generateFieldsChange($generator, $updateFields['changeFields'], $model, $templateDataReal);
        $templateDataReal = $this->generateFieldsUpdate($updateFields['updateFields'], $model, $templateDataReal);
        $templateDataReal = $this->importComponent($updateFields, $templateDataReal);
        $fileName = $this->path . $fileName;
        $this->serviceFile->createFileReal($fileName, $templateDataReal);
    }

    private function generateFieldsRename($renameFields, $templateDataReal)
    {
        if (!$renameFields) {
            return $templateDataReal;
        }

        $selfTemplateEnd = self::TEMPLATE_END;
        $selfDataForm = self::DATA_FORM;
        $selfRules = self::RULES;
        $fieldsGenerateDataForm = [];
        $arrayChange = \Arr::pluck($renameFields, 'field_name_old.field_name');
        $templateDataForm = $this->serviceGenerator->searchTemplateX($selfDataForm, 1, $this->notDelete['this_check'], strlen($selfDataForm), -strlen($selfDataForm) - 4, $templateDataReal);
        $templateRules = $this->serviceGenerator->searchTemplateX($selfRules, 1, $this->notDelete['rules'], 0, -strlen($selfRules) - strlen($selfRules), $templateDataReal);

        $templateRulesTemp = $templateRules;
        $dataForms = explode(',', trim($templateDataForm));

        foreach ($renameFields as $rename) {
            //replace template form item
            $selfTemplateStart = self::DATA_GENERATOR;
            $selfTemplateStart .= '"' . $rename['field_name_old']['field_name'] . '"';
            $templateFormItem = $this->serviceGenerator->searchTemplateX(
                $selfTemplateStart,
                1,
                $selfTemplateEnd,
                -strlen($selfTemplateStart) * 3 + strlen(self::DATA_GENERATOR),
                strlen($selfTemplateStart) * 3,
                $templateDataReal
            );
            if ($templateFormItem) {
                $formItem = explode(' ', $templateFormItem);
                $fieldsGenerate = $this->templateForm($formItem, $rename);
                $templateDataReal = str_replace($templateFormItem, implode(' ', $fieldsGenerate), $templateDataReal);
            }

            // replace form
            foreach ($dataForms as $form) {
                if (strlen($form) > 0) {
                    $form = trim($form);
                    [$keyForm, $valForm] = array_pad(explode(':', $form, 2), 2, '');
                    if ($rename['field_name_old']['field_name'] === $keyForm) {
                        $fieldsGenerateDataForm[] = $rename['field_name_new']['field_name'] . ":$valForm,";
                    } else {
                        $name = $keyForm . ":$valForm,";
                        if (!in_array($name, $fieldsGenerateDataForm) && !in_array($keyForm, $arrayChange)) {
                            $fieldsGenerateDataForm[] = $name;
                        }
                    }
                }
            }
            //replace rules
            if (\Str::contains($templateRules, $rename['field_name_old']['field_name'])) {
                $templateRulesTemp = str_replace(
                    $this->serviceGenerator->modelNameNotPluralFe($rename['field_name_old']['field_name']),
                    $this->serviceGenerator->modelNameNotPluralFe($rename['field_name_new']['field_name']),
                    $templateRulesTemp
                );
            }
            $templateDataReal = str_replace('this.form.' . $rename['field_name_old']['field_name'], 'this.form.' . $rename['field_name_new']['field_name'], $templateDataReal);
        }
        //form item
        if ($fieldsGenerateDataForm) {
            $templateDataReal = str_replace($templateDataForm, $this->replaceTemplate($fieldsGenerateDataForm, 2, 3, 2, 2, 0), $templateDataReal);
        }
        //rules
        return str_replace($templateRules, $templateRulesTemp, $templateDataReal);
    }

    private function generateFieldsChange($generator, $changeFields, $model, $templateDataReal)
    {
        if (!$changeFields) {
            return $templateDataReal;
        }

        $selfTemplateEnd = self::TEMPLATE_END;
        $selfDataForm = self::DATA_FORM;
        $arrayChange = \Arr::pluck($changeFields, 'field_name');
        $formFields = json_decode($generator->field, true);
        //form
        $templateDataForm = $this->serviceGenerator->searchTemplateX($selfDataForm, 1, $this->notDelete['this_check'], strlen($selfDataForm), -strlen($selfDataForm) - 4, $templateDataReal);
        $dataForms = explode(',', trim($templateDataForm));
        $fieldsGenerateDataForm = [];

        foreach ($changeFields as $change) {
            foreach ($formFields as $index => $oldField) {
                if ($index > 0 && $change['id'] === $oldField['id']) {
                    // replace form item
                    $selfTemplateStart = self::DATA_GENERATOR;
                    $selfTemplateStart .= '"' . $change['field_name'] . '"';
                    $templateFormItem = $this->serviceGenerator->searchTemplateX(
                        $selfTemplateStart,
                        1,
                        $selfTemplateEnd,
                        -strlen($selfTemplateStart) - strlen($selfTemplateStart),
                        strlen($selfTemplateStart) * 3,
                        $templateDataReal
                    );
                    if ($change['db_type'] !== $oldField['db_type']) {
                        //replace template form item
                        $templateDataReal = str_replace($templateFormItem, $this->generateItems($change, $model), $templateDataReal);
                    } else {
                        preg_match('/maxlength=(\'|")[0-9]{0,3}(\'|")/im', $templateFormItem, $matches);
                        if (isset($matches[0])) {
                            $templateFormItemNew = str_replace($matches[0], 'maxlength=' . "'{$change['length_varchar']}'", $templateFormItem);
                            $templateDataReal = str_replace($templateFormItem, $templateFormItemNew, $templateDataReal);
                        }
                    }
                    //replace rules

                    if ($change['default_value'] !== $oldField['default_value']) {
                        //drop rules
                        if ($oldField['default_value'] === $this->defaultValue['none']) {
                            $templateDataReal = $this->dropRules($change, $templateDataReal);
                        }
                        //add rule
                        if ($change['default_value'] === $this->defaultValue['none']) {
                            $templateDataReal = $this->generateRule($change, $model, $templateDataReal);
                        }
                    }
                }
                // replace form
                foreach ($dataForms as $form) {
                    if (strlen($form) > 0) {
                        $form = trim($form);
                        [$keyForm, $valForm] = array_pad(explode(':', $form, 2), 2, '');
                        if ($change['field_name'] === $keyForm) {
                            if ($change['default_value'] === $this->defaultValue['as_define']) {
                                $formDefault = $change['field_name'] . ':' . "'" . $change['as_define'] . "',";
                                if (!in_array($formDefault, $fieldsGenerateDataForm)) {
                                    $fieldsGenerateDataForm[] = $formDefault;
                                }
                            } else {
                                if ($valForm === " '[]'" || $valForm === " ''") {
                                    if ($change['db_type'] === $this->dbType['json']) {
                                        $valForm = " '[]'";
                                    } else {
                                        $valForm = " ''";
                                    }
                                }

                                $formNotDefault = $change['field_name'] . ":$valForm,";
                                if (!in_array($formNotDefault, $fieldsGenerateDataForm)) {
                                    $fieldsGenerateDataForm[] = $formNotDefault;
                                }
                            }
                        } else {
                            $name = $keyForm . ":$valForm,";
                            if (!in_array($name, $fieldsGenerateDataForm) && !in_array($keyForm, $arrayChange)) {
                                $fieldsGenerateDataForm[] = $name;
                            }
                        }
                    }
                }
            }
        }

        //form item
        if ($fieldsGenerateDataForm) {
            $templateDataReal = str_replace($templateDataForm, $this->replaceTemplate($fieldsGenerateDataForm, 2, 3, 2, 2, 0), $templateDataReal);
        }

        return $templateDataReal;
    }

    private function generateFieldsDrop($dropFields, $templateDataReal)
    {
        if (!$dropFields) {
            return $templateDataReal;
        }

        $selfTemplateEnd = self::TEMPLATE_END;
        $selfDataForm = self::DATA_FORM;
        $fieldsGenerateDataForm = [];
        $templateDataForm = $this->serviceGenerator->searchTemplateX($selfDataForm, 1, $this->notDelete['this_check'], strlen($selfDataForm), -strlen($selfDataForm) - 4, $templateDataReal);
        $dataForms = explode(',', trim($templateDataForm));
        $arrayChange = \Arr::pluck($dropFields, 'field_name');
        foreach ($dropFields as $index => $drop) {
            //replace template form item
            $selfTemplateStart = self::DATA_GENERATOR;
            $selfTemplateStart .= '"' . $drop['field_name'] . '"';
            $templateFormItem = $this->serviceGenerator->searchTemplateX(
                $selfTemplateStart,
                1,
                $selfTemplateEnd,
                -strlen($selfTemplateStart) * 3 + strlen(self::DATA_GENERATOR),
                strlen($selfTemplateStart) * 3,
                $templateDataReal
            );
            if ($templateFormItem) {
                $templateDataReal = str_replace($templateFormItem, '', $templateDataReal);
            }
            // drop form
            foreach ($dataForms as $form) {
                if (strlen($form) > 0) {
                    $form = trim($form);
                    [$keyForm, $valForm] = array_pad(explode(':', $form, 2), 2, '');
                    if ($drop['field_name'] !== $keyForm) {
                        $name = $keyForm . ":$valForm,";
                        if (!in_array($name, $fieldsGenerateDataForm) && !in_array($keyForm, $arrayChange)) {
                            $fieldsGenerateDataForm[] = $name;
                        }
                    }
                }
            }
            //drop rules
            $templateDataReal = $this->dropRules($drop, $templateDataReal);
        }
        if ($fieldsGenerateDataForm) {
            $templateDataReal = str_replace($templateDataForm, $this->replaceTemplate($fieldsGenerateDataForm, 2, 3, 2, 2, 0), $templateDataReal);
        }

        return $templateDataReal;
    }

    private function generateFieldsUpdate($updateFields, $model, $templateDataReal)
    {
        if (!$updateFields) {
            return $templateDataReal;
        }
        $selfDataForm = self::DATA_FORM;
        //create form
        $templateDataForm = $this->serviceGenerator->searchTemplateX($selfDataForm, 1, $this->notDelete['this_check'], strlen($selfDataForm), -strlen($selfDataForm) - 4, $templateDataReal);
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
        if ($fieldsGenerateDataForm) {
            $fieldsGenerateDataForm = array_merge($fieldsGenerateDataForm, $this->generateFields($updateFields));
            $templateDataReal = str_replace($templateDataForm, $this->replaceTemplate($fieldsGenerateDataForm, 2, 3, 2, 0, 0), $templateDataReal);
        }

        foreach ($updateFields as $update) {
            //create form item
            $templateDataReal = $this->serviceGenerator->replaceNotDelete($this->notDelete['item'], $this->generateItems($update, $model), 5, $templateDataReal, 2);
            //create rule
            if ($update['default_value'] === $this->defaultValue['none']) {
                $templateRules = $this->getHandlerTemplate('rules');
                $templateDataReal = $this->serviceGenerator->replaceNotDelete($this->notDelete['rules'], $templateRules, 4, $templateDataReal, 2);
                $templateDataReal = $this->replaceField($update, $model, $templateDataReal);
            }
            if ($update['db_type'] === $this->dbType['enum']) {
                $enum = '';
                foreach ($update['enum'] as $keyEnum => $value) {
                    if ($keyEnum === count($update['enum']) - 1) {
                        $enum .= "'$value'";
                    } else {
                        $enum .= "'$value',";
                    }
                }
                $name = $update['field_name'] . 'List: [' . $enum . '],';
                $templateDataReal = $this->serviceGenerator->replaceNotDelete($this->notDelete['data'], $name, 3, $templateDataReal, 2);
            }
        }

        return $templateDataReal;
    }

    private function importComponent($updateFields, $templateDataReal)
    {
        $megerUpdate = array_merge($updateFields['changeFields'], $updateFields['updateFields']);
        $flags = [
            'import' => [
                'long_text' => true,
                'json' => true,
            ],
            'component' => [
                'long_text' => true,
                'json' => true,
            ],
        ];
        $importVuejs = config('generator.import.vuejs');
        foreach ($megerUpdate as $field) {
            if ($field['db_type'] === $this->dbType['longtext'] && $flags['import']['long_text']) {
                if (!strpos($templateDataReal, $importVuejs['tinymce']['file'])) {
                    $templateDataReal = $this->serviceGenerator->replaceNotDelete($this->notDelete['import_component'], $importVuejs['tinymce']['file'], 0, $templateDataReal, 2);
                    $flags['import']['long_text'] = false;
                }
                if (!strpos($templateDataReal, $importVuejs['tinymce']['name']) && $flags['component']['long_text']) {
                    $templateDataReal = $this->serviceGenerator->replaceNotDelete($this->notDelete['import_component_name'], $importVuejs['tinymce']['name'], 2, $templateDataReal, 2);
                    $flags['component']['long_text'] = false;
                }
            } elseif ($field['db_type'] === $this->dbType['json']) {
                if (!strpos($templateDataReal, $importVuejs['json_editor']['file']) && $flags['import']['json']) {
                    $templateDataReal = $this->serviceGenerator->replaceNotDelete($this->notDelete['import_component'], $importVuejs['json_editor']['file'], 0, $templateDataReal, 2);
                    $flags['import']['json'] = false;
                }
                if (!strpos($templateDataReal, $importVuejs['json_editor']['name']) && $flags['component']['json']) {
                    $templateDataReal = $this->serviceGenerator->replaceNotDelete($this->notDelete['import_component_name'], $importVuejs['json_editor']['name'], 2, $templateDataReal, 2);
                    $flags['component']['json'] = false;
                }
            }
        }
        return $templateDataReal;
    }

    private function generateItems($field, $model)
    {
        $fieldsGenerate = [];
        $this->labelNameForm = '{{$LABEL_NAME_INPUT$}}';
        $this->propNameForm = '{{$PROP_NAME$}}';

        $tableName = $this->serviceGenerator->tableNameNotPlural($model['name']);
        switch ($field['db_type']) {
            case $this->dbType['integer']:
            case $this->dbType['bigInteger']:
            case $this->dbType['float']:
            case $this->dbType['double']:
                $fieldsGenerate[] = $this->generateInput('inputNumber', $tableName, $field);
                break;
            case $this->dbType['boolean']:
                $fieldsGenerate[] = $this->generateBoolean($tableName, $field);
                break;
            case $this->dbType['date']:
                $fieldsGenerate[] = $this->generateDateTime('date', $tableName, $field);
                break;
            case $this->dbType['dateTime']:
            case $this->dbType['timestamp']:
                $fieldsGenerate[] = $this->generateDateTime('dateTime', $tableName, $field);
                break;
            case $this->dbType['time']:
                $fieldsGenerate[] = $this->generateDateTime('time', $tableName, $field);
                break;
            case $this->dbType['year']:
                $fieldsGenerate[] = $this->generateDateTime('year', $tableName, $field);
                break;
            case $this->dbType['string']:
                $fieldsGenerate[] = $this->generateInput('input', $tableName, $field, $this->dbType['string']);
                break;
            case $this->dbType['text']:
                $fieldsGenerate[] = $this->generateInput('textarea', $tableName, $field);
                break;
            case $this->dbType['longtext']:
                $fieldsGenerate[] = $this->generateTinymce($tableName, $field);
                break;
            case $this->dbType['enum']:
                $fieldsGenerate[] = $this->generateEnum($tableName, $field);
                break;
            case $this->dbType['json']:
                $fieldsGenerate[] = $this->generateJson($tableName, $field);
                break;
        }
        return implode($this->serviceGenerator->infy_nl_tab(1, 3, 2), $fieldsGenerate);
    }

    private function generateFields($fields): array
    {
        $fieldsGenerate = [];
        foreach ($fields as $index => $field) {
            $fieldName = $field['field_name'];
            $fieldForm = '';
            if ($field['default_value'] === $this->defaultValue['none'] || $field['default_value'] === $this->defaultValue['null']) {
                if ($field['db_type'] === $this->dbType['json']) {
                    $fieldForm = "$fieldName: '[]'";
                } else {
                    $fieldForm = "$fieldName: ''";
                }
            } elseif ($field['default_value'] === $this->defaultValue['as_define']) {
                $asDefine = $field['as_define'];
                if (is_numeric($asDefine)) {
                    $fieldForm = "$fieldName: $asDefine";
                } else {
                    $fieldForm = "$fieldName: '$asDefine'";
                }
            }
            $fieldForm .= ',';
            $fieldsGenerate[] = $fieldForm;
        }
        return $fieldsGenerate;
    }

    private function generateBoolean($tableName, $field)
    {
        $formTemplate = $this->getFormTemplate('switch');
        $formTemplate = $this->replaceLabelForm($tableName, $field, $formTemplate);
        $formTemplate = $this->checkRequired($field, $formTemplate);
        return $this->replaceFormField($field, $formTemplate);
    }

    private function generateDateTime($fileName, $tableName, $field)
    {
        $formTemplate = $this->getFormTemplate($fileName);
        $formTemplate = $this->replaceLabelForm($tableName, $field, $formTemplate);
        $formTemplate = $this->checkRequired($field, $formTemplate);
        return $this->replaceFormField($field, $formTemplate);
    }

    private function generateInput($fileName, $tableName, $field, $dbType = '')
    {
        $formTemplate = $this->getFormTemplate($fileName);
        $formTemplate = $this->replaceLabelForm($tableName, $field, $formTemplate);
        $formTemplate = $this->checkRequired($field, $formTemplate);
        $formTemplate = $this->replaceAutoFocus($formTemplate);
        $formTemplate = $this->replaceFormField($field, $formTemplate);
        if ($dbType === $this->dbType['string']) {
            $formTemplate = str_replace('{{MAX_LENGTH}}', $field['length_varchar'], $formTemplate);
        }
        return $formTemplate;
    }

    private function generateTinymce($tableName, $field)
    {
        $formTemplate = $this->getFormTemplate('tinymce');
        $formTemplate = $this->replaceLabelForm($tableName, $field, $formTemplate);
        $formTemplate = $this->checkRequired($field, $formTemplate);
        return $this->replaceFormField($field, $formTemplate);
    }

    private function generateEnum($tableName, $field)
    {
        $formTemplate = $this->getFormTemplate('select');
        $formTemplate = $this->replaceLabelForm($tableName, $field, $formTemplate);
        $formTemplate = $this->checkRequired($field, $formTemplate);
        $formTemplate = $this->replaceFormField($field, $formTemplate);
        $formTemplate = str_replace('{{$LIST_SELECT$}}', $this->serviceGenerator->modelNameNotPluralFe($field['field_name']), $formTemplate);
        $formTemplate = str_replace('{{$LABEL_OPTION$}}', 'item', $formTemplate);
        return str_replace('{{$VALUE_OPTION$}}', 'item', $formTemplate);
    }

    private function generateJson($tableName, $field)
    {
        $formTemplate = $this->getFormTemplate('json');
        $formTemplate = $this->replaceLabelForm($tableName, $field, $formTemplate);
        $formTemplate = $this->checkRequired($field, $formTemplate);
        $formTemplate = $this->replaceFormField($field, $formTemplate);
        return str_replace('{{$REF_JSON$}}', $this->serviceGenerator->modelNameNotPluralFe($field['field_name']), $formTemplate);
    }

    private function generateRule($field, $model, $templateDataReal)
    {
        $templateRules = $this->getHandlerTemplate('rules');
        $templateDataReal = $this->serviceGenerator->replaceNotDelete($this->notDelete['rules'], $templateRules, 4, $templateDataReal, 2);
        return $this->replaceField($field, $model, $templateDataReal);
    }

    private function getFormTemplate($nameForm)
    {
        $pathTemplate = 'Forms/';
        return $this->serviceGenerator->get_template($nameForm, $pathTemplate, 'vuejs');
    }

    private function checkRequired($field, $formTemplate)
    {
        return str_replace($this->propNameForm, 'prop="' . $field['field_name'] . '"', $formTemplate);
    }

    private function replaceLabelForm($tableName, $field, $formTemplate)
    {
        return str_replace($this->labelNameForm, '$t(\'table.' . $tableName . '.' . $field['field_name'] . '\')', $formTemplate);
    }

    private function replaceField($field, $model, $formTemplate)
    {
        $attribute = 'this.$t(\'table.' . $this->serviceGenerator->tableNameNotPlural($model['name']) . '.' . $field['field_name'] . "')";
        $formTemplate = str_replace('{{$ATTRIBUTE_FIELD$}}', $attribute, $formTemplate);
        return str_replace('{{$FIELD$}}', $field['field_name'], $formTemplate);
    }

    private function replaceFormField($field, $formTemplate)
    {
        return str_replace('{{$FORM_FIELD$}}', $field['field_name'], $formTemplate);
    }

    private function getHandlerTemplate($nameForm)
    {
        $pathTemplate = 'Handler/';
        return $this->serviceGenerator->get_template($nameForm, $pathTemplate, 'vuejs');
    }

    private function replaceAutoFocus($formTemplate)
    {
        return str_replace('{{$AUTO_FOCUS_INPUT$}}', '', $formTemplate);
    }

    /**
     * @param $templates
     * @param $fields
     * @return array
     */
    private function templateForm($templates, $fields): array
    {
        $fieldsGenerate = [];
        foreach ($templates as $template) {
            if (\Str::contains($template, $fields['field_name_old']['field_name'])) {
                if (!\Str::contains($template, '<json-editor')) {
                    $fieldsGenerate[] = str_replace($fields['field_name_old']['field_name'], $fields['field_name_new']['field_name'], $template);
                } else {
                    $fieldsGenerate[] = $template;
                }
            } else {
                $fieldsGenerate[] = $template;
            }
        }

        return $fieldsGenerate;
    }

    /**
     * @param $fieldsGenerate
     * @param $tabStart
     * @param $tabEnd
     * @param $tabFields
     * @param int $space
     * @param int $start
     * @return string
     */
    private function replaceTemplate($fieldsGenerate, $tabStart, $tabEnd, $tabFields, $space = 2, $start = 1)
    {
        return $this->serviceGenerator->infy_nl_tab($start, $tabStart) .
            implode($this->serviceGenerator->infy_nl_tab(1, $tabFields), $fieldsGenerate) .
            $this->serviceGenerator->infy_nl_tab(1, $tabEnd, $space);
    }

    /**
     * @param $field
     * @param $templateDataReal
     * @return array|mixed|string|array<string>
     */
    private function dropRules($field, $templateDataReal)
    {
        $replaceStub = '';
        $fieldName = $field['field_name'];
        $templateRules = $this->serviceGenerator->searchTemplateX(self::RULES, 1, $this->notDelete['rules'], 20, -strlen(self::RULES), $templateDataReal);
        preg_match_all('/]/', $templateRules, $matches, PREG_OFFSET_CAPTURE);
        foreach ($matches[0] as $match) {
            $lengthStart = strpos($templateRules, "$fieldName:");
            if ($lengthStart) {
                $replaceStub = substr($templateRules, $lengthStart, $match[1]);
            }
            if (!preg_match("/'],$/mi", preg_replace("/[\s\r\n]*/", '', $replaceStub)) && strpos($replaceStub, "$fieldName:") !== false) {
                return str_replace($replaceStub, '', $templateDataReal);
            }
        }
        return $templateDataReal;
    }
}
