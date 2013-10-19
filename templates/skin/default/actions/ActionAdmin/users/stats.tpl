{**
 * Статистика
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
	<div class="users-stats">
		{*
			график
		*}
		<h3>{$aLang.plugin.admin.users_stats.registrations}</h3>

		{include file="{$aTemplatePathPlugin.admin}graph.tpl"
			sValueSuffix = $aLang.plugin.admin.users_stats.users
			aStats       = $aDataStats
			sName        = $aLang.plugin.admin.users_stats.registrations
			sUrl         = {router page='admin/users/stats'}
			bShowCustomPeriodFields=true
		}

		{*
			значения таблицей
		*}
		<div class="value-in-table">
			<a href="#" id="admin_users_show_graph_stats_in_table">{$aLang.plugin.admin.users_stats.values_in_table}</a>
			<div id="admin_users_graph_table_stats_data">
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>{$aLang.plugin.admin.users_stats.date}</th>
							<th>{$aLang.plugin.admin.users_stats.count}</th>
						</tr>
					</thead>
					<tbody>
						{foreach from=$aDataStats item=aUserRegData name=UsersRegCycle}
							<tr>
								<td>
									{$smarty.foreach.UsersRegCycle.iteration}
								</td>
								<td>
									{$aUserRegData['original_date']}
								</td>
								<td>
									{$aUserRegData['count']}
								</td>
							</tr>
						{/foreach}
					</tbody>
				</table>
			</div>
		</div>
		{*
			круговая диаграмма гендерного распределения и активность
		*}
		<div class="stat-line">
			<div class="w50p first-block">
				<h3>{$aLang.plugin.admin.users_stats.gender_stats}</h3>
				{*
					значения для каждого пола в процентах
				*}
				{assign var="iUsersSexOtherPerc" value=number_format(($aStats.count_sex_other*100/$aStats.count_all), 1, '.', '')}
				{assign var="iUsersSexManPerc" value=number_format(($aStats.count_sex_man*100/$aStats.count_all), 1, '.', '')}
				{assign var="iUsersSexWomanPerc" value=number_format(($aStats.count_sex_woman*100/$aStats.count_all), 1, '.', '')}

				<div class="users-sex-pie-stats">
					<div id="admin_users_sex_pie_graph"></div>
					<script>
						{*
							график гендерного распределения пользователей
						*}
						jQuery(document).ready(function($) {
							$('#admin_users_sex_pie_graph').highcharts({
								chart: {
									plotBackgroundColor: null,
									plotBorderWidth: null,
									plotShadow: false,
									height: 150,
									width: 150,
									//margin: 0,			// hides axis
									spacingBottom: 0,
									spacingLeft: 0,
									spacingRight: 0,
									spacingTop: 0
								},
								title: {
									text: ''
								},
								tooltip: {
									animation: false,
									shadow: false,
									borderWidth: 0
									// .highcharts-tooltip
								},
								credits: {
									enabled: false
								},
								plotOptions: {
									pie: {
										allowPointSelect: true,
										cursor: 'pointer',
										dataLabels: {
											enabled: false
										}
									}
								},
								series: [{
									type: 'pie',
									name: '{$aLang.plugin.admin.users_stats.percent_from_all}',
									data: [
										{
											name: '{$aLang.plugin.admin.users_stats.sex_other}',
											y: {$iUsersSexOtherPerc},
											color: '#F5F1FF'
										},
										{
											name: '{$aLang.plugin.admin.users_stats.sex_man}',
											y: {$iUsersSexManPerc},
											color: '#94E3E6'
										},
										{
											name: '{$aLang.plugin.admin.users_stats.sex_woman}',
											y: {$iUsersSexWomanPerc},
											color: '#FACBFF'
										}
									]
								}]
							});
						});
					</script>
				</div>
				<div class="users-sex-table-stats">
					<table class="table">
						<thead></thead>
						<tbody>
							<tr>
								<td>
									<span class="users-sex-indicator other"></span>
									{$aLang.plugin.admin.users_stats.sex_other}
								</td>
								<td class="text-right">
									{$aStats.count_sex_other}
								</td>
								<td class="text-right">
									{$iUsersSexOtherPerc} %
								</td>
							</tr>
							<tr>
								<td>
									<span class="users-sex-indicator man"></span>
									{$aLang.plugin.admin.users_stats.sex_man}
								</td>
								<td class="text-right">
									{$aStats.count_sex_man}
								</td>
								<td class="text-right">
									{$iUsersSexManPerc} %
								</td>
							</tr>
							<tr>
								<td>
									<span class="users-sex-indicator woman"></span>
									{$aLang.plugin.admin.users_stats.sex_woman}
								</td>
								<td class="text-right">
									{$aStats.count_sex_woman}
								</td>
								<td class="text-right">
									{$iUsersSexWomanPerc} %
								</td>
							</tr>
							<tr>
								<td>
									<hr>		{* просто временный разделитель *}
								</td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>
									{$aLang.plugin.admin.users_stats.total}
								</td>
								<td class="text-right">
									{$aStats.count_all}
								</td>
								<td>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="w50p second-block">
				<h3>{$aLang.plugin.admin.users_stats.activity}</h3>
				<table class="table">
					<thead></thead>
					<tbody>
						<tr>
							<td>
								{$aLang.plugin.admin.users_stats.activity_active}
							</td>
							<td class="text-right">
								{$aStats.count_active}
							</td>
							<td class="text-right">
								{number_format(($aStats.count_active*100/$aStats.count_all), 1, '.', '')} %
							</td>
						</tr>
						<tr>
							<td>
								{$aLang.plugin.admin.users_stats.activity_passive}
							</td>
							<td class="text-right">
								{$aStats.count_inactive}
							</td>
							<td class="text-right">
								{number_format(($aStats.count_inactive*100/$aStats.count_all), 1, '.', '')} %
							</td>
						</tr>
						<tr>
							<td>
								<hr>		{* просто временный разделитель *}
							</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>
								{$aLang.plugin.admin.users_stats.good_users}
							</td>
							<td class="text-right">
								{$aGoodAndBadUsers.good_users}
							</td>
							<td class="text-right">
								{number_format(($aGoodAndBadUsers.good_users*100/$aGoodAndBadUsers.total), 1, '.', '')} %
							</td>
						</tr>
						<tr>
							<td>
								{$aLang.plugin.admin.users_stats.bad_users}
							</td>
							<td class="text-right">
								{$aGoodAndBadUsers.bad_users}
							</td>
							<td class="text-right">
								{number_format(($aGoodAndBadUsers.bad_users*100/$aGoodAndBadUsers.total), 1, '.', '')} %
							</td>
						</tr>
					</tbody>
				</table>

			</div>
		</div>
		{*
			возрастное распределение
		*}
		{if $aBirthdaysStats and $aBirthdaysStats.collection and count($aBirthdaysStats.collection)>0}
			<div class="users-age">
				<h3>{$aLang.plugin.admin.users_stats.age_stats}</h3>
				{if count($aBirthdaysStats.collection)<20}
					<div class="mb-20">
						{$aLang.plugin.admin.users_stats.need_more_data}
					</div>
				{/if}
				<ul class="age-stats">
					{foreach from=$aBirthdaysStats.collection item=aAgeRecord name=AgeCycle}
						{*
							высота столбика в процентах
						*}
						{assign var=iHeight value=$aAgeRecord.count*100/$aBirthdaysStats.max_one_age_users_count}
						{*
							смещение каждого столбика и подписи в пикселях относительно соседа на 15px
						*}
						{assign var=iOffset value=$smarty.foreach.AgeCycle.index*15}
						<li class="holder">
							{*
								задать высоту и смещение каждого столбика относительно соседа
							*}
							<div class="age-item" style="height: {$iHeight}%; left: {$iOffset}px;" title="{$aAgeRecord.count} пользователей"></div>
							{*
								сделать подпись к столбику и смещение каждой подписи относительно соседа,
								каждая вторая запись будет немного светлее чтобы цифры не сливались в кашу
							*}
							<div class="years {if $smarty.foreach.AgeCycle.iteration % 2 == 0}second{/if}"
								 style="left: {$iOffset}px;" title="{$aAgeRecord.count} {$aLang.plugin.admin.users_stats.users}">
								{$aAgeRecord.years_old}
							</div>
						</li>
					{/foreach}
				</ul>
			</div>
		{/if}

		{*
			статистика по странам и городам
		*}
		<div id="admin_users_stats_living">
			{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/living_stats.tpl" iTotalUsersCount=$aStats.count_all}
		</div>

	</div>

{/block}