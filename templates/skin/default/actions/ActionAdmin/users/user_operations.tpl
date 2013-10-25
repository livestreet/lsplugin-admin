
<li><a href="{router page='talk/add'}?talk_users={$oUser->getLogin()}">{$aLang.plugin.admin.users.profile.top_bar.msg}</a></li>

{*
	разрешить операции для всех пользователей, кроме самого первого в системе с id = 1
*}
{if $oUser->getId()!=1}
	{if $oUser->isAdministrator()}
		<li><a class="question" href="{router page="admin/users/manageadmins/delete/{$oUser->getId()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
					>{$aLang.plugin.admin.users.profile.top_bar.admin_delete}</a></li>
	{else}
		<li><a class="question" href="{router page="admin/users/manageadmins/add/{$oUser->getId()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
					>{$aLang.plugin.admin.users.profile.top_bar.admin_add}</a></li>
	{/if}
	<li><a class="question" href="{router page="admin/users/deletecontent/{$oUser->getId()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
				>{$aLang.plugin.admin.users.profile.top_bar.content_delete}</a></li>
	<li><a class="question" href="{router page="admin/users/deleteuser/{$oUser->getId()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
				>{$aLang.plugin.admin.users.profile.top_bar.user_delete}</a></li>
	<li><a href="{router page='admin/users/bans/add'}?user_id={$oUser->getId()}">{$aLang.plugin.admin.users.profile.top_bar.ban}...</a></li>
{/if}
