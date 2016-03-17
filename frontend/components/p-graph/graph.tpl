{**
 * 
 *}

{$component = 'p-graph'}
{component_define_params params=[ 'url', 'data', 'name', 'title', 'showFilterPeriod', 'showFilterType' ]}

<div class="{$component} {cmods name=$component mods=$mods} {$classes}" {cattr list=$attributes}>
    <h2 class="{$component}-title">{$title}</h2>

    <div class="{$component}-body">
        <form class="{$component}-filter" action="{$url}" method="get">
            {*
                нужно ли отображать селект с типами графика для выбора
                tip: установка данной переменной также требует прием значения данного селекта на бекенде для показа данных по типу
            *}
            {if $showFilterType}
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

            {* предустановленный временной период отображения *}
            <select name="filter[graph_period]" class="width-100">
                {foreach array(
                    PluginAdmin_ModuleStats::TIME_INTERVAL_TODAY,
                    PluginAdmin_ModuleStats::TIME_INTERVAL_YESTERDAY,
                    PluginAdmin_ModuleStats::TIME_INTERVAL_WEEK,
                    PluginAdmin_ModuleStats::TIME_INTERVAL_MONTH
                ) as $sTimeInterval}
                    <option value="{$sTimeInterval}" {if $sCurrentGraphPeriod == $sTimeInterval}selected="selected"{/if}>
                        {$aLang.plugin.admin.graph.period_bar[$sTimeInterval]}
                    </option>
                {/foreach}
            </select>

            &nbsp;&nbsp;&nbsp;

            {* ручной выбор дат периода *}
            {if $showFilterPeriod}
                <input type="text" name="filter[date_start]" value="{$_aRequest.filter.date_start}" class="input-text width-100 date-picker-php" placeholder="{$aLang.plugin.admin.from}" />
                &nbsp;&ndash;&nbsp;
                <input type="text" name="filter[date_finish]" value="{$_aRequest.filter.date_finish}" class="input-text width-100 date-picker-php" placeholder="{$aLang.plugin.admin.to}" />
                {* сброс ручного выбора диапазона дат *}
                {if $_aRequest.filter.date_start}
                    <a href="{$url}{request_filter name=array('date_start', 'date_finish') value=array(null, null)}">
                        <i class="icon-remove"></i>
                    </a>
                {/if}

                &nbsp;&nbsp;
            {/if}

            {component 'admin:button' text=$aLang.plugin.admin.show mods='primary'}
        </form>
        <div id="admin_graph_container"></div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
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
                    {foreach $data as $item}
                        '{$item['date']}'{if !$item@last},{/if}
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
                name: '{$name}',
                color: '#8FCFEA',
                data: [
                    {foreach $data as $item}
                        [{$item@index}, {$item['count']}]{if !$item@last},{/if}
                    {/foreach}
                ]
            }]
        });
    });
</script>