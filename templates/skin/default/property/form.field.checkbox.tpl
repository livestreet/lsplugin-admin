{$oValue = $oProperty->getValue()}

{include file='forms/form.field.checkbox.tpl' 
		 sFieldName    = "property[{$oProperty->getId()}]"
		 bFieldChecked = $oValue->getValueInt()
		 sFieldLabel   = $oProperty->getTitle()}