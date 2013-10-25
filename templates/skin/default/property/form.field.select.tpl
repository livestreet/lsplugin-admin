{$oValue=$oProperty->getValue()}
{$aSelectItems=$oProperty->getSelects()}

{$oProperty->getTitle()}:

<select name="property[{$oProperty->getId()}]">
	{foreach $aSelectItems as $oSelectItem}
        <option value="{$oSelectItem->getId()}">{$oSelectItem->getValue()}</option>
	{/foreach}
</select>

<br/><br/>