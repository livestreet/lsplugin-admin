{**
 * Установка дополнений из каталога
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_page_title'}
	{$aLang.plugin.admin.skins.install.title} {if $aPaging and $aPaging.iCount}<span>({$aPaging.iCount})</span>{/if}
{/block}

{block 'layout_content_actionbar'}
	{$sVersionCurrent = $sVersionCurrent|default:'all'}




	{$menu = []}

	{foreach Config::Get('plugin.admin.catalog.remote.addons.sorting') as $sSorting}
		{$menu[] = [
			name => $sSorting,
			url => "{router page='admin/skins/install'}{request_filter name=array('order', 'type', 'version', 'section') value=array($sSorting, $sPluginTypeCurrent, $sVersionCurrent, $sSectionCurrent)}",
			text => {lang "plugin.admin.plugins.install.filter.sorting.$sSorting"}
		]}
	{/foreach}

	{component 'admin:dropdown' text='...' classes='js-admin-actionbar-dropdown' activeItem=$sSortOrderCurrent menu=$menu}
{/block}

{block 'layout_content'}
	{* Справка *}
	{component 'admin:p-plugin' template='install-help'}

	{* Вывод дополнений *}
	{component 'admin:p-plugin' template='plugin-market-list' plugins=$aAddons pagination=$aPaging}
{/block}