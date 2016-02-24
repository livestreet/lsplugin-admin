{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_options' append}
    {$layoutBackUrl = {router page="admin/users/rbac/role"}}
{/block}

{block 'layout_page_title'}
	Список разрешений для роли &laquo;{$oRole->getTitle()}&raquo;
{/block}

{block 'layout_content'}
	{component 'admin:p-rbac' template='role-permissions' permissions=$aPermissionItems permissionGroups=$aPermissionGroupItems groups=$aGroupItems role=$oRole}
{/block}