{*
	Вывод информации об существовании обновления для плагина этой версии
*}

{if $aPluginUpdates and $oPlugin and isset($aPluginUpdates[$oPlugin->getCode()])}
	{$oUpdateInfo = $aPluginUpdates[$oPlugin->getCode()]}
	{$sTextMsg = "{$aLang.plugin.admin.plugins.list.new_version_avaible} <b>{$oUpdateInfo->getVersion()}</b>"}

	{* todo: link to catalog *}

	{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts=$sTextMsg sAlertStyle='info'}
{/if}
