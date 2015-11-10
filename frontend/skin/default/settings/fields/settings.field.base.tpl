{**
 * Базовое поле страницы настроек
 *}

{block name='field_before'}{/block}

<div class="form-field form-field-settings ls-clearfix js-settings-field {block name='field_classes'}{/block}">
	<a name="s{$oSection@iteration}p{$oParameter@iteration}"></a>
	<i class="icon-question-sign form-field-help js-tooltip"
       data-tooltip-content="Секция #{$oSection@iteration}, параметр #{$oParameter@iteration} <br /> {$sKey} / {$oParameter->getType()}"></i>{* @todo: add lang *}

	<input type="hidden" name="{$sInputDataName}" value="{$sAdminSettingsFormSystemId}" />
	<input type="hidden" name="{$sInputDataName}" value="{$sKey}" />

	{if !$bFieldNoLabel}
		<label class="form-field-label">{$oParameter->getName()}</label>
	{/if}

	<div class="form-field-holder">
		{block name="field_holder"}{/block}

		{if $oParameter->getDescription()}
			<small class="note">{$oParameter->getDescription()}</small>
		{/if}
	</div>
</div>
