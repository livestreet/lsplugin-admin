{**
 * Главная страница
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_content_actionbar'}
	{component 'admin:p-dashboard.actionbar-stats'}
{/block}

{block 'layout_content'}
	{**
	 * График
	 *}
	{include file="{$aTemplatePathPlugin.admin}charts/graph.tpl"
		sGraphTitle             = $aLang.plugin.admin.index.title
		aStats                  = $aDataStats
		sName                   = $aLang.plugin.admin.graph.graph_type.$sCurrentGraphType
		sUrl                    = "{router page='admin'}"
		bShowGraphTypeSelect    = true
		bShowCustomPeriodFields = true}


	{**
	 * Уведомления
	 *}
	{component 'admin:p-dashboard.notifications'}


	{**
	 * Блоки
	 *}
	<div class="p-dashboard-block-group ls-clearfix">
		{component 'admin:p-dashboard.block-activity' events=$aStreamEvents count=$iStreamCount}
		{component 'admin:p-dashboard.block-stats'}
	</div>


	{**
	 * Данные о последнем входе пользователя в админку
	 *}
	{if $aLastVisitData and $aLastVisitData.date}
		{component 'admin:alert' text="{$aLang.plugin.admin.hello.last_visit} {date_format date=$aLastVisitData.date format='j F Y в H:i'}" mods='info'}
	{/if}
{/block}