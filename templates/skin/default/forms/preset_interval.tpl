{*
	Предустановленный временной период
	
	Необходимые переменные:
	
		$sName - имя селекта
		$sId - ид селекта
		$sCurrentPeriod - текущий период
*}

<select {if $sName}name="{$sName}"{/if} class="width-100" {if $sId}id="{$sId}"{/if}>
	{foreach from=array(
		PluginAdmin_ModuleStats::TIME_INTERVAL_TODAY,
		PluginAdmin_ModuleStats::TIME_INTERVAL_YESTERDAY,
		PluginAdmin_ModuleStats::TIME_INTERVAL_WEEK,
		PluginAdmin_ModuleStats::TIME_INTERVAL_MONTH
	) item=sTimeInterval}
		<option value="{$sTimeInterval}" {if $sCurrentPeriod==$sTimeInterval}selected="selected"{/if}>
			{$aLang.plugin.admin.graph.period_bar[$sTimeInterval]}
		</option>
	{/foreach}
</select>
