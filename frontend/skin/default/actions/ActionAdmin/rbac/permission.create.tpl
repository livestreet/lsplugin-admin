{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_options' append}
	{$layoutBackUrl = {router page="admin/users/rbac/permission"}}
{/block}

{block 'layout_page_title'}
	{if $oPermission}
		Редактирование разрешения
	{else}
		Создание нового разрешения
	{/if}
{/block}

{block 'layout_content'}
	{component 'admin:p-rbac' template='permission-form' permission=$oPermission groups=$aGroupItems}
{/block}