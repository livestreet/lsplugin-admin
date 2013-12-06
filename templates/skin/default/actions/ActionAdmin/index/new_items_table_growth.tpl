{**
 * Отображение прироста объектов
 *
 * @param $sObjectsType Тип объектов, которые нужно показать
 * @param $aDataGrowth  Массив с данными
 *}
	
{abs($aDataGrowth[$sObjectsType]['now_items'])}

{if $aDataGrowth[$sObjectsType]['growth'] > 0}
	<i class="icon-stats-up" title="{$aLang.plugin.admin.index.new_items_for_period}: {$aDataGrowth[$sObjectsType]['growth']}"></i>
{elseif $aDataGrowth[$sObjectsType]['growth'] < 0}
	<i class="icon-stats-down" title="{$aLang.plugin.admin.index.less_items_for_period}: {abs($aDataGrowth[$sObjectsType]['growth'])}"></i>
{/if}
