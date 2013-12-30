{**
 * Поиск по статьям
 *}

{extends file='layouts/layout.base.tpl'}

{block name='layout_content'}
	{include file='forms/form.search.tags.tpl'}
	<br/><br/>

	{if $aArticleItems}
		{include file=$aTemplatePathPlugin.article|cat:'article.list.tpl' aArticleItems=$aArticleItems}
		{include file='paging.tpl' aPaging=$aPaging}
	{else}
		{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts="Ничего не удалось найти" sAlertStyle='empty'}
	{/if}
{/block}