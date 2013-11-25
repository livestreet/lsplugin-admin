{**
 * Дробные числа
 *}

{extends file="{$aTemplatePathPlugin.admin}settings/fields/settings.field.base.tpl"}

{block name="field_holder"}
	<input type="text" name="{$sInputDataName}" value="{$oParameter->getValue()|escape:'html'}" class="input-text width-250" />
{/block}
