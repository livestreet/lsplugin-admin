{**
 * Строковый тип
 *}

{extends file="{$aTemplatePathPlugin.admin}settings/fields/settings.field.base.tpl"}

{block name="field_holder"}
	<input type="text" name="{$sInputDataName}" value="{$oParameter->getValue()|escape:'html'}" class="width-full" />
{/block}
