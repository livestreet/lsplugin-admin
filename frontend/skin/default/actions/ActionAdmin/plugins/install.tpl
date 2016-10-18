{**
 * Установка дополнений из каталога
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_page_title'}
	{$aLang.plugin.admin.plugins.install.title} {if $aPaging and $aPaging.iCount}<span>({$aPaging.iCount})</span>{/if}
{/block}

{block 'layout_content_actionbar'}
	{$sVersionCurrent = $sVersionCurrent|default:'all'}
	{$sSectionCurrent = $sSectionCurrent|default:'all'}

	{foreach Config::Get('plugin.admin.catalog.remote.addons.type') as $sPluginType}
		{component 'admin:button'
			url="{router page='admin/plugins/install'}{request_filter name=array('order', 'type', 'version', 'section') value=array($sSortOrderCurrent, $sPluginType, $sVersionCurrent, $sSectionCurrent)}"
			text=$aLang.plugin.admin.plugins.install.filter.type.$sPluginType
			classes="{if $sPluginTypeCurrent == $sPluginType}active{/if}"}
	{/foreach}

	{$menu = []}

	{foreach Config::Get('plugin.admin.catalog.remote.addons.sorting') as $sSorting}
		{$menu[] = [
			name => $sSorting,
			url => "{router page='admin/plugins/install'}{request_filter name=array('order', 'type', 'version', 'section') value=array($sSorting, $sPluginTypeCurrent, $sVersionCurrent, $sSectionCurrent)}",
			text => {lang "plugin.admin.plugins.install.filter.sorting.$sSorting"}
		]}
	{/foreach}

	{component 'admin:dropdown' text='...' classes='js-admin-actionbar-dropdown' activeItem=$sSortOrderCurrent menu=$menu}


	{$menu = []}

	{foreach Config::Get('plugin.admin.catalog.remote.addons.versions') as $sVersion}
		{$sVersion = $sVersion|default:'all'}

		{$menu[] = [
			name => $sVersion,
			url => "{router page='admin/plugins/install'}{request_filter name=array('order', 'type', 'version', 'section') value=array($sSortOrderCurrent, $sPluginTypeCurrent, $sVersion, $sSectionCurrent)}",
			text => {lang "plugin.admin.plugins.install.filter.versions.$sVersion"}
		]}
	{/foreach}

	{component 'admin:dropdown' text='...' classes='js-admin-actionbar-dropdown' activeItem=$sVersionCurrent menu=$menu}


	{$menu = []}

	{foreach Config::Get('plugin.admin.catalog.remote.addons.sections') as $sSection}
		{$sSection = $sSection|default:'all'}

		{$menu[] = [
			name => $sSection,
			url => "{router page='admin/plugins/install'}{request_filter name=array('order', 'type', 'version', 'section') value=array($sSortOrderCurrent, $sPluginTypeCurrent, $sVersionCurrent, $sSection)}",
			text => {lang "plugin.admin.plugins.install.filter.sections.$sSection"}
		]}
	{/foreach}

	{component 'admin:dropdown' text='...' classes='js-admin-actionbar-dropdown' activeItem=$sSectionCurrent menu=$menu}

	{* кнопка сброса кеша списка плагинов (нужна только если включен кеш) *}
	{if Config::Get('sys.cache.use')}
		{component 'admin:button'
			url="{router page='admin/plugins/install/resetcache'}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
			text=$aLang.plugin.admin.plugins.install.update}
	{/if}
{/block}

{block 'layout_content'}
	{* Справка *}
	{component 'admin:p-plugin' template='install-help'}

	{* Вывод дополнений *}
	{component 'admin:p-plugin' template='plugin-market-list' plugins=$aAddons pagination=$aPaging}
{/block}