{**
 * Список статей
 *
 * @param array $aArticleItems Список статей
 *}

{if $aArticleItems}
	<table class="ls-table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Название</th>
				<th>Дата</th>
				<th>Свойства</th>
			</tr>
		</thead>

		<tbody>
			{foreach $aArticleItems as $oArticleItem}
				<tr>
					<td>{$oArticleItem->getId()}</td>
					<td><a href="{$oArticleItem->getWebUrl()}">{$oArticleItem->getTitle()}</a></td>
					<td>{date_format date=$oArticleItem->getDateCreate() format="j F Y"}</td>
					<td>
						{$aProperties = $oArticleItem->property->getPropertyList()}
						{foreach $aProperties as $oProperty}
							{$oProperty->getTitle()}: {$oProperty->getValue()->getValueForDisplay()}<br/>
						{/foreach}
					</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
{else}
	{component 'alert' text='Список статей пуст'}
{/if}