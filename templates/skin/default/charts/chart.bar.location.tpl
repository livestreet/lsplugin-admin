{**
 * Location bar chart
 *
 * @param aData   Данные
 * @param sTitle  Заголовок
 * @param iTotal  Суммарное кол-во объектов
 *
 * @styles stats.css
 *}

{if $aData and $aData.collection and count($aData.collection) > 0}
	{* получить массив со списком объектов для короткого представления *}
	{$aShortViewLivingStats = array_splice($aData.collection, $oConfig->GetValue('plugin.admin.max_items_in_living_users_stats'))}

	{**
	 * Нужно для пересчета процентного соотношения представления стран или городов в коротком виде (в селекте)
	 *}
	<script>
		var iTotalUsersCount = {$iTotal};
	</script>

	<div class="chart-bar-h clearfix chart-bar-location">
		{* кнопки управления *}
		<div class="chart-bar-location-sort">
			<a href="{router page='admin/users/stats'}{request_filter
				name=array('living_sorting')
				value=array('alphabetic')
			}" class="js-ajax-load button {if $sCurrentLivingSorting=='alphabetic'}active{/if}">A-z</a>

			<a href="{router page='admin/users/stats'}{request_filter
				name=array('living_sorting')
				value=array(null)
			}" class="js-ajax-load button {if $sCurrentLivingSorting=='top'}active{/if}">3-2-1 &darr;</a>
		</div>

		<h3 class="page-sub-header">
			{if $sCurrentLivingSection == 'countries'}
				{$aLang.plugin.admin.users_stats.countries} {$aLang.plugin.admin.users_stats.and_text}
				<a href="{router page='admin/users/stats'}{request_filter
					name=array('living_section')
					value=array('cities')
				}" class="js-ajax-load">{$aLang.plugin.admin.users_stats.cities}</a>
			{elseif $sCurrentLivingSection == 'cities'}
				<a href="{router page='admin/users/stats'}{request_filter
					name=array('living_section')
					value=array(null)
				}" class="js-ajax-load">{$aLang.plugin.admin.users_stats.countries}</a>
				{$aLang.plugin.admin.users_stats.and_text} {$aLang.plugin.admin.users_stats.cities}
			{/if}
		</h3>

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

			{**
			 * Вывод данных для короткого отображения
			 *}
			{if $aShortViewLivingStats and count($aShortViewLivingStats) > 0}
				<tr class="chart-bar-location-custom">
					<td class="chart-bar-h-label">
						<select id="admin_users_stats_living_stats_short_view_select" class="width-full">
							{foreach $aShortViewLivingStats as $aItemRecord}
								<option value="{$aItemRecord.count}">{$aItemRecord.item}</option>
							{/foreach}
						</select>
					</td>
					<td class="chart-bar-h-count" id="admin_users_stats_living_stats_short_view_count"></td>
					<td class="chart-bar-h-percentages" id="admin_users_stats_living_stats_short_view_percentage"></td>
					<td></td>
				</tr>
			{/if}
		</table>
	</div>
{/if}