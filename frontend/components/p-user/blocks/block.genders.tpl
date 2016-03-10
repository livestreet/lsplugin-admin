{**
 * Гендерная статистика
 *}

{component_define_params params=[ 'stats' ]}

{capture 'block_content'}
	{**
	 * Значения для каждого пола в процентах
	 *}
	{$iUsersSexOtherPerc = number_format($stats.count_sex_other*100/$stats.count_all, 1, '.', '')}
	{$iUsersSexManPerc = number_format($stats.count_sex_man*100/$stats.count_all, 1, '.', '')}
	{$iUsersSexWomanPerc = number_format($stats.count_sex_woman*100/$stats.count_all, 1, '.', '')}

	<div id="admin_users_sex_pie_graph"></div>

	{* график гендерного распределения пользователей *}
	<script>
		$(function () {
			$('#admin_users_sex_pie_graph').highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
					height: 250,
					width: 250,
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
							color: '#C5C5C5'
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

	<table class="ls-table ls-table--noborders ls-table--condensed chart-pie-legend">
		<tbody>
			<tr>
				<td class="cell-color"><span class="chart-pie-legend-color chart-pie-legend-color-grey"></span></td>
				<td>
					{$aLang.plugin.admin.users_stats.sex_other}
				</td>
				<td class="ls-ta-r">{$stats.count_sex_other}</td>
				<td class="ls-ta-r">{$iUsersSexOtherPerc}%</td>
			</tr>
			<tr>
				<td class="cell-color"><span class="chart-pie-legend-color chart-pie-legend-color-blue"></span></td>
				<td>
					{$aLang.plugin.admin.users_stats.sex_man}
				</td>
				<td class="ls-ta-r">{$stats.count_sex_man}</td>
				<td class="ls-ta-r">{$iUsersSexManPerc}%</td>
			</tr>
			<tr>
				<td class="cell-color"><span class="chart-pie-legend-color chart-pie-legend-color-purple"></span></td>
				<td>
					{$aLang.plugin.admin.users_stats.sex_woman}
				</td>
				<td class="ls-ta-r">{$stats.count_sex_woman}</td>
				<td class="ls-ta-r">{$iUsersSexWomanPerc}%</td>
			</tr>
		</tbody>
	</table>
{/capture}

{component 'admin:block' title=$aLang.plugin.admin.users_stats.gender_stats classes='p-user-genders' content=$smarty.capture.block_content}