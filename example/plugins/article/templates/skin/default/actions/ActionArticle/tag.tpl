{**
 * Поиск по статьям
 *}

{extends file='layouts/layout.base.tpl'}

{block name='layout_content'}
	{include file=$aTemplatePathPlugin.article|cat:'form.search.tags.tpl'}
	<br/><br/>

	{if $aArticleItems}
		{include file=$aTemplatePathPlugin.article|cat:'article.list.tpl' aArticleItems=$aArticleItems}
		{include file='pagination.tpl' aPaging=$aPaging}
	{else}
		{include file='alert.tpl' mAlerts="Ничего не удалось найти" sAlertStyle='empty'}
	{/if}
{/block}