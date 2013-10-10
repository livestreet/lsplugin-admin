{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}


{block name='layout_page_title'}
	{if $sConfigName}
		{if $sConfigName==$sAdminSystemConfigId}
			{$aLang.plugin.admin.settings.titles.main_config}
		{else}
			{$aLang.plugin.admin.settings.titles.plugin_config} "{$sConfigName}"
		{/if}
	{/if}
{/block}


{block name='layout_content'}
	{include file="{$aTemplatePathPlugin.admin}settings/keys_to_show.tpl"}
	{include file="{$aTemplatePathPlugin.admin}settings/plugin_settings.tpl"}
{/block}