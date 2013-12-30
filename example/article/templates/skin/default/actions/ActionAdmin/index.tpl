<a href="{$oAdminUrl->get('create')}">Добавить статью</a>

<br/>
<br/>
<h3>список статей</h3><br/>
<br/>


<table>
	<tr>
		<th>ID</th>
		<th>Название</th>
		<th>Дата</th>
		<th>Действие</th>
	</tr>


	{foreach $aArticleItems as $oArticleItem}
        <tr id="article-item-{$oArticleItem->getId()}">
            <td>{$oArticleItem->getId()}</td>
            <td>{$oArticleItem->getTitle()}</td>
            <td>{$oArticleItem->getDateCreate()}</td>
            <td>
				<a href="{$oAdminUrl->get('update')}{$oArticleItem->getId()}/">изменить</a>
				<a href="#" onclick="if (confirm('Действительно удалить?')) { ls.plugin.article.admin.removeArticle({$oArticleItem->getId()}); } return false;">удалить</a>
            </td>
        </tr>
	{/foreach}

</table>

{include file="{$aTemplatePathPlugin.admin}pagination.tpl" aPaging=$aPaging}
