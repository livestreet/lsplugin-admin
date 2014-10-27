{$oValue = $oProperty->getValue()}

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
		 sFieldName  = "property[{$oProperty->getId()}]"
		 sFieldValue = $oValue->getValueForForm()
		 sFieldNote = $oProperty->getDescription()
		 sFieldLabel = $oProperty->getTitle()}