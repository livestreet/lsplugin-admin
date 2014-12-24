<h3 class="page-sub-header mt-30">Дополнительные параметры</h3>

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
        sFieldName    = 'param[default_value]'
        sFieldClasses = 'width-150'
        sFieldValue   = $oPropertyParams.default_value
        sFieldLabel   = 'Значение атрибута value'}

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.checkbox.tpl"
        sFieldName    = 'param[default]'
        bFieldChecked = $oPropertyParams.default
        sFieldLabel   = 'Дефолтное значение'}