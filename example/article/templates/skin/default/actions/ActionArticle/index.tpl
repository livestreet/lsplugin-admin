{**
 * Список статей
 *
 * @param array $aArticleItems Список статей
 *}

{extends file='layouts/layout.base.tpl'}

{block name='layout_options'}
	{$bNoSidebar = true}
{/block}

{block name='layout_content'}
	{include file="{$aTemplatePathPlugin.article}article.list.tpl" aArticleItems=$aArticleItems}
	{include file='pagination.tpl' aPaging=$aPaging}
{/block}