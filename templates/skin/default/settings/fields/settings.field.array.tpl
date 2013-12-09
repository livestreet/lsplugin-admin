{**
 * Массив
 *}

{extends file="{$aTemplatePathPlugin.admin}settings/fields/settings.field.base.tpl"}

{block name="field_holder"}
	{* Особый вид отображения массив *}
	{if $oParameter->getNeedToShowSpecialArrayForm()}
		{$aValidatorData = $oParameter->getValidator()}
		{$aValidatorParams = $aValidatorData['params']}

		{* Скрытая копия для структуры одного элемента массива *}
		<div class="js-hidden-array-item-copy" style="display: none;">
			<div class="form-field-settings-array-value js-array-item-value">
				<input type="text" class="input-text width-150" readonly="readonly" value="" data-name-original="{$sInputDataName}" />
				<button type="button" class="button button-primary form-field-settings-array-remove js-remove-previous">×</button>
			</div>
		</div>
		
		{* Элементы массива *}
		<div class="form-field-settings-array-values js-array-values" data-key="{$sKey}">
			{foreach from=$oParameter->getValue() item=mValue}
				<div class="form-field-settings-array-value js-array-item-value">
					<input type="text" name="{$sInputDataName}" class="input-text width-150" readonly="readonly" value="{$mValue}" />
					<button type="button" class="button button-primary form-field-settings-array-remove js-remove-previous">×</button>
				</div>
			{/foreach}
		</div>

		{* Тип ввода данных *}
		{if isset($aValidatorParams['enum'])}
			<input type="hidden" class="js-array-input-type" data-key="{$sKey}" value="enum" />
		
			{* Перечисление разрешенных значений массива в селекте *}
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
		
		<button type="button" class="js-array-add-value button button-primary" data-key="{$sKey}">+</button>

	{else}
		{* todo: Простой вывод значений массива как есть в виде php array *}
		
		{*
		<textarea name="{$sInputDataName}" class="input-text width-250">{var_export($oParameter->getValue())|escape:'html'}</textarea>
		*}
		Простой вывод значений массива как есть в виде php array - на данный момент не доступно.
	{/if}
{/block}
