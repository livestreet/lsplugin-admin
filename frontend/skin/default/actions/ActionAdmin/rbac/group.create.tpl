{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_options' append}
    {$layoutBackUrl = {router page="admin/users/rbac/group"}}
{/block}

{block 'layout_page_title'}
	{if $oGroup}
		Редактирование группы
	{else}
		Создание новой группы
	{/if}
{/block}

{block 'layout_content'}
	{component 'admin:p-rbac' template='group-form' group=$oGroup}
{/block}