{**
 * Логическое поле (да/нет)
 *}

{extends file="{$aTemplatePathPlugin.admin}settings/fields/settings.field.base.tpl"}

{block name='field_classes'}form-field-checkbox{/block}

{block name='field_before'}
	{$bFieldNoLabel = true}
{/block}

{block name='field_holder'}
	<label>
		<input type="checkbox" name="{$sInputDataName}" value="1" {if $oParameter->getValue()}checked="checked"{/if} />
		{$oParameter->getName()}
	</label>
{/block}
