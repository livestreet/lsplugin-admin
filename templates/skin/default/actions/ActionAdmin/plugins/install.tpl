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
		{foreach $oConfig->Get('plugin.admin.catalog.remote.addons.type') as $sPluginType}
			<a class="button {if $sPluginTypeCurrent==$sPluginType}active{/if}" href="{router page='admin/plugins/install'}{request_filter
				name=array('order', 'type', 'category')
				value=array($sSortOrderCurrent, $sPluginType, $sCategoryCurrent)
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
			<select id="admin_plugins_install_sorting" class="width-200">
				{foreach $oConfig->Get('plugin.admin.catalog.remote.addons.sorting') as $sSorting}
					<option value="{router page='admin/plugins/install'}{request_filter
						name=array('order', 'type', 'category')
						value=array($sSorting, $sPluginTypeCurrent, $sCategoryCurrent)
					}" {if $sSortOrderCurrent==$sSorting}selected="selected"{/if}>{$aLang.plugin.admin.plugins.install.filter.sorting.$sSorting}</option>
				{/foreach}
			</select>
			{*
				категория аддонов
			*}
			<select id="admin_plugins_install_category" class="width-150">
				{foreach $oConfig->Get('plugin.admin.catalog.remote.addons.categories') as $sCategory}
					<option value="{router page='admin/plugins/install'}{request_filter
						name=array('order', 'type', 'category')
						value=array($sSortOrderCurrent, $sPluginTypeCurrent, $sCategory)
					}" {if $sCategoryCurrent==$sCategory}selected="selected"{/if}>{$aLang.plugin.admin.plugins.install.filter.categories.$sCategory}</option>
				{/foreach}
			</select>
		</div>
		{*
			кнопка сброса кеша списка плагинов (нужна только если включен кеш)
		*}
		{if Config::Get('sys.cache.use')}
			<a class="button" href="{router page='admin/plugins/install/resetcache'}?security_ls_key={$LIVESTREET_SECURITY_KEY}">Обновить</a>
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
		{foreach $aAddons as $oAddon}
			{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/plugins/install.addon.tpl"}
		{/foreach}
	</div>

	{include file="{$aTemplatePathPlugin.admin}pagination.tpl"}
{/block}