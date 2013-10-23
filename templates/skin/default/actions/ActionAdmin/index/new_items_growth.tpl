{**
 * Отображение прироста объектов
 * 
 * @param string sDataType     Тип данных, которые нужно показать
 * @param array  aDataGrowth   Массив с данными
 *}
	
{abs($aDataGrowth[$sDataType]['now_items'])}

{if $aDataGrowth[$sDataType]['growth'] > 0}
	<i class="icon-stats-up" title="{$aLang.plugin.admin.index.new_items_for_period}: {$aDataGrowth[$sDataType]['growth']}"></i>
{elseif $aDataGrowth[$sDataType]['growth'] < 0}
	<i class="icon-stats-down" title="{$aLang.plugin.admin.index.less_items_for_period}: {abs($aDataGrowth[$sDataType]['growth'])}"></i>
{/if}