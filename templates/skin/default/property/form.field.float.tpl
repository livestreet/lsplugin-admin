{$oValue = $oProperty->getValue()}

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
		 sFieldName    = "property[{$oProperty->getId()}]"
		 sFieldValue   = $oValue->getValueFloat()
		 sFieldClasses = 'width-150'
		 sFieldLabel   = $oProperty->getTitle()}