skin{**
 * Список плагинов
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_page_title'}
	{$aLang.plugin.admin.plugins.list.titles[$sType]} <span>({count($aPluginsInfo.collection)})</span>
{/block}

{block 'layout_content_actionbar'}
	{component 'admin:button'
		url="{router page='admin/plugins/list'}"
		text=$aLang.plugin.admin.plugins.menu.filter.all
		badge=[ value => $aPluginsInfo.count_all ]
		classes="{if $sType == null}active{/if}"}

	{component 'admin:button'
		url="{router page='admin/plugins/list'}activated"
		text=$aLang.plugin.admin.plugins.menu.filter.activated
		badge=[ value => $aPluginsInfo.count_active ]
		classes="{if $sType == 'activated' }active{/if}"}

	{component 'admin:button'
		url="{router page='admin/plugins/list'}deactivated"
		text=$aLang.plugin.admin.plugins.menu.filter.deactivated
		badge=[ value => $aPluginsInfo.count_inactive ]
		classes="{if $sType == 'deactivated' }active{/if}"}

	{component 'admin:button'
		url="{router page='admin/plugins/list'}updates"
		text=$aLang.plugin.admin.plugins.menu.filter.updates
		badge=[ value => $iPluginUpdates ]
		classes="{if $sType == 'updates' }active{/if}"}
{/block}

{block 'layout_content'}
	{component 'admin:p-plugin' template='list' plugins=$aPluginsInfo.collection updates=$aPluginUpdates type=$sType}
{/block}