<table>
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Дата</th>
        <th>Свойства</th>
    </tr>


{foreach $aArticleItems as $oArticleItem}
    <tr>
        <td>{$oArticleItem->getId()}</td>
        <td><a href="{$oArticleItem->getWebUrl()}">{$oArticleItem->getTitle()}</a></td>
        <td>{$oArticleItem->getDateCreate()}</td>
		<td>
			{$aProperties=$oArticleItem->getPropertyList()}
			{foreach $aProperties as $oProperty}
				{$oProperty->getTitle()}: {$oProperty->getValue()->getValueForDisplay()}<br/>
			{/foreach}
		</td>
    </tr>
{/foreach}

</table>