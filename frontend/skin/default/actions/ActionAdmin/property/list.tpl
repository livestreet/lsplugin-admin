{**
 * Список дополнительных полей
 *
 * @param array $aPropertyItems Список полей
 *
 * TODO: Вывод имени плагина
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_content_actionbar'}
	{component 'admin:button' text=$aLang.plugin.admin.add url={router page="admin/properties/{$sPropertyTargetType}/create"} mods='primary'}
{/block}

{block 'layout_page_title'}
	Список полей типа &laquo;{$aPropertyTargetParams.name}&raquo;
{/block}

{block 'layout_content'}
	{component 'admin:p-property' template='list' properties=$aPropertyItems}
{/block}