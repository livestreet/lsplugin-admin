{**
 * Статистика по пользователям
 *
 * @styles stats.css
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_page_title'}
	{$aLang.plugin.admin.users_stats.title}
{/block}

{block 'layout_content_actionbar'}
	{component 'admin:p-dashboard.actionbar-stats'}
{/block}

{block 'layout_content'}
	{**
	 * График регистраций
	 *}
	{component 'admin:p-graph'
		title=$aLang.plugin.admin.users_stats.registrations
		data=$aDataStats
		name=$aLang.plugin.admin.users_stats.registrations
		url={router page='admin/users/stats'}
		showFilterPeriod=true}

	{**
	 * Блоки
	 *}
	<div class="p-dashboard-block-group ls-clearfix">
		{component 'admin:p-user.block-genders' stats=$aStats}
		{component 'admin:p-user.block-activity' stats=$aStats rating=$aGoodAndBadUsers}
	</div>

	{**
	 * Возрастное распределение
	 *}
	{component 'admin:p-user.chart-age' data=$aBirthdaysStats title=$aLang.plugin.admin.users_stats.age_stats}

	{**
	 * Статистика по странам и городам
	 *}
	<div id="admin_users_stats_living">
		{component 'admin:p-user.chart-location' data=$aLivingStats total=$aStats.count_all section=$sCurrentLivingSection sorting=$sCurrentLivingSorting}
	</div>
{/block}