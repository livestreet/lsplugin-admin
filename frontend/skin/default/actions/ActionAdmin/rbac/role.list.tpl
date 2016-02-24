{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_content_actionbar'}
	{component 'admin:button' text=$aLang.plugin.admin.add url={router page="admin/users/rbac/role-create"} mods='primary'}

	{include './menu.tpl'}
{/block}

{block 'layout_page_title'}
	Список ролей
{/block}

{block 'layout_content'}
	{component 'admin:p-rbac' template='role-list' roles=$aRoleItems}
{/block}