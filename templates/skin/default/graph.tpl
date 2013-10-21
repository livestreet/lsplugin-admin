{**
 * График
 *
 * @styles stats.css
 *
 * Необходимые переменные:
 *
 * $sValueSuffix - суфикс для вывода тултипа ($aLang.plugin.admin.users_stats.users)
 * $aStats - массив с данными для графика ($aUserRegistrationStats)
 * $sName - имя графика ($aLang.plugin.admin.users_stats.registrations)
 * $sUrl - URL для сабмита формы
 * $bShowGraphTypeSelect - показывать ли селект выбора типа графика
 * $bShowCustomPeriodFields - показывать ли поля для ручного выбора дат
 *
 *}

<div class="graph">
	<header class="graph-header">
		<form action="{$sUrl}" enctype="application/x-www-form-urlencoded" method="get" id="dropdown-menu-graph-settings">
			{*
				нужно ли отображать селект с типами графика для выбора
				tip: установка данной переменной также требует прием значения данного селекта на бекенде для показа данных по типу
			*}
			{if $bShowGraphTypeSelect}
				<select name="filter[graph_type]" class="width-150">
					<option value="{PluginAdmin_ModuleStats::DATA_TYPE_REGISTRATIONS}"
							{if $sCurrentGraphType==PluginAdmin_ModuleStats::DATA_TYPE_REGISTRATIONS}selected="selected"{/if}>{$aLang.plugin.admin.index.show_users}</option>
					<option value="{PluginAdmin_ModuleStats::DATA_TYPE_TOPICS}"
							{if $sCurrentGraphType==PluginAdmin_ModuleStats::DATA_TYPE_TOPICS}selected="selected"{/if}>{$aLang.plugin.admin.index.show_topics}</option>
					<option value="{PluginAdmin_ModuleStats::DATA_TYPE_COMMENTS}"
							{if $sCurrentGraphType==PluginAdmin_ModuleStats::DATA_TYPE_COMMENTS}selected="selected"{/if}>{$aLang.plugin.admin.index.show_comments}</option>
					<option value="{PluginAdmin_ModuleStats::DATA_TYPE_VOTINGS}"
							{if $sCurrentGraphType==PluginAdmin_ModuleStats::DATA_TYPE_VOTINGS}selected="selected"{/if}>{$aLang.plugin.admin.index.show_votings}</option>
				</select>
			{/if}


			&nbsp;

			{*
				предустановленный временной период отображения
			*}
			<select name="filter[graph_period]" class="width-100">
				<option value="{PluginAdmin_ModuleStats::TIME_INTERVAL_TODAY}"
						{if $sCurrentGraphPeriod==PluginAdmin_ModuleStats::TIME_INTERVAL_TODAY}selected="selected"{/if}>{$aLang.plugin.admin.index.period_bar.today}</option>
				<option value="{PluginAdmin_ModuleStats::TIME_INTERVAL_YESTERDAY}"
						{if $sCurrentGraphPeriod==PluginAdmin_ModuleStats::TIME_INTERVAL_YESTERDAY}selected="selected"{/if}>{$aLang.plugin.admin.index.period_bar.yesterday}</option>
				<option value="{PluginAdmin_ModuleStats::TIME_INTERVAL_WEEK}"
						{if $sCurrentGraphPeriod==PluginAdmin_ModuleStats::TIME_INTERVAL_WEEK}selected="selected"{/if}>{$aLang.plugin.admin.index.period_bar.week}</option>
				<option value="{PluginAdmin_ModuleStats::TIME_INTERVAL_MONTH}"
						{if $sCurrentGraphPeriod==PluginAdmin_ModuleStats::TIME_INTERVAL_MONTH}selected="selected"{/if}>{$aLang.plugin.admin.index.period_bar.month}</option>
			</select>


			&nbsp;&nbsp;&nbsp;

			{*
				ручной выбор дат периода
			*}
			{if $bShowCustomPeriodFields}
				<input type="text" name="filter[date_start]" value="{$_aRequest.filter.date_start}" class="input-text width-100 date-picker-php" placeholder="{$aLang.plugin.admin.from}" />
				&nbsp;&ndash;&nbsp;
				<input type="text" name="filter[date_finish]" value="{$_aRequest.filter.date_finish}" class="input-text width-100 date-picker-php" placeholder="{$aLang.plugin.admin.to}" />
				{if $_aRequest.filter.date_start}
					<a href="{$sUrl}{request_filter
						name=array('date_start', 'date_finish')
						value=array(null, null)
					}" class="remove-custom-period-selection"><i class="icon-remove"></i></a>
				{/if}

				&nbsp;&nbsp;
			{/if}


			<button type="submit" class="button button-primary">{$aLang.plugin.admin.show}</button>
		</form>
	</header>

	<div class="graph-body">
		<div id="admin_graph_container"></div>
	</div>
</div>


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
						'{$aData['date']}'{if !$aData.last},{/if}
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
