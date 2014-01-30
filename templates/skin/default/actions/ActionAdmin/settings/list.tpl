{**
 * Настройки
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content_actionbar'}
	{if $sConfigName==$sAdminSystemConfigId}
		<div class="fl-l">
			{foreach Config::Get(PluginAdmin_ModuleSettings::ROOT_CONFIG_GROUPS_KEY) as $sKey => $aGroupData}
				<a href="{router page='admin/settings/config'}{$sKey}" class="button {if $sKey==$sGroupName}active{/if}">{$aLang.config_sections.{$sKey}.name}</a>
			{/foreach}
		</div>
	{/if}
{/block}

{block name='layout_page_title'}
	{if $sConfigName}
		{if $sConfigName==$sAdminSystemConfigId}
			{$aLang.plugin.admin.settings.titles.main_config} &mdash; {$aLang.config_sections.{$sGroupName}.name}
		{else}
			{$aLang.plugin.admin.settings.titles.plugin_config} "<span title="{$sConfigName}">{$oPlugin->getName()}</span>"
		{/if}
	{/if}
{/block}

{block name='layout_content'}
	{include file="{$aTemplatePathPlugin.admin}settings/settings.list.tpl"}
{/block}