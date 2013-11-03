{**
 * Гендерная статистика
 *
 * @styles blocks.css
 *}

{extends file="{$aTemplatePathPlugin.admin}blocks/block.aside.base.tpl"}

{block name='block_title'}{$aLang.plugin.admin.users_stats.gender_stats}{/block}
{block name='block_type'}home-users-genders{/block}
{block name='block_class'}block-home{/block}

{block name='block_content'}
	{**
	 * Значения для каждого пола в процентах
	 *}
	{assign var="iUsersSexOtherPerc" value=number_format(($aStats.count_sex_other*100/$aStats.count_all), 1, '.', '')}
	{assign var="iUsersSexManPerc" value=number_format(($aStats.count_sex_man*100/$aStats.count_all), 1, '.', '')}
	{assign var="iUsersSexWomanPerc" value=number_format(($aStats.count_sex_woman*100/$aStats.count_all), 1, '.', '')}

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
{/block}