{**
 * Статистика по комментариям, топикам и т.д.
 *}

{extends 'component@admin:block'}

{block 'block_options' append}
    {$classes = "$classes js-admin-block-stats"}
    {$mods = "$mods nopadding"}
    {$title = $aLang.plugin.admin.index.new_items}
    {$tabs = [
        'classes' => 'js-tabs-block',
        'tabs' => [
            [
                'text' => $aLang.plugin.admin.graph.period_bar[PluginAdmin_ModuleStats::TIME_INTERVAL_TODAY],
                'url' => "{router page='admin'}ajax-get-new-items-block",
                'content' => {component 'admin:p-dashboard.block-stats-content'},
                'attributes' => [ 'data-param-filter[newly_added_items_period]' => PluginAdmin_ModuleStats::TIME_INTERVAL_TODAY ]
            ],
            [
                'text' => $aLang.plugin.admin.graph.period_bar[PluginAdmin_ModuleStats::TIME_INTERVAL_YESTERDAY],
                'url' => "{router page='admin'}ajax-get-new-items-block",
                'attributes' => [ 'data-param-filter[newly_added_items_period]' => PluginAdmin_ModuleStats::TIME_INTERVAL_YESTERDAY ]
            ],
            [
                'text' => $aLang.plugin.admin.graph.period_bar[PluginAdmin_ModuleStats::TIME_INTERVAL_WEEK],
                'url' => "{router page='admin'}ajax-get-new-items-block",
                'attributes' => [ 'data-param-filter[newly_added_items_period]' => PluginAdmin_ModuleStats::TIME_INTERVAL_WEEK ]
            ],
            [
                'text' => $aLang.plugin.admin.graph.period_bar[PluginAdmin_ModuleStats::TIME_INTERVAL_MONTH],
                'url' => "{router page='admin'}ajax-get-new-items-block",
                'attributes' => [ 'data-param-filter[newly_added_items_period]' => PluginAdmin_ModuleStats::TIME_INTERVAL_MONTH ]
            ]
        ]
    ]}
{/block}