{**
 * Гендерная статистика
 *}

{capture 'block_content'}
	{**
	 * Значения для каждого пола в процентах
	 *}
	{$iUsersSexOtherPerc = number_format($aStats.count_sex_other*100/$aStats.count_all, 1, '.', '')}
	{$iUsersSexManPerc = number_format($aStats.count_sex_man*100/$aStats.count_all, 1, '.', '')}
	{$iUsersSexWomanPerc = number_format($aStats.count_sex_woman*100/$aStats.count_all, 1, '.', '')}

	<div id="admin_users_sex_pie_graph"></div>

	{* график гендерного распределения пользователей *}
	<script>
		jQuery(document).ready(function($) {
			$('#admin_users_sex_pie_graph').highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
					height: 250,
					width: 250,
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

	<table class="table chart-pie-legend">
		<tbody>
			<tr>
				<td class="cell-color"><span class="chart-pie-legend-color chart-pie-legend-color-grey"></span></td>
				<td>
					{$aLang.plugin.admin.users_stats.sex_other}
				</td>
				<td class="ta-r">{$aStats.count_sex_other}</td>
				<td class="ta-r percent">{$iUsersSexOtherPerc} %</td>
			</tr>
			<tr>
				<td class="cell-color"><span class="chart-pie-legend-color chart-pie-legend-color-blue"></span></td>
				<td>
					{$aLang.plugin.admin.users_stats.sex_man}
				</td>
				<td class="ta-r">{$aStats.count_sex_man}</td>
				<td class="ta-r percent">{$iUsersSexManPerc} %</td>
			</tr>
			<tr>
				<td class="cell-color"><span class="chart-pie-legend-color chart-pie-legend-color-purple"></span></td>
				<td>
					{$aLang.plugin.admin.users_stats.sex_woman}
				</td>
				<td class="ta-r">{$aStats.count_sex_woman}</td>
				<td class="ta-r percent">{$iUsersSexWomanPerc} %</td>
			</tr>
		</tbody>
	</table>
{/capture}

{component 'admin:block' title=$aLang.plugin.admin.users_stats.gender_stats content=$smarty.capture.block_content}