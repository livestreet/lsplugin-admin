
	{*
		Отображение прироста объектов
		
		Входящие переменные:
	
			$sDataType - тип данных, которые нужно показать
			$aDataGrowth - массив с данными
	*}
	
	{abs($aDataGrowth[$sDataType]['count'])}
	{if $aDataGrowth[$sDataType]['count']>0}
		<span class="green">&uarr;</span>
	{elseif $aDataGrowth[$sDataType]['count']<0}
		<span class="red">&darr;</span>
	{/if}
