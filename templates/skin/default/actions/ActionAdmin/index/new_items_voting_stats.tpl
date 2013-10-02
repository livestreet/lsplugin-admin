
{*
	Входящие переменные
	todo:
	$sDataType
*}

<div class="votes-graph" title="plus: {$aDataGrowth[$sDataType]['votings']['plus']}, minus: {$aDataGrowth[$sDataType]['votings']['minus']}, abstained: {$aDataGrowth[$sDataType]['votings']['abstained']}, total: {$aDataGrowth[$sDataType]['votings']['total_votes']}">
	{if $aDataGrowth[$sDataType]['votings']['total_votes']}
		<div class="minus" style="width: {$aDataGrowth[$sDataType]['votings']['minus']*100/$aDataGrowth[$sDataType]['votings']['total_votes']}%"></div>
		<div class="abstained" style="width: {$aDataGrowth[$sDataType]['votings']['abstained']*100/$aDataGrowth[$sDataType]['votings']['total_votes']}%"></div>
		<div class="plus" style="width: {$aDataGrowth[$sDataType]['votings']['plus']*100/$aDataGrowth[$sDataType]['votings']['total_votes']}%"></div>
	{/if}
</div>
