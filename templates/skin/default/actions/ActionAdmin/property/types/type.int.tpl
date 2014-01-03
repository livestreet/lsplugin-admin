{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.checkbox.tpl"
		 sFieldName    = 'validate[allowEmpty]' 
		 bFieldChecked = ! $oPropertyValidateRules.allowEmpty
		 sFieldLabel   = 'Обязательно к заполнению'}

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
		 sFieldName    = 'validate[min]'
		 sFieldClasses = 'width-150'
		 sFieldValue   = $oPropertyValidateRules.min
		 sFieldLabel   = 'Минимальная длина'}

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
		 sFieldName    = 'validate[max]'
		 sFieldClasses = 'width-150'
		 sFieldValue   = $oPropertyValidateRules.max
		 sFieldLabel   = 'Максимальная длина'}