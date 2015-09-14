{**
 * Список статей
 *
 * @param array $aArticleItems Список статей
 *}

<h3 class="page-sub-header">Список статей</h3>

<a href="{$oAdminUrl->get('create')}" class="button button-primary">Добавить статью</a>

<br>
<br>

{if $aArticleItems}
	<table class="table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Название</th>
				<th>Дата</th>
				<th class="ta-r">Действие</th>
			</tr>
		</thead>

		<tbody>
			{foreach $aArticleItems as $oArticleItem}
				<tr id="article-item-{$oArticleItem->getId()}">
					<td>{$oArticleItem->getId()}</td>
					<td><a href="{$oArticleItem->getWebUrl()}">{$oArticleItem->getTitle()}</a></td>
					<td>{date_format date=$oArticleItem->getDateCreate() format="j F Y"}</td>
					<td class="ta-r">
						<a href="{$oAdminUrl->get('update')}{$oArticleItem->getId()}/" class="fa fa-edit" title="Изменить"></a>
						<a href="#" class="fa fa-trash-o" onclick="if (confirm('Действительно удалить?')) { ls.plugin.article.admin.removeArticle({$oArticleItem->getId()}); } return false;" title="Удалить"></a>
					</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
{else}
	{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts="Список статей пуст" sAlertStyle='empty'}
{/if}

{include file="{$aTemplatePathPlugin.admin}pagination.tpl" aPaging=$aPaging}