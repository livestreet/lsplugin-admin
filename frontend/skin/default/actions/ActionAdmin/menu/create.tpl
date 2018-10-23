{**
 * Добавление категории
 *
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_options' append}
	{$layoutBackUrl = {router page="admin/menu/{$oMenu->getName()}"}}
{/block}

{block 'layout_page_title'}
	{if $_aRequest}
		Редактирование пункта для меню &laquo;{$oMenu->getTitle()|escape}&raquo;
	{else}
		Добавление пункта для меню &laquo;{$oMenu->getTitle()|escape}&raquo;
	{/if}
{/block}

{block 'layout_content'}
	{component 'admin:p-menus' template='form' menuItems=$aItems}
{/block}