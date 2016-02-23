{**
 * Список категорий
 *
 * @param array $aCategoryItems Список категорий
 *
 * TODO: Вывод имени плагина
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_content_actionbar'}
	{component 'admin:button' text=$aLang.plugin.admin.add url={router page="admin/categories/{$oCategoryType->getTargetType()}/create"} mods='primary'}
{/block}

{block 'layout_page_title'}
	Категории типа &laquo;{$oCategoryType->getTitle()|escape}&raquo;
{/block}

{block 'layout_content'}
	{component 'admin:p-category' template='list' categories=$aCategoryItems}
{/block}