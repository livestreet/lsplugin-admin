
<li><a href="{router page='talk/add'}?talk_users={$oUser->getLogin()}">{$aLang.plugin.admin.users.profile.top_bar.msg}</a></li>

{*
	разрешить операции с правами админа для всех пользователей, кроме спец. списка из конфига
*}
{if !in_array($oUser->getId(), $oConfig->Get('plugin.admin.block_managing_admin_rights_user_ids'))}
	{if $oUser->isAdministrator()}
		<li><a class="js-question" href="{router page="admin/users/manageadmins/delete/{$oUser->getId()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
					>{$aLang.plugin.admin.users.profile.top_bar.admin_delete}</a></li>
	{else}
		<li><a class="js-question" href="{router page="admin/users/manageadmins/add/{$oUser->getId()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
					>{$aLang.plugin.admin.users.profile.top_bar.admin_add}</a></li>
	{/if}
{/if}
{*
	разрешить операции удаления/бана для всех пользователей, кроме спец. списка из конфига
*}
{if !in_array($oUser->getId(), $oConfig->Get('plugin.admin.block_deleting_user_ids'))}
	<li><a href="{router page='admin/users/deleteuser'}?user_id={$oUser->getId()}">{$aLang.plugin.admin.users.profile.top_bar.user_delete}...</a></li>
	<li><a href="{router page='admin/users/bans/add'}?user_id={$oUser->getId()}">{$aLang.plugin.admin.users.profile.top_bar.ban}...</a></li>
{/if}
