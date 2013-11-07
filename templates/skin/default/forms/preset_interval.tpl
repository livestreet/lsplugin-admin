{*
	Предустановленный временной период
	
	Необходимые переменные:
	
		$sName - имя селекта
		$sId - ид селекта
		$sCurrentPeriod - текущий период
*}

<select {if $sName}name="{$sName}"{/if} class="width-100" {if $sId}id="{$sId}"{/if}>
	<option value="{PluginAdmin_ModuleStats::TIME_INTERVAL_TODAY}" {if $sCurrentPeriod==PluginAdmin_ModuleStats::TIME_INTERVAL_TODAY}selected="selected"{/if}>
		{$aLang.plugin.admin.graph.period_bar[PluginAdmin_ModuleStats::TIME_INTERVAL_TODAY]}
	</option>
	<option value="{PluginAdmin_ModuleStats::TIME_INTERVAL_YESTERDAY}" {if $sCurrentPeriod==PluginAdmin_ModuleStats::TIME_INTERVAL_YESTERDAY}selected="selected"{/if}>
		{$aLang.plugin.admin.graph.period_bar[PluginAdmin_ModuleStats::TIME_INTERVAL_YESTERDAY]}
	</option>
	<option value="{PluginAdmin_ModuleStats::TIME_INTERVAL_WEEK}" {if $sCurrentPeriod==PluginAdmin_ModuleStats::TIME_INTERVAL_WEEK}selected="selected"{/if}>
		{$aLang.plugin.admin.graph.period_bar[PluginAdmin_ModuleStats::TIME_INTERVAL_WEEK]}
	</option>
	<option value="{PluginAdmin_ModuleStats::TIME_INTERVAL_MONTH}" {if $sCurrentPeriod==PluginAdmin_ModuleStats::TIME_INTERVAL_MONTH}selected="selected"{/if}>
		{$aLang.plugin.admin.graph.period_bar[PluginAdmin_ModuleStats::TIME_INTERVAL_MONTH]}
	</option>
</select>
