{$component = 'p-user-profile-header'}
{component_define_params params=[ 'user' ]}

<div class="{$component} {cmods name=$component mods=$mods} {$classes}" {cattr list=$attributes}>
    <div class="user-brief-body">
        <a href="{$user->getUserWebPath()}" class="user-avatar {if $user->isOnline()}user-is-online{/if}">
            <img src="{$user->getProfileAvatarPath(100)}" alt="avatar" title="{if $user->isOnline()}{$aLang.user_status_online}{else}{$aLang.user_status_offline}{/if}" />
        </a>

        <h3 class="user-login">
            {$user->getLogin()}

            {if $user->isAdministrator()}
                <i class="p-icon--user-admin" title="{$aLang.plugin.admin.users.admin}"></i>
            {/if}
        </h3>

        {if $user->getProfileName()}
            <p class="user-name">
                {$user->getProfileName()}
            </p>
        {/if}

        <p class="user-mail">
            <a href="mailto:{$user->getMail()}" target="_blank" class="link-border"><span>{$user->getMail()}</span></a>
        </p>

        <p class="user-id">{$aLang.plugin.admin.users.profile.user_no}{$user->getId()}</p>
    </div>

    {component 'admin:p-user.actions' user=$user text='Действия'}
</div>