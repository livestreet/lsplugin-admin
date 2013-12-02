{include file='forms/form.field.checkbox.tpl' 
		 sFieldName    = 'validate[allowEmpty]' 
		 bFieldChecked = ! $oPropertyValidateRules.allowEmpty
		 sFieldLabel   = 'Обязательно к заполнению'}

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
		 sFieldName    = 'validate[count]'
		 sFieldClasses = 'width-150'
		 sFieldValue   = $oPropertyValidateRules.count
		 sFieldLabel   = 'Максимальное количество тегов'}