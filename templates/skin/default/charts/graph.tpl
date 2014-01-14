{**
 * График
 *
 * @styles stats.css
 *
 * Необходимые переменные:
 *
 * @param string  $sGraphTitle  					Заголовок графика
 * @param string  $sName  							имя графика ($aLang.plugin.admin.users_stats.registrations)
 * @param string  $sValueSuffix  					суфикс для вывода тултипа ($aLang.plugin.admin.users_stats.users) (не обязательно)
 * @param string  $aStats  							массив с данными для графика ($aUserRegistrationStats)
 * @param string  $sUrl  							URL для сабмита формы ({router page='admin'})
 * @param boolean $bShowGraphTypeSelect  			показывать ли селект выбора типа графика
 * @param boolean $bShowCustomPeriodFields  		показывать ли поля для ручного выбора дат
 * @param boolean $bShowTable  						показывать таблицу с данными графика или нет
 *}

<div class="graph-wrapper">
	{if $sGraphTitle}
		<header class="graph-header">
			<h2 class="graph-title">{$sGraphTitle}</h2>
		</header>
	{/if}

	<div class="graph">
		<div class="graph-filter">
			<form action="{$sUrl}" enctype="application/x-www-form-urlencoded" method="get">
				{*
					нужно ли отображать селект с типами графика для выбора
					tip: установка данной переменной также требует прием значения данного селекта на бекенде для показа данных по типу
				*}
				{if $bShowGraphTypeSelect}
					<select name="filter[graph_type]" class="width-150">
						{foreach array(
							PluginAdmin_ModuleStats::DATA_TYPE_REGISTRATIONS,
							PluginAdmin_ModuleStats::DATA_TYPE_TOPICS,
							PluginAdmin_ModuleStats::DATA_TYPE_COMMENTS,
							PluginAdmin_ModuleStats::DATA_TYPE_VOTINGS
						) as $sGraphType}
							<option value="{$sGraphType}" {if $sCurrentGraphType==$sGraphType}selected="selected"{/if}>
								{$aLang.plugin.admin.graph.graph_type[$sGraphType]}
							</option>
						{/foreach}
					</select>

					&nbsp;
				{/if}


				{*
					предустановленный временной период отображения
				*}
				{include file="{$aTemplatePathPlugin.admin}forms/preset_interval.tpl"
					sName='filter[graph_period]'
					sCurrentPeriod=$sCurrentGraphPeriod
				}

				&nbsp;&nbsp;&nbsp;

				{*
					ручной выбор дат периода
				*}
				{if $bShowCustomPeriodFields}
					<input type="text" name="filter[date_start]" value="{$_aRequest.filter.date_start}" class="input-text width-100 date-picker-php" placeholder="{$aLang.plugin.admin.from}" />
					&nbsp;&ndash;&nbsp;
					<input type="text" name="filter[date_finish]" value="{$_aRequest.filter.date_finish}" class="input-text width-100 date-picker-php" placeholder="{$aLang.plugin.admin.to}" />
					{*
						сброс ручного выбора диапазона дат
					*}
					{if $_aRequest.filter.date_start}
						<a href="{$sUrl}{request_filter
							name=array('date_start', 'date_finish')
							value=array(null, null)
						}"><i class="icon-remove"></i></a>
					{/if}

					&nbsp;&nbsp;
				{/if}


				<button type="submit" class="button button-primary">{$aLang.plugin.admin.show}</button>
			</form>
		</div>

		<div class="graph-body">
			<div id="admin_graph_container"></div>
		</div>

		<script>
			jQuery(document).ready(function($) {
				{*
					docs: api.highcharts.com/highcharts
				*}
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
						{*
							прячет оси, не использовать
						*}
						//margin: 0,
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
								'{$aData['date']}'{if !$aData.last},{/if}
							{/foreach}
						],
						labels: {
							{*
								отключить перенос подписей на несколько строк, если они не влезают (установить в 1 строку)
							*}
							staggerLines: 1,
							{*
								оставить каждую n-нную подпись для точки графика, если их больше, чем может уместиться
							*}
							step: {$iPointsStepForLabels}
						}
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
	</div>


	{**
	 * Показать значения графика в таблице
	 *}

	{if $bShowTable}
		<div class="graph-table">
			<button type="button" class="button" id="admin_show_graph_data_in_table">{$aLang.plugin.admin.graph.values_in_table}</button>

			<div id="admin_graph_table_data" style="display: none">
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>{$aLang.plugin.admin.graph.date}</th>
							<th>{$aLang.plugin.admin.graph.count}</th>
						</tr>
					</thead>
					<tbody>
						{foreach $aStats as $aStatsItem}
							<tr>
								<td>{$aStatsItem@iteration}</td>
								<td>{$aStatsItem['date']}</td>
								<td>{$aStatsItem['count']}</td>
							</tr>
						{/foreach}
					</tbody>
				</table>
			</div>
		</div>
	{/if}
</div>
