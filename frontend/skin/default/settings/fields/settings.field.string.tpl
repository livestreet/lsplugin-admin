{**
 * Строковый тип
 *}

{extends file="{$aTemplatePathPlugin.admin}settings/fields/settings.field.base.tpl"}

{block name="field_holder"}

	{*
		получить данные валидатора
	*}
	{$aValidatorData = $oParameter->getValidator()}
	{$aValidatorParams = $aValidatorData['params']}

	{*
		если для валидатора указан тип "перечисление элементов" - использовать селект для ввода
	*}
	{if $aValidatorData['type'] == 'Enum'}

		{* Перечисление разрешенных значений в селекте *}
		{$aItemsToShow = $aValidatorParams['enum']}

		{*
			Если разрешено не выбирать значение - добавить пустое значение
		*}
		{if $aValidatorParams['allowEmpty']}
			{$aItemsToShow = array_merge([''], $aItemsToShow)}
		{/if}

		<select name="{$sInputDataName}" class="input-text width-250">
			{foreach from=$aItemsToShow item=sValue}
				<option value="{$sValue|escape:'html'}" {if $sValue==$oParameter->getValue()}selected="selected"{/if}>{$sValue|default:'---'|escape:'html'}</option>
			{/foreach}
		</select>

	{else}
		{*
			использовать для ввода обычное текстовое поле
		*}
		<input type="text" name="{$sInputDataName}" value="{$oParameter->getValue()|escape:'html'}" class="width-full" />
	{/if}

{/block}