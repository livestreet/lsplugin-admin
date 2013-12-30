{extends file='layouts/layout.base.tpl'}

{block name='layout_content'}

{include file='forms/form.search.tags.tpl'}
<br/><br/>

{if $aArticleItems}

	{include file=$aTemplatePathPlugin.article|cat:'article.list.tpl' aArticleItems=$aArticleItems}
	{include file='paging.tpl' aPaging=$aPaging}

{else}
	Ничего не удалось найти
{/if}

{/block}