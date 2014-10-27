{$oValue = $oProperty->getValue()}

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.checkbox.tpl"
		 sFieldName    = "property[{$oProperty->getId()}]"
         sFieldValue = $oProperty->getParam('default_value')
		 bFieldChecked = $oValue->getValueForForm()
		 sFieldNote = $oProperty->getDescription()
		 sFieldLabel   = $oProperty->getTitle()}