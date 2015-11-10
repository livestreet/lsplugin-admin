{**
 * Horizontal bar chart
 *
 * @param aData   Данные
 * @param sTitle  Заголовок
 * @param iTotal  Суммарное кол-во объектов
 *
 * @styles stats.css
 *
 * TODO: Унифицировать
 *}

{if $aData and $aData.collection and count($aData.collection) > 0}
	{block name='chart_before'}{/block}

	<div class="chart-bar-h ls-clearfix {block name='chart_classes'}{/block}">
		{block name='chart_content'}
			{block name='chart_header'}
				<h3 class="page-sub-header">{$sTitle}</h3>
			{/block}

			<table class="table chart-bar-h-data">
				{foreach $aData.collection as $aDataItem}
					{$iPercentage = number_format($aDataItem.count * 100 / $iTotal, 2, '.', '')}

					<tr>
						<td class="chart-bar-h-label" title="{$aDataItem.count} {$aLang.plugin.admin.users_stats.users}">
							{$aDataItem.item}
						</td>
						
						<td class="chart-bar-h-count">
							{$aDataItem.count}
						</td>
						
						<td class="chart-bar-h-percentages percent" title="{$aDataItem.count} {$aLang.plugin.admin.users_stats.users}">
							{$iPercentage}%
						</td>

						<td>
							<div class="chart-bar-h-bar" title="{$aDataItem.count} {$aLang.plugin.admin.users_stats.users}">
								<div class="chart-bar-h-bar-value" style="width: {$iPercentage}%;"></div>
							</div>
						</td>
					</tr>
				{/foreach}

				{block name='chart_data_end'}{/block}
			</table>
		{/block}
	</div>
{/if}