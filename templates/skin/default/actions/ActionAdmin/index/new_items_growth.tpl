
	{*
		Отображение прироста объектов
		
		Входящие переменные:
	
			$sDataType - тип данных, которые нужно показать
			$aDataGrowth - массив с данными
	*}
	
	{abs($aDataGrowth[$sDataType]['now_items'])}
	{if $aDataGrowth[$sDataType]['growth']>0}
		<span class="green" title="{$aLang.plugin.admin.index.new_items_for_period}: {$aDataGrowth[$sDataType]['growth']}">&uarr;</span>
	{elseif $aDataGrowth[$sDataType]['growth']<0}
		<span class="red" title="{$aLang.plugin.admin.index.less_items_for_period}: {abs($aDataGrowth[$sDataType]['growth'])}">&darr;</span>
	{/if}
