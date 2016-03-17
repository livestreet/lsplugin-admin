{**
 * Таблица новых объектов за период
 *}

<table class="ls-table">
	<tbody>
		{foreach [ 'topics', 'comments', 'blogs', 'registrations' ] as $type}
			<tr>
				<td>
					{$aLang.plugin.admin.index["new_$type"]}
				</td>
				<td class="ls-ta-r" title="{$aLang.plugin.admin.index["new_{$type}_info"]}">
					{if $aDataGrowth[$type]['growth'] > 0}
						<i class="p-icon-stats-up" title="{$aLang.plugin.admin.index.new_items_for_period}: {$aDataGrowth[$type]['growth']}"></i>
					{elseif $aDataGrowth[$type]['growth'] < 0}
						<i class="p-icon-stats-down" title="{$aLang.plugin.admin.index.less_items_for_period}: {abs($aDataGrowth[$type]['growth'])}"></i>
					{/if}

					{abs($aDataGrowth[$type]['now_items'])}
				</td>
				{* <td class="graph-line">
					{component 'admin:p-dashboard.block-stats-content-line'
						sObjectsType=$type
						sDataType='ratings'
						sGraphLineTitle='рейтинг объектов в периоде'}

					{component 'admin:p-dashboard.block-stats-content-line'
						sObjectsType=$type
						sDataType='votings'
						sGraphLineTitle='голоса за объекты в периоде'}
				</td> *}
			</tr>
		{/foreach}
	</tbody>
</table>
