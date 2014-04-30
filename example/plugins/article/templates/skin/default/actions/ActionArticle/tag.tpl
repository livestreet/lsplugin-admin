{**
 * Поиск по статьям
 *}

{extends file='layouts/layout.base.tpl'}

{block name='layout_content'}
	{include file=$aTemplatePathPlugin.article|cat:'form.search.tags.tpl'}
	<br/><br/>

	{if $aArticleItems}
		{include file=$aTemplatePathPlugin.article|cat:'article.list.tpl' aArticleItems=$aArticleItems}
		{include 'components/pagination/pagination.tpl' aPaging=$aPaging}
	{else}
		{include 'components/alert/alert.tpl' mAlerts='Ничего не удалось найти' aMods='empty'}
	{/if}
{/block}