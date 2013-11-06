{**
 * Vertical bar chart
 *
 * @param aData  Данные
 * @param sTitle Заголовок
 *
 * @styles stats.css
 *
 * TODO: Унифицировать
 *}

{if $aData and $aData.collection and count($aData.collection) > 0}
	<div class="mb-30">
		<h3 class="page-sub-header">{$sTitle}</h3>

		{if count($aData.collection) < 20}
			{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts=$aLang.plugin.admin.users_stats.need_more_data sAlertStyle='info'}
		{/if}

		{strip}
			<ul class="chart-bar-v">
				{foreach $aData.collection as $aDataItem}
					{* Высота столбика в процентах *}
					{$iPercentage = number_format($aDataItem.count * 100 / $aData.max_one_age_users_count, 2, '.', '')}

					<li class="chart-bar-v-item">
						<div class="chart-bar-v-bar" style="height: {$iPercentage}%;" title="{$aDataItem.count} {$aLang.plugin.admin.users_stats.users}"></div>
						
						<div class="chart-bar-v-value {if $aDataItem@iteration % 2 == 0}even{/if}" title="{$aDataItem.count} {$aLang.plugin.admin.users_stats.users}">
							{$aDataItem.years_old}
						</div>
					</li>
				{/foreach}
			</ul>
		{/strip}
	</div>
{/if}