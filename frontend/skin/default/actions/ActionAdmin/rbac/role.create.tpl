{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_options' append}
	{$layoutBackUrl = {router page="admin/users/rbac"}}
{/block}

{block 'layout_page_title'}
	{if $oRole}
		Редактирование роли
	{else}
		Создание новой роли
	{/if}
{/block}

{block 'layout_content'}
	{component 'admin:p-rbac' template='role-form' role=$oRole roles=$aRoleItems}
{/block}