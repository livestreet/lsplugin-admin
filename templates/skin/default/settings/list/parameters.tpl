{*
	Вывод настроек
*}

{*
	по всем параметрам
*}
{foreach $aSettings as $oParameter}
	{$sKey = $oParameter->getKey()}
	{$sInputDataName = "SettingsNum{$oParameter@iteration}[]"}

	{if in_array($oParameter->getType(), array('integer', 'string', 'float', 'array', 'boolean'))}
		{include file="{$aTemplatePathPlugin.admin}settings/fields/settings.field.{$oParameter->getType()}.tpl"}
	{else}
		{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts="{$aLang.plugin.admin.errors.unknown_parameter_type}: <b>{$oParameter->getType()}</b>" sAlertStyle='error'}
	{/if}
{/foreach}
