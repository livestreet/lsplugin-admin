{**
 * Установка дополнений из каталога
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_page_title'}
	{$aLang.plugin.admin.plugins.install.title} {if $aPaging and $aPaging.iCount}<span>({$aPaging.iCount})</span>{/if}
{/block}


{block name='layout_content_actionbar'}
	<div class="fl-r">
		{*
			тип плагинов
		*}
		{foreach Config::Get('plugin.admin.catalog.remote.addons.type') as $sPluginType}
			<a class="button {if $sPluginTypeCurrent==$sPluginType}active{/if}" href="{router page='admin/plugins/install'}{request_filter
				name=array('order', 'type', 'version', 'section')
				value=array($sSortOrderCurrent, $sPluginType, $sVersionCurrent, $sSectionCurrent)
			}">{$aLang.plugin.admin.plugins.install.filter.type.$sPluginType}</a>
		{/foreach}

		&nbsp;&nbsp;&nbsp;

		{*
			дропдаун с сортировков и категорией аддонов
		*}
		<button class="button button-icon js-dropdown" data-dropdown-target="dropdown-admin-plugins-install-options" id="dropdown_admin_plugins_install_options_button">
			<i class="icon-settings-14"></i>{* todo: add special icon *}
		</button>
		<div class="dropdown-menu p15" id="dropdown-admin-plugins-install-options">
			{*
				сортировка
			*}
			<select class="width-200 js-admin-url-to-go-in-select">
				{foreach Config::Get('plugin.admin.catalog.remote.addons.sorting') as $sSorting}
					<option value="{router page='admin/plugins/install'}{request_filter
						name=array('order', 'type', 'version', 'section')
						value=array($sSorting, $sPluginTypeCurrent, $sVersionCurrent, $sSectionCurrent)
					}" {if $sSortOrderCurrent==$sSorting}selected="selected"{/if}>{$aLang.plugin.admin.plugins.install.filter.sorting.$sSorting}</option>
				{/foreach}
			</select>
			{*
				версия
			*}
			<select class="width-150 js-admin-url-to-go-in-select">
				{foreach Config::Get('plugin.admin.catalog.remote.addons.versions') as $sVersion}
					<option value="{router page='admin/plugins/install'}{request_filter
						name=array('order', 'type', 'version', 'section')
						value=array($sSortOrderCurrent, $sPluginTypeCurrent, $sVersion, $sSectionCurrent)
					}" {if $sVersionCurrent==$sVersion}selected="selected"{/if}>{$aLang.plugin.admin.plugins.install.filter.versions.$sVersion}</option>
				{/foreach}
			</select>
			{*
				секция
			*}
			<select class="width-150 js-admin-url-to-go-in-select">
				{foreach Config::Get('plugin.admin.catalog.remote.addons.sections') as $sSection}
					<option value="{router page='admin/plugins/install'}{request_filter
						name=array('order', 'type', 'version', 'section')
						value=array($sSortOrderCurrent, $sPluginTypeCurrent, $sVersionCurrent, $sSection)
					}" {if $sSectionCurrent==$sSection}selected="selected"{/if}>{$aLang.plugin.admin.plugins.install.filter.sections.$sSection}</option>
				{/foreach}
			</select>
		</div>
		{*
			кнопка сброса кеша списка плагинов (нужна только если включен кеш)
		*}
		{if Config::Get('sys.cache.use')}
			<a class="button" href="{router page='admin/plugins/install/resetcache'}?security_ls_key={$LIVESTREET_SECURITY_KEY}">{$aLang.plugin.admin.plugins.install.update}</a>
		{/if}
	</div>

	<a class="button" href="{router page='admin/plugins/list'}">&larr; {$aLang.plugin.admin.plugins.install.go_to_list}</a>
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
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/plugins/install.addon.tpl"}
			{/foreach}
		{else}
			{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts=$aLang.plugin.admin.plugins.install.no_addons sAlertStyle='info'}
		{/if}
	</div>

	{include file="{$aTemplatePathPlugin.admin}pagination.tpl"}
{/block}