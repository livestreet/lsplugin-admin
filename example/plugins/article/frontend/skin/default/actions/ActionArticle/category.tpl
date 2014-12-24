{extends file='layouts/layout.base.tpl'}

{block name='layout_content'}

	<h3>Статьи из категории: {$oCategoryCurrent->getTitle()}</h3>

	{if $aArticleItems}
		{include file="{$aTemplatePathPlugin.article}article.list.tpl" aArticleItems=$aArticleItems}
		{include 'components/pagination/pagination.tpl' aPaging=$aPaging}
	{else}
		{include 'components/alert/alert.tpl' mAlerts='В данной категории нет статей' aMods='empty'}
	{/if}
{/block}