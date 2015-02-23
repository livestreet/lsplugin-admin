<h3 class="page-sub-header mt-30">Правила валидации</h3>

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.checkbox.tpl"
		 sFieldName    = 'validate[allowEmpty]' 
		 bFieldChecked = ! $oPropertyValidateRules.allowEmpty
		 sFieldLabel   = 'Обязательно к заполнению'}

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
		 sFieldName    = 'validate[countMax]'
		 sFieldClasses = 'width-150'
		 sFieldValue   = $oPropertyValidateRules.countMax
		 sFieldLabel   = 'Максимальное количество тегов'}

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
		sFieldName    = 'validate[countMin]'
		sFieldClasses = 'width-150'
		sFieldValue   = $oPropertyValidateRules.countMin
		sFieldLabel   = 'Минимальное количество тегов'}