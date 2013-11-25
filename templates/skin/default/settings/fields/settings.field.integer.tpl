{**
 * Integer
 *}

{extends file="{$aTemplatePathPlugin.admin}/settings/fields/settings.field.base.tpl"}

{block name="field_holder"}
	{if $oParameter->getNeedToShowSpecialIntegerForm()}
		{$aValidatorData = $oParameter->getValidator()}
		{$aValidatorParams = $aValidatorData['params']}
		
		{* Границы от и до разрешенных значений целого числа *}
		{$aItemsToShow = range($aValidatorParams['min'], $aValidatorParams['max'])}
		
		<select name="{$sInputDataName}" class="input-text width-250">
			{foreach from=$aItemsToShow item=sValue}
				<option value="{$sValue}" {if $sValue==$oParameter->getValue()}selected="selected"{/if}>{$sValue}{if $sValue==$oParameter->getValue()} ({$aLang.plugin.admin.current}){/if}</option>
			{/foreach}
		</select>
	{else}
		{* Простой вывод значения числа как есть *}
		
		<input type="text" name="{$sInputDataName}" value="{$oParameter->getValue()|escape:'html'}" class="input-text width-250" />
	{/if}
{/block}