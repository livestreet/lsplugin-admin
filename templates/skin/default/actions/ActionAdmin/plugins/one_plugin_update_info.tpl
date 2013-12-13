{*
	Вывод информации об существовании обновления для плагина этой версии
*}

{if $aPluginUpdates and $oPlugin and isset($aPluginUpdates[$oPlugin->getCode()])}
	{$oUpdateInfo = $aPluginUpdates[$oPlugin->getCode()]}
	{$sTextMsg = "<a href=\"{$oUpdateInfo->getUrlDownload()}\" target=\"_blank\">{$aLang.plugin.admin.plugins.list.new_version_avaible} <b>{$oUpdateInfo->getVersion()}</b></a>"}

	{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts=$sTextMsg sAlertStyle='info'}
{/if}
