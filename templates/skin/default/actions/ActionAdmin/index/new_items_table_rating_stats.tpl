
	{*
		Отображение линии рейтингов за новые объекты

		Входящие переменные:

			$sDataType - тип данных, которые нужно показать
			$aDataGrowth - массив с данными
	*}

	<div class="ratings-graph" title="позитивные: {$aDataGrowth[$sDataType]['ratings']['positive']}, негативные: {$aDataGrowth[$sDataType]['ratings']['negative']}, нейтральные: {$aDataGrowth[$sDataType]['ratings']['neutral']}, всего: {$aDataGrowth[$sDataType]['ratings']['total_objects']}">
		{if $aDataGrowth[$sDataType]['ratings']['total_objects']}
			<div class="negative" style="width: {$aDataGrowth[$sDataType]['ratings']['negative']*100/$aDataGrowth[$sDataType]['ratings']['total_objects']}%">
				{if $aDataGrowth[$sDataType]['ratings']['negative']}
					<div class="inner-value">
						{$aDataGrowth[$sDataType]['ratings']['negative']}
					</div>
				{/if}
			</div>
			<div class="neutral" style="width: {$aDataGrowth[$sDataType]['ratings']['neutral']*100/$aDataGrowth[$sDataType]['ratings']['total_objects']}%">
				{if $aDataGrowth[$sDataType]['ratings']['neutral']}
					<div class="inner-value">
						{$aDataGrowth[$sDataType]['ratings']['neutral']}
					</div>
				{/if}
			</div>
			<div class="positive" style="width: {$aDataGrowth[$sDataType]['ratings']['positive']*100/$aDataGrowth[$sDataType]['ratings']['total_objects']}%">
				{if $aDataGrowth[$sDataType]['ratings']['positive']}
					<div class="inner-value">
						{$aDataGrowth[$sDataType]['ratings']['positive']}
					</div>
				{/if}
			</div>
		{/if}
	</div>
