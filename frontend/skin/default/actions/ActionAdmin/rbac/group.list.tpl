{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_content_actionbar'}
	{component 'admin:button' text=$aLang.plugin.admin.add url={router page="admin/users/rbac/group-create"} mods='primary'}

	{include './menu.tpl'}
{/block}

{block 'layout_page_title'}
	Список групп
{/block}

{block 'layout_content'}
    {component 'admin:alert' text='Группы необходимы исключительно для логического/визуального разделения разрешений. Никакой функциональности группы в себе не несут.' mods='info'}
	{component 'admin:p-rbac' template='group-list' groups=$aGroupItems}
{/block}