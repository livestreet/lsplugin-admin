{**
 * Меню
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_content_actionbar'}
	{component 'admin:button' text=$aLang.plugin.admin.add url={router page="admin/menu/{$oMenu->getName()}/create"} mods='primary'}
{/block}

{block 'layout_page_title'}
	Меню &laquo;{$oMenu->getTitle()|escape}&raquo;
{/block}

{block 'layout_content'}
	{component 'admin:p-menus' template='list' items=$aItems}
{/block}