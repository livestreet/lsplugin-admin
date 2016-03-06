{$component = 'p-user-profile-header'}
{component_define_params params=[ 'user' ]}

<div class="{$component} {cmods name=$component mods=$mods} {$classes}" {cattr list=$attributes}>
    <div class="user-brief-body">
        <a href="{$oUser->getUserWebPath()}" class="user-avatar {if $oUser->isOnline()}user-is-online{/if}">
            <img src="{$oUser->getProfileAvatarPath(100)}" alt="avatar" title="{if $oUser->isOnline()}{$aLang.user_status_online}{else}{$aLang.user_status_offline}{/if}" />
        </a>

        <h3 class="user-login">
            {$oUser->getLogin()}

            {if $oUser->isAdministrator()}
                <i class="icon-user-admin" title="{$aLang.plugin.admin.users.admin}"></i>
            {/if}
        </h3>

        <p class="user-name">
            {if $oUser->getProfileName()}{$oUser->getProfileName()}{else}{$aLang.plugin.admin.users.profile_edit.no_profile_name}{/if}
        </p>

        <p class="user-mail">
            <a href="mailto:{$oUser->getMail()}" target="_blank" class="link-border"><span>{$oUser->getMail()}</span></a>
        </p>

        <p class="user-id">{$aLang.plugin.admin.users.profile.user_no}{$oUser->getId()}</p>
    </div>

    {include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/user_actions.tpl" text="Действия"}
</div>