{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.checkbox.tpl"
		 sFieldName    = 'validate[allowEmpty]' 
		 bFieldChecked = ! $oPropertyValidateRules.allowEmpty
		 sFieldLabel   = 'Обязательно к заполнению'}