{**
 * Статистика по пользователям
 *
 * @styles stats.css
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_page_title'}
	{$aLang.plugin.admin.users_stats.title}
{/block}

{block name='layout_content_actionbar'}
	{include file="{$aTemplatePathPlugin.admin}stats.brief.tpl"}
{/block}


{block name='layout_content'}
	{**
	 * График регистраций
	 *}
	{include file="{$aTemplatePathPlugin.admin}charts/graph.tpl"
		sGraphTitle             = $aLang.plugin.admin.users_stats.registrations
		sValueSuffix            = $aLang.plugin.admin.users_stats.users
		aStats                  = $aDataStats
		sName                   = $aLang.plugin.admin.users_stats.registrations
		sUrl                    = "{router page='admin/users/stats'}"
		bShowCustomPeriodFields = true
	}


	{**
	 * Блоки
	 *}
	<div class="home-blocks clearfix">
		{include file="{$aTemplatePathPlugin.admin}blocks/block.home.users.genders.tpl"}
		{include file="{$aTemplatePathPlugin.admin}blocks/block.home.users.stats.tpl"}
	</div>


	{**
	 * Возрастное распределение
	 *}
	{include file="{$aTemplatePathPlugin.admin}charts/chart.bar.vertical.tpl" 
		aData  = $aBirthdaysStats
		sTitle = $aLang.plugin.admin.users_stats.age_stats
	}


	{**
	 * Статистика по странам и городам
	 *}
	<div id="admin_users_stats_living">
		{include file="{$aTemplatePathPlugin.admin}charts/chart.bar.location.tpl" 
			aData = $aLivingStats
			sTitle = $aLang.plugin.admin.users_stats.countries
			iTotal = $aStats.count_all
		}
	</div>
{/block}