<h3 class="page-sub-header mt-30">Правила валидации</h3>

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.checkbox.tpl"
		 sFieldName    = 'validate[allowEmpty]' 
		 bFieldChecked = ! $oPropertyValidateRules.allowEmpty
		 sFieldLabel   = 'Обязательно к заполнению'}

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
		 sFieldName    = 'validate[min]'
		 sFieldClasses = 'width-150'
		 sFieldValue   = $oPropertyValidateRules.min
		 sFieldLabel   = 'Минимальное значение'}

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
		 sFieldName    = 'validate[max]'
		 sFieldClasses = 'width-150'
		 sFieldValue   = $oPropertyValidateRules.max
		 sFieldLabel   = 'Максимальное значение'}