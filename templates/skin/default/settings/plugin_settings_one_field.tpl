{**
 * Settings field
 *}

{if in_array($oParameter->getType(), array('integer', 'string', 'float', 'array', 'boolean'))}
	{include file="{$aTemplatePathPlugin.admin}settings/field_forms/one_field_{$oParameter->getType()}.tpl"}
{else}
	{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts="{$aLang.plugin.admin.errors.unknown_parameter_type}: <b>{$oParameter->getType()}</b>" sAlertStyle='error'}
{/if}