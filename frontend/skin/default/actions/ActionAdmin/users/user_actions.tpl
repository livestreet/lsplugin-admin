{$items=[
    [ 'text' => $aLang.plugin.admin.users.profile.top_bar.msg, 'url' => "{router page='talk/add'}?talk_users={$oUser->getLogin()}" ]
]}

{* Разрешить операции с правами админа для всех пользователей, кроме спец. списка из конфига *}
{if !in_array($oUser->getId(), Config::Get('plugin.admin.users.block_managing_admin_rights_user_ids'))}
    {if $oUser->isAdministrator()}
        {$items[] = [ 'text' => $aLang.plugin.admin.users.profile.top_bar.admin_delete, 'url' => "{router page="admin/users/manageadmins/delete/{$oUser->getId()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}", 'classes' => 'js-question' ]}
    {else}
        {$items[] = [ 'text' => $aLang.plugin.admin.users.profile.top_bar.admin_add, 'url' => "{router page="admin/users/manageadmins/add/{$oUser->getId()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}", 'classes' => 'js-question' ]}
    {/if}
{/if}

{* Разрешить операции удаления/бана для всех пользователей, кроме спец. списка из конфига *}
{if !in_array($oUser->getId(), Config::Get('plugin.admin.users.block_deleting_user_ids'))}
    {$items[] = [ 'text' => $aLang.plugin.admin.users.profile.top_bar.user_delete, 'url' => "{router page='admin/users/deleteuser'}?user_id={$oUser->getId()}" ]}
    {$items[] = [ 'text' => $aLang.plugin.admin.users.profile.top_bar.ban, 'url' => "{router page='admin/users/bans/add'}?user_id={$oUser->getId()}" ]}
{/if}

{if !$oUser->getActivate()}
    {$items[] = [ 'text' => $aLang.plugin.admin.users.profile.top_bar.activate, 'url' => "{router page='admin/users/activate'}?user_id={$oUser->getId()}&security_ls_key={$LIVESTREET_SECURITY_KEY}" ]}
{/if}


{component 'dropdown'
    text = $smarty.local.text
    classes = "{$smarty.local.classes} js-dropdown"
    menu = $items}