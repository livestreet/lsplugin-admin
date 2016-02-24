{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_options' append}
	{$layoutBackUrl = {router page="admin/users/rbac"}}
{/block}

{block 'layout_content_actionbar'}
	{include './menu.tpl'}
{/block}

{block 'layout_page_title'}
	Список пользователей с ролью &laquo;{$oRole->getTitle()}&raquo;
{/block}

{block 'layout_content'}
	{component 'admin:p-rbac' template='role-users' users=$aUserItems pagination=$aPaging role=$oRole}
{/block}