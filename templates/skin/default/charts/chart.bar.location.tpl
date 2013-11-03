{**
 * Location bar chart
 *
 * @param aData   Данные
 * @param sTitle  Заголовок
 * @param iTotal  Суммарное кол-во объектов
 *
 * @styles stats.css
 *}

{extends file="{$aTemplatePathPlugin.admin}charts/chart.bar.horizontal.tpl"}


{block name='chart_classes'}chart-bar-location{/block}


{block name='chart_header'}
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
{/block}


{block name='chart_before'}
	{* получить массив со списком объектов для короткого представления *}
	{$aShortViewLivingStats = array_splice($aData.collection, $oConfig->GetValue('plugin.admin.max_items_in_living_users_stats'))}

	{**
	 * Нужно для пересчета процентного соотношения представления стран или городов в коротком виде (в селекте)
	 *}
	<script>
		var iTotalUsersCount = {$iTotal};
	</script>
{/block}


{block name='chart_data_end'}
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
{/block}