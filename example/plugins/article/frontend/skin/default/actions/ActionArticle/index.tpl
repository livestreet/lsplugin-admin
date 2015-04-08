{**
 * Список статей
 *
 * @param array $aArticleItems Список статей
 *}

{extends file='layouts/layout.base.tpl'}

{block name='layout_options'}
	{$layoutNoSidebar = true}
{/block}

{block name='layout_content'}
	{include file="{$aTemplatePathPlugin.article}article.list.tpl" aArticleItems=$aArticleItems}

	{component 'pagination' total=+$aPaging.iCountPage current=+$aPaging.iCurrentPage url="{$aPaging.sBaseUrl}/page__page__/{$aPaging.sGetParams}"}
{/block}