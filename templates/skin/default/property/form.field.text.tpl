{$oValue=$oProperty->getValue()}

{$oProperty->getTitle()}:
<textarea name="property[{$oProperty->getId()}]" rows="10" class="width-500">{$oValue->getValueForForm()}</textarea><br/><br/>