{**
 * Установка дополнений из каталога
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_page_title'}
	{$aLang.plugin.admin.plugins.install.title} {if $aPaging and $aPaging.iCount}<span>({$aPaging.iCount})</span>{/if}
{/block}

{block 'layout_content_actionbar'}
	{* тип плагинов *}
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

	{component 'dropdown' text='...' classes='js-admin-actionbar-dropdown' activeItem=$sSortOrderCurrent menu=$menu}


	{$menu = []}

	{foreach Config::Get('plugin.admin.catalog.remote.addons.versions') as $sVersion}
		{$menu[] = [
			name => $sVersion,
			url => "{router page='admin/plugins/install'}{request_filter name=array('order', 'type', 'version', 'section') value=array($sSortOrderCurrent, $sPluginTypeCurrent, $sVersion, $sSectionCurrent)}",
			text => {lang "plugin.admin.plugins.install.filter.versions.$sVersion"}
		]}
	{/foreach}

	{component 'dropdown' text='...' classes='js-admin-actionbar-dropdown' activeItem=$sVersionCurrent menu=$menu}


	{$menu = []}

	{foreach Config::Get('plugin.admin.catalog.remote.addons.sections') as $sSection}
		{$menu[] = [
			name => $sSection,
			url => "{router page='admin/plugins/install'}{request_filter name=array('order', 'type', 'version', 'section') value=array($sSortOrderCurrent, $sPluginTypeCurrent, $sVersionCurrent, $sSection)}",
			text => {lang "plugin.admin.plugins.install.filter.sections.$sSection"}
		]}
	{/foreach}

	{component 'dropdown' text='...' classes='js-admin-actionbar-dropdown' activeItem=$sSectionCurrent menu=$menu}

	{*
		кнопка сброса кеша списка плагинов (нужна только если включен кеш)
	*}
	{if Config::Get('sys.cache.use')}
		{component 'admin:button'
			url="{router page='admin/plugins/install/resetcache'}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
			text=$aLang.plugin.admin.plugins.install.update}
	{/if}
{/block}

{block name='layout_content'}
	{* Справка *}
	<a href="#" class="link-dotted js-catalog-toggle-tip-button">{$aLang.plugin.admin.plugins.install.tip_button}</a>
	<div class="alert alert-info mt-15 js-catalog-tip-message" style="display: none;">
		{$aLang.plugin.admin.plugins.install.tip}
	</div>

	{* Вывод дополнений *}
	<div class="addon-list-full">
		{if $aAddons and count($aAddons) > 0}
			{foreach $aAddons as $oAddon}
				{component 'admin:plugin' template='plugin-market' plugin=$oAddon}
			{/foreach}
		{else}
			{component 'admin:blankslate' text=$aLang.plugin.admin.plugins.install.no_addons}
		{/if}
	</div>

	{include file="{$aTemplatePathPlugin.admin}pagination.tpl"}
{/block}