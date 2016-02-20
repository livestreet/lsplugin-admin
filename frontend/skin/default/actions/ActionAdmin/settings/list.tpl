{**
 * Настройки
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_content_actionbar'}
	{if $sConfigName == $sAdminSystemConfigId}
		{foreach Config::Get(PluginAdmin_ModuleSettings::ROOT_CONFIG_GROUPS_KEY) as $sKey => $aGroupData}
			{component 'button' url="{router page='admin/settings/config'}{$sKey}" classes="{if $sKey==$sGroupName}active{/if}" text="{$aLang.config_sections.{$sKey}.name}"}
		{/foreach}
	{/if}
{/block}

{block 'layout_page_title'}
	{if $sConfigName}
		{if $sConfigName == $sAdminSystemConfigId}
			{$aLang.plugin.admin.settings.titles.main_config} &mdash; {$aLang.config_sections.{$sGroupName}.name}
		{else}
			{$aLang.plugin.admin.settings.titles.plugin_config} <span title="{$sConfigName}">{$oPlugin->getName()}</span>
		{/if}
	{/if}
{/block}

{block 'layout_content'}
	{component 'admin:p-settings' template='list' sections=$aSections formid=$sAdminSettingsFormSystemId}
{/block}