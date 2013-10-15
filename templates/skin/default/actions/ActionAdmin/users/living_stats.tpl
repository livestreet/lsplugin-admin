
{*
	статистика по странам и городам
*}
{if $aLivingStats and $aLivingStats.collection and count($aLivingStats.collection)>0}
	<div class="countries-n-cities">
		{*
			кнопки управления
		*}
		<div class="fl-r">
			<a href="{router page='admin/users/stats'}{request_filter
				name=array('living_sorting')
				value=array('alphabetic')
			}" class="js-ajax-load button {if $sCurrentLivingSorting=='alphabetic'}active{/if}">A-z</a>

			<a href="{router page='admin/users/stats'}{request_filter
				name=array('living_sorting')
				value=array(null)
			}" class="js-ajax-load button {if $sCurrentLivingSorting=='top'}active{/if}">3-2-1 &darr;</a>
		</div>
		<h3>
			{if $sCurrentLivingSection=='countries'}
				{$aLang.plugin.admin.users_stats.countries} {$aLang.plugin.admin.users_stats.and_text}
				<a href="{router page='admin/users/stats'}{request_filter
					name=array('living_section')
					value=array('cities')
				}" class="js-ajax-load">{$aLang.plugin.admin.users_stats.cities}</a>
			{elseif $sCurrentLivingSection=='cities'}
				<a href="{router page='admin/users/stats'}{request_filter
					name=array('living_section')
					value=array(null)
				}" class="js-ajax-load">{$aLang.plugin.admin.users_stats.countries}</a>
				{$aLang.plugin.admin.users_stats.and_text} {$aLang.plugin.admin.users_stats.cities}
			{/if}
		</h3>

		{if count($aLivingStats.collection)<20}
			<div class="mb-20">
				{$aLang.plugin.admin.users_stats.need_more_data}
			</div>
		{/if}
		{*
			получить массив со списком объектов для короткого представления
		*}
		{assign var=aShortViewLivingStats value=array_splice($aLivingStats.collection, $oConfig->GetValue('plugin.admin.max_items_in_living_users_stats'))}
		{*
			теперь в этом массиве остались данные для полного представления (see array_splice)
		*}
		{assign var=aFullViewLivingStats value=$aLivingStats.collection}

		{*
			вывод данных для полного отображения
		*}
		<table class="table items">
			<thead></thead>
			<tbody>
				{foreach from=$aFullViewLivingStats item=aItemRecord name=ItemsCycle}
					{*
						длина столбика в процентах
					*}
					{assign var=iPercentage value=number_format($aItemRecord.count*100/$aStats.count_all, 2, '.', '')}
					<tr {if $smarty.foreach.ItemsCycle.iteration % 2 == 0}class="second"{/if}>
						<td class="item">
							{*
								название страны или города
							*}
							{$aItemRecord.item}
						</td>
						<td class="count">
							{$aItemRecord.count}
						</td>
						<td class="percentage">
							{$iPercentage} %
						</td>
						<td class="diagram">
							{*
								задать ширину каждого столбика
							*}
							<div class="view-item-wrapper">
								<div class="view-item" style="width: {$iPercentage}%;" title="{$aItemRecord.count} {$aLang.plugin.admin.users_stats.users}"></div>
							</div>
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>

		{*
			вывод данных для короткого отображения
		*}
		{if $aShortViewLivingStats and count($aShortViewLivingStats) > 0}
			<script>
				var iTotalUsersCount = {$aStats.count_all};
			</script>
			<table class="table items">
				<thead></thead>
				<tbody>
				<tr>
					<td class="item">
						<select id="admin_users_stats_living_stats_short_view_select" class="width-150">
							{foreach from=$aShortViewLivingStats item=aItemRecord}
								<option value="{$aItemRecord.count}">{$aItemRecord.item}</option>
							{/foreach}
						</select>
					</td>
					<td class="count" id="admin_users_stats_living_stats_short_view_count"></td>
					<td class="percentage" id="admin_users_stats_living_stats_short_view_percentage"></td>
					<td class="diagram"></td>
				</tr>
				</tbody>
			</table>
		{/if}
	</div>
{/if}
