{**
 * Array
 *}

{if $oParameter->getNeedToShowSpecialArrayForm()}
	{$aValidatorData = $oParameter->getValidator()}
	{$aValidatorParams = $aValidatorData['params']}
	
	<div class="js-hidden-array-item-copy" style="display: none;">
		<div class="mb-10 js-array-item-value">
			<input type="text" class="input-text width-150" readonly="readonly" value="" data-name-original="{$sInputDataName}" />
			<button type="button" class="button button-primary js-remove-previous">x</button>
		</div>
	</div>
	
	
	<div class="js-array-values" data-key="{$sKey}">
		{foreach from=$oParameter->getValue() item=mValue}
			<div class="mb-10 js-array-item-value">
				<input type="text" name="{$sInputDataName}" class="input-text width-150" readonly="readonly" value="{$mValue}" />
				<button type="button" class="button button-primary js-remove-previous">x</button>
			</div>
		{/foreach}
	</div>

	
	{if isset($aValidatorParams['enum'])}
		<input type="hidden" class="js-array-input-type" data-key="{$sKey}" value="enum" />
	
		{* Перечисление разрешенных значений массива *}
		{$aItemsToShow = $aValidatorParams['enum']}
		
		<select class="js-array-enum input-text width-250" data-key="{$sKey}">
			{foreach from=$aItemsToShow item=sValue}
				<option value="{$sValue}" {if in_array($sValue, $oParameter->getValue())}disabled="disabled"{/if}>{$sValue}</option>
			{/foreach}
		</select>
	{else}
		<input type="hidden" class="js-array-input-type" data-key="{$sKey}" value="text-field" />
		
		{* Поле для ввода значений массива *}
		
		<input type="text" class="js-array-input-text input-text width-250" data-key="{$sKey}" value="" />
	{/if}
	
	<div class="js-array-add-value button button-primary" data-key="{$sKey}">+</div>
{else}
	{* todo: Простой вывод значений массива как есть в виде php array *}
	
	{*
	<textarea name="{$sInputDataName}" class="input-text width-250">{var_export($oParameter->getValue())|escape:'html'}</textarea>
	*}
	Простой вывод значений массива как есть в виде php array - на данный момент не доступно.
{/if}