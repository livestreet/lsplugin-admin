{**
 * Добавление категории
 *
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_options' append}
	{$layoutBackUrl = {router page="admin/categories/{$oCategoryType->getTargetType()}"}}
{/block}

{block 'layout_page_title'}
	{if $_aRequest}
		Редактирование категории типа &laquo;{$oCategoryType->getTitle()|escape}&raquo;
	{else}
		Добавление категории для типа &laquo;{$oCategoryType->getTitle()|escape}&raquo;
	{/if}
{/block}

{block 'layout_content'}
	{component 'admin:p-category' template='form' categories=$aCategoryItems}
{/block}