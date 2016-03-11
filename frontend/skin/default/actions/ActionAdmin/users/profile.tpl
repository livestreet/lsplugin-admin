{**
 * Страница пользователя
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_content_before'}
	{component 'admin:p-user.profile-header' user=$oUser}
{/block}

{block 'layout_content'}
	{component 'admin:p-user.profile' user=$oUser}
{/block}