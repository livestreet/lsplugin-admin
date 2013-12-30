{if $oArticle}
	<h3>Обновление статьи</h3>
{else}
	<h3>Добавление новой статьи</h3>
{/if}

<form id="form-article-create" action="" method="post" onsubmit="{if $oArticle}ls.plugin.article.admin.updateArticle('form-article-create');{else}ls.plugin.article.admin.createArticle('form-article-create');{/if} return false;">
	{if $oArticle}
		{$sFieldValue={$oArticle->getTitle()}}
	{/if}
	{include file=$aTemplatePathPlugin.admin|cat:'forms/fields/form.field.text.tpl'
		sFieldName			= 'article[title]'
		sFieldValue			= $sFieldValue
		sFieldLabel			= 'Заголовок'}

	{* Подключаем блок для управления дополнительными свойствами *}
	{$aBlockParams=[]}
	{$aBlockParams.plugin='admin'}
	{$aBlockParams.target_type='article'}
	{if $oArticle}
		{$aBlockParams.target_id=$oArticle->getId()}
	{/if}
	{insert name="block" block="propertyUpdate" params=$aBlockParams}


	{if $oArticle}
		<input type="hidden" name="article[id]" value="{$oArticle->getId()}">
        <input type="submit" name="article[submit]" value="Сохранить">
	{else}
		<input type="submit" name="article[submit]" value="Добавить">
	{/if}
</form>
