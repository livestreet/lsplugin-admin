{$sType = $oProperty->getType()}

<div class="js-property-field-area property-type-{$oProperty->getType()} property-type-{$oProperty->getTargetType()}-{$oProperty->getType()}" data-property-id="{$oProperty->getId()}">
	{include file="{$aTemplatePathPlugin.admin}property/form.field.{$sType}.tpl" oProperty=$oProperty}
</div>