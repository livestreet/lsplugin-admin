{component_define_params params=[ 'user', 'text', 'classes' ]}

{$items=[
    [ 'text' => $aLang.plugin.admin.users.profile.top_bar.msg, 'url' => "{router page='talk/add'}?talk_recepient_id={$user->getId()}" ]
]}

{* Разрешить операции с правами админа для всех пользователей, кроме спец. списка из конфига *}
{if !in_array($user->getId(), Config::Get('plugin.admin.users.block_managing_admin_rights_user_ids'))}
    {if $user->isAdministrator()}
        {$items[] = [ 'text' => $aLang.plugin.admin.users.profile.top_bar.admin_delete, 'url' => "{router page="admin/users/manageadmins/delete/{$user->getId()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}", 'classes' => 'js-question' ]}
    {else}
        {$items[] = [ 'text' => $aLang.plugin.admin.users.profile.top_bar.admin_add, 'url' => "{router page="admin/users/manageadmins/add/{$user->getId()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}", 'classes' => 'js-question' ]}
    {/if}
{/if}

{* Разрешить операции удаления/бана для всех пользователей, кроме спец. списка из конфига *}
{if !in_array($user->getId(), Config::Get('plugin.admin.users.block_deleting_user_ids'))}
    {$items[] = [ 'text' => $aLang.plugin.admin.users.profile.top_bar.user_delete, 'url' => "{router page='admin/users/deleteuser'}?user_id={$user->getId()}" ]}
    {$items[] = [ 'text' => $aLang.plugin.admin.users.profile.top_bar.ban, 'url' => "{router page='admin/users/bans/add'}?user_id={$user->getId()}" ]}
{/if}

{if !$user->getActivate()}
    {$items[] = [ 'text' => $aLang.plugin.admin.users.profile.top_bar.activate, 'url' => "{router page='admin/users/activate'}?user_id={$user->getId()}&security_ls_key={$LIVESTREET_SECURITY_KEY}" ]}
{/if}

{component 'admin:dropdown' text=$text classes="{$classes} js-dropdown" menu=$items}