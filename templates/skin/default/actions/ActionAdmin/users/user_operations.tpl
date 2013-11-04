
<li><a href="{router page='talk/add'}?talk_users={$oUser->getLogin()}">{$aLang.plugin.admin.users.profile.top_bar.msg}</a></li>

{*
	разрешить операции для всех пользователей, кроме спец. списка в конфиге
*}
{if !in_array($oUser->getId(), $oConfig->GetValue('plugin.admin.block_deleting_user_id'))}
	{if $oUser->isAdministrator()}
		<li><a class="question" href="{router page="admin/users/manageadmins/delete/{$oUser->getId()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
					>{$aLang.plugin.admin.users.profile.top_bar.admin_delete}</a></li>
	{else}
		<li><a class="question" href="{router page="admin/users/manageadmins/add/{$oUser->getId()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
					>{$aLang.plugin.admin.users.profile.top_bar.admin_add}</a></li>
	{/if}
	<li><a href="{router page='admin/users/deleteuser'}?user_id={$oUser->getId()}">{$aLang.plugin.admin.users.profile.top_bar.user_delete}...</a></li>
	<li><a href="{router page='admin/users/bans/add'}?user_id={$oUser->getId()}">{$aLang.plugin.admin.users.profile.top_bar.ban}...</a></li>
{/if}
