{**
 * Удаление пользователя
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_options' append}
    {$layoutBackUrl = "{router page='admin/users/profile'}{$oUser->getId()}"}
{/block}

{block 'layout_page_title'}
	{$aLang.plugin.admin.users.deleteuser.title} #{$oUser->getId()} (<span>{$oUser->getLogin()|escape:'html'}</span>, {$oUser->getMail()|escape})
{/block}

{block 'layout_content'}
	{component 'admin:p-user' template='delete' user=$oUser}
{/block}