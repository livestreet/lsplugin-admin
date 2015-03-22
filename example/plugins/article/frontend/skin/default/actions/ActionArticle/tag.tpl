{**
 * Поиск по статьям
 *}

{extends file='layouts/layout.base.tpl'}

{block name='layout_content'}
	{include file=$aTemplatePathPlugin.article|cat:'form.search.tags.tpl'}
	<br/><br/>

	{if $aArticleItems}
		{include file=$aTemplatePathPlugin.article|cat:'article.list.tpl' aArticleItems=$aArticleItems}

		{component 'pagination' total=+$aPaging.iCountPage current=+$aPaging.iCurrentPage url="{$aPaging.sBaseUrl}/page__page__/{$aPaging.sGetParams}"}
	{else}
		{component 'alert' text='Ничего не удалось найти'}
	{/if}
{/block}