
{**
 * Установка дополнений из каталога
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_page_title'}
	{$aLang.plugin.admin.plugins.install.title} {if $aPaging}({$aPaging.iCount}){/if}
{/block}


{block name='layout_content_actionbar'}
	<div class="fl-r">
		{*
			тип плагинов
		*}
		{foreach $oConfig->Get('plugin.admin.catalog.remote.plugins.type') as $sPluginType}
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
				{foreach $oConfig->Get('plugin.admin.catalog.remote.plugins.sorting') as $sSorting}
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
	</div>

	<a class="button" href="{router page='admin/plugins/list'}">&larr; {$aLang.plugin.admin.plugins.install.go_to_list}</a>
{/block}


{block name='layout_content'}
	{*
		справка
	*}
	<a href="#" class="fl-r js-catalog-toggle-tip-button" title="{$aLang.plugin.admin.plugins.install.tip_button}"><i class="icon-question-sign"></i></a>
	<div class="catalog-install-info js-catalog-tip-message" style="display: none;">
		{$aLang.plugin.admin.plugins.install.tip}
	</div>

	{*
		вывод дополнений
	*}
	<div class="all-addons-container">
		{foreach $aAddons as $oAddon}
			{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/plugins/install.addon.tpl"}
		{/foreach}
	</div>


	{include file="{$aTemplatePathPlugin.admin}pagination.tpl" aPaging=$aPaging}

{/block}