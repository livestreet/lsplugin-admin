
	{*
		Необходимые переменные:

			$sValueSuffix - суфикс для вывода тултипа ($aLang.plugin.admin.users_stats.users)
			$aStats - массив с данными для графика ($aUserRegistrationStats)
			$sName - имя графика ($aLang.plugin.admin.users_stats.registrations)

	*}
	<div id="admin_graph_container"></div>
	<script>
		jQuery(document).ready(function($) {
			// docs: api.highcharts.com/highcharts
			Highcharts.setOptions({
				lang: {
					resetZoom: '{$aLang.plugin.admin.reset_zoom}',
					resetZoomTitle: '{$aLang.plugin.admin.reset_zoom_tip}'
				}
			});
			$('#admin_graph_container').highcharts({
				chart: {
					type: 'areaspline',
					height: 200,
					//margin: 0,			// hides axis
					spacingBottom: 0,
					spacingLeft: 0,
					spacingRight: 0,
					spacingTop: 10,
					zoomType: 'x'
				},
				title: {
					text: ''
				},
				yAxis: {
					title: {
						text: ''
					},
					gridLineColor: '#f1f1f1',
					gridLineWidth: 1,
					allowDecimals: false
				},
				tooltip: {
					animation: false,
					shadow: false,
					borderWidth: 0,
					// .highcharts-tooltip
					shared: true,
					valueSuffix: ' {$sValueSuffix}'
				},
				credits: {
					enabled: false
				},
				legend: {
					enabled: false
				},
				plotOptions: {
					areaspline: {
						fillOpacity: 0.5
					}
				},
				xAxis: {
					categories: [
						{foreach from=$aStats item=aData}
							'{$aData['registration_date']}'{if !$aData.last},{/if}
						{/foreach}
					]
				},
				series: [{
					name: '{$sName}',
					color: '#8FCFEA',
					data: [
						{foreach from=$aStats item=aData name=DataCycle}
							[{$smarty.foreach.DataCycle.index}, {$aData['count']}]{if !$aData.last},{/if}
						{/foreach}
					]
				}]
			});
		});
	</script>
