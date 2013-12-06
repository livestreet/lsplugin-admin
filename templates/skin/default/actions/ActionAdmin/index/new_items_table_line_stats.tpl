{**
 * Отображение линии голосований/рейтингов за новые объекты
 *
 * @param $sObjectsType     Тип объектов, которые нужно показать (topics, comments etc)
 * @param $sDataType        Тип данных, которые нужно показать (votings, ratings)
 * @param $sGraphLineTitle  Тайтл для линии голосов и рейтингов
 * @param $aDataGrowth      Весь массив с данными
 *}

<table class="table stats-line-table">
	<tbody>
		<tr>
			<td class="info-tip">
				<i class="icon-info-sign" title="{$sGraphLineTitle}: позитивные: {$aDataGrowth[$sObjectsType][$sDataType]['positive']}, негативные: {$aDataGrowth[$sObjectsType][$sDataType]['negative']}, нейтральные: {$aDataGrowth[$sObjectsType][$sDataType]['neutral']}, всего: {$aDataGrowth[$sObjectsType][$sDataType]['total']}"></i>
			</td>
			<td class="line-block">
				<div class="ratings-graph" title="{$sGraphLineTitle}">

					{if $aDataGrowth[$sObjectsType][$sDataType]['total']}
						<div class="negative" style="width: {$aDataGrowth[$sObjectsType][$sDataType]['negative']*100/$aDataGrowth[$sObjectsType][$sDataType]['total']}%">
							{if $aDataGrowth[$sObjectsType][$sDataType]['negative']}
								<div class="inner-value">
									{$aDataGrowth[$sObjectsType][$sDataType]['negative']}
								</div>
							{/if}
						</div>
						<div class="neutral" style="width: {$aDataGrowth[$sObjectsType][$sDataType]['neutral']*100/$aDataGrowth[$sObjectsType][$sDataType]['total']}%">
							{if $aDataGrowth[$sObjectsType][$sDataType]['neutral']}
								<div class="inner-value">
									{$aDataGrowth[$sObjectsType][$sDataType]['neutral']}
								</div>
							{/if}
						</div>
						<div class="positive" style="width: {$aDataGrowth[$sObjectsType][$sDataType]['positive']*100/$aDataGrowth[$sObjectsType][$sDataType]['total']}%">
							{if $aDataGrowth[$sObjectsType][$sDataType]['positive']}
								<div class="inner-value">
									{$aDataGrowth[$sObjectsType][$sDataType]['positive']}
								</div>
							{/if}
						</div>
					{/if}

				</div>
			</td>
		</tr>
	</tbody>
</table>