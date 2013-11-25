{**
 * Базовое поле страницы настроек
 *}

{block name='field_before'}{/block}

<div class="form-field js-settings-field {block name='field_classes'}{/block}">
	<a name="p{$oParameter@iteration}"></a>

	{* 
		<div class="ParamNum">#{$oParameter@iteration}</div>
		<div class="DisplayKey">{$sKey}</div>
		type: <b>{$oParameter->getType()}</b>
	 *}

	<input type="hidden" name="{$sInputDataName}" value="{$sAdminSettingsFormSystemId}" />
	<input type="hidden" name="{$sInputDataName}" value="{$sKey}" />

	{if ! $bFieldNoLabel}
		<label class="form-field-label">{$oParameter->getName()}</label>
	{/if}

	<div class="form-field-holder">
		{block name="field_holder"}{/block}

		<small class="note">{$oParameter->getDescription()}</small>
	</div>
</div>