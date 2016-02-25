{**
 * Типы контактов пользователей
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_content_actionbar'}
    {component 'admin:button' text=$aLang.plugin.admin.add url={router page="admin/users/contact-fields/create"} mods='primary'}
{/block}

{block 'layout_page_title'}
	{$aLang.plugin.admin.users.contact_fields.title}
{/block}

{block 'layout_content'}
    {component 'admin:p-user' template='contact-list' fields=$aUserFields}
{/block}