{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_page_title'}
	{$aLang.plugin.admin.plugins.list.title}
{/block}


{block name='layout_content_actionbar'}
	<div class="fl-r">
		<a class="button {if $_aRequest.type==''}active{/if}" href="{router page='admin/plugins/list'}">{$aLang.plugin.admin.plugins.menu.filter.activated}</a>
		<a class="button {if $_aRequest.type=='deactivated'}active{/if}" href="{router page='admin/plugins/list'}?type=deactivated">{$aLang.plugin.admin.plugins.menu.filter.deactivated}</a>
		<a class="button {if $_aRequest.type=='all'}active{/if}" href="{router page='admin/plugins/list'}?type=all">{$aLang.plugin.admin.plugins.menu.filter.all}</a>
		<a class="button {if $_aRequest.type=='updates'}active{/if}" href="{router page='admin/plugins/list'}?type=updates">{$aLang.plugin.admin.plugins.menu.filter.updates}</a>
	</div>
	<a class="button button-primary" href="{router page='admin/plugins/install'}">{$aLang.plugin.admin.plugins.menu.install_plugin}</a>
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