{extends file='layouts/layout.base.tpl'}

{block name='layout_content'}

	<h3>Статьи из категории: {$oCategoryCurrent->getTitle()}</h3>

	{if $aArticleItems}
		{include file="{$aTemplatePathPlugin.article}article.list.tpl" aArticleItems=$aArticleItems}

		{component 'pagination' total=+$aPaging.iCountPage current=+$aPaging.iCurrentPage url="{$aPaging.sBaseUrl}/page__page__/{$aPaging.sGetParams}"}
	{else}
		{component 'alert' text='В данной категории нет статей'}
	{/if}
{/block}