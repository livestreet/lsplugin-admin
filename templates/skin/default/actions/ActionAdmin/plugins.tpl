{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_page_title'}
	{$aLang.plugin.admin.plugins.title}
{/block}

{block name='layout_content'}
	{if $aPluginsInfo and count($aPluginsInfo) > 0}
		<table class="table table-plugins">
			<tbody>
				{foreach from=$aPluginsInfo item=oPlugin}
					{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/plugins/one_plugin.tpl"}
				{/foreach}
			</tbody>
		</table>
	{else}
		{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts=$aLang.plugin.admin.plugins.no_plugins sAlertStyle='empty'}
	{/if}
{/block}