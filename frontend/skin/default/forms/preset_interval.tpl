{**
 * Предустановленный временной период
 * 
 * @param $sName           Имя селекта
 * @param $sId             ID селекта
 * @param $sCurrentPeriod  Текущий период
 *}

<select {if $sName}name="{$sName}"{/if} class="width-100" {if $sId}id="{$sId}"{/if}>
	{foreach array(
		PluginAdmin_ModuleStats::TIME_INTERVAL_TODAY,
		PluginAdmin_ModuleStats::TIME_INTERVAL_YESTERDAY,
		PluginAdmin_ModuleStats::TIME_INTERVAL_WEEK,
		PluginAdmin_ModuleStats::TIME_INTERVAL_MONTH
	) as $sTimeInterval}
		<option value="{$sTimeInterval}" {if $sCurrentPeriod == $sTimeInterval}selected="selected"{/if}>
			{$aLang.plugin.admin.graph.period_bar[$sTimeInterval]}
		</option>
	{/foreach}
</select>
