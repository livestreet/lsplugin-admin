
	{*
		Отображение линии голосования за новые объекты

		Входящие переменные:

			$sDataType - тип данных, которые нужно показать
			$aDataGrowth - массив с данными
	*}

	<div class="votes-graph" title="плюс: {$aDataGrowth[$sDataType]['votings']['plus']}, минус: {$aDataGrowth[$sDataType]['votings']['minus']}, воздержались: {$aDataGrowth[$sDataType]['votings']['abstained']}, всего: {$aDataGrowth[$sDataType]['votings']['total_votes']}">
		{if $aDataGrowth[$sDataType]['votings']['total_votes']}
			<div class="minus" style="width: {$aDataGrowth[$sDataType]['votings']['minus']*100/$aDataGrowth[$sDataType]['votings']['total_votes']}%">
				{if $aDataGrowth[$sDataType]['votings']['minus']}
					<div class="inner-value">
						{$aDataGrowth[$sDataType]['votings']['minus']}
					</div>
				{/if}
			</div>
			<div class="abstained" style="width: {$aDataGrowth[$sDataType]['votings']['abstained']*100/$aDataGrowth[$sDataType]['votings']['total_votes']}%">
				{if $aDataGrowth[$sDataType]['votings']['abstained']}
					<div class="inner-value">
						{$aDataGrowth[$sDataType]['votings']['abstained']}
					</div>
				{/if}
			</div>
			<div class="plus" style="width: {$aDataGrowth[$sDataType]['votings']['plus']*100/$aDataGrowth[$sDataType]['votings']['total_votes']}%">
				{if $aDataGrowth[$sDataType]['votings']['plus']}
					<div class="inner-value">
						{$aDataGrowth[$sDataType]['votings']['plus']}
					</div>
				{/if}
			</div>
		{/if}
	</div>
