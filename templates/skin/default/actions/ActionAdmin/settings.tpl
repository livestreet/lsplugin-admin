{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}

	{if $sConfigName}
		<h2 class="title mb-20">
			{if $sConfigName==$sAdminSystemConfigId}
				{$aLang.plugin.admin.settings.titles.main_config}
			{else}
				{$aLang.plugin.admin.settings.titles.plugin_config} "{$sConfigName}"
			{/if}
		</h2>
	{/if}
	
	{include file="{$aTemplatePathPlugin.admin}settings/keys_to_show.tpl"}

	{include file="{$aTemplatePathPlugin.admin}settings/plugin_settings.tpl"}
	
{/block}