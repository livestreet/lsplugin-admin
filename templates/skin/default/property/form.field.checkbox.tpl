{$oValue=$oProperty->getValue()}

{$oProperty->getTitle()}:
<input type="checkbox" value="1" name="property[{$oProperty->getId()}]" {if $oValue->getValueInt()}checked="checked"{/if}><br/><br/>