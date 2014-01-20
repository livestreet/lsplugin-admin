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
		<button class="button button-icon js-dropdown" data-dropdown-target="dropdown-admin-plugins-install-sorting" id="dropdown_admin_plugins_install_sorting_button">
			<i class="icon-settings-14"></i>{* todo: sort icon or "A-z" *}
		</button>
		<div class="dropdown-menu p15" id="dropdown-admin-plugins-install-sorting">
			{*
				сортировка
			*}
			<div class="addons-sorting mb-15">
				{foreach $oConfig->Get('plugin.admin.catalog.remote.addons.sorting') as $sSorting}
					<a class="button {if $sSortOrderCurrent==$sSorting}active{/if}" href="{router page='admin/plugins/install'}{request_filter
						name=array('order', 'type', 'category')
						value=array($sSorting, $sPluginTypeCurrent, $sCategoryCurrent)
					}">{$aLang.plugin.admin.plugins.install.filter.sorting.$sSorting}</a>
				{/foreach}
			</div>
			{*
				категория аддонов
			*}
			<div class="addons-category">
				{foreach $oConfig->Get('plugin.admin.catalog.remote.addons.categories') as $sCategory}
					<a class="button {if $sCategoryCurrent==$sCategory}active{/if}" href="{router page='admin/plugins/install'}{request_filter
						name=array('order', 'type', 'category')
						value=array($sSortOrderCurrent, $sPluginTypeCurrent, $sCategory)
					}">{$aLang.plugin.admin.plugins.install.filter.categories.$sCategory}</a>
				{/foreach}
			</div>

		</div>
		{*
			кнопка сброса кеша списка плагинов
		*}
		<a class="button" href="{router page='admin/plugins/install/resetcache'}?security_ls_key={$LIVESTREET_SECURITY_KEY}">Обновить</a>
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