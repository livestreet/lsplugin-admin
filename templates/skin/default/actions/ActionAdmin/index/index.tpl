{**
 * Главная страница
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}


{block name='layout_content_actionbar'}
	{include file="{$aTemplatePathPlugin.admin}misc/stats.brief.tpl"}
{/block}


{block name='layout_content'}
	{**
	 * График
	 *}
	{include file="{$aTemplatePathPlugin.admin}charts/graph.tpl"
		sGraphTitle             = $aLang.plugin.admin.index.title
		aStats                  = $aDataStats
		sName                   = $aLang.plugin.admin.graph.graph_type.$sCurrentGraphType
		sUrl                    = "{router page='admin'}"
		bShowGraphTypeSelect    = true
		bShowCustomPeriodFields = true
	}


	{**
	 * Уведомления
	 *}
	<ul class="stats-notifications">
		{* Обновления плагинов *}
		<li class="stats-notifications-item stats-notifications-item-plugins {if $iPluginUpdates}active{/if}">
			<figure class="stats-notifications-image"></figure>
			<h3><a href="{router page='admin/plugins/list'}" class="link-border"><span>{$aLang.plugin.admin.index.updates.plugins.title}</span></a></h3>
			{if $iPluginUpdates}
				<p><a href="{router page='admin/plugins/list'}?type=updates" class="link-border"
							><span>{$aLang.plugin.admin.index.updates.plugins.there_are_n_updates|ls_lang:"count%%`$iPluginUpdates`"}</span></a></p>
			{else}
				<p><a href="{router page='admin/plugins/list'}" class="link-border"><span>{$aLang.plugin.admin.index.updates.plugins.no_updates}</span></a></p>
			{/if}
		</li>
		<li class="stats-notifications-item stats-notifications-item-users">
			<figure class="stats-notifications-image"></figure>
			<h3><a href="#" class="link-border"><span>Пользователи</span></a></h3>
			<p><a href="#" class="link-border"><span>Есть 2 обновления</span></a></p>
		</li>
		<li class="stats-notifications-item stats-notifications-item-support">
			<figure class="stats-notifications-image"></figure>
			<h3><a href="#" class="link-border"><span>Обратная связь</span></a></h3>
			<p><a href="#" class="link-border"><span>Есть 2 обновления</span></a></p>
		</li>
	</ul>


	{**
	 * Блоки
	 *}
	<div class="home-blocks clearfix">
		{include file="{$aTemplatePathPlugin.admin}blocks/block.home.activity.tpl"}
		{include file="{$aTemplatePathPlugin.admin}blocks/block.home.stats.tpl"}
	</div>


	{**
	 * Данные о последнем входе пользователя в админку
	 *}
	{if $aLastVisitData.date}
		{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts="{$aLang.plugin.admin.hello.last_visit} {date_format date=$aLastVisitData.date format="j F Y в H:i"}."}
	{/if}
{/block}