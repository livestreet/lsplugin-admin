{$component = 'p-user-profile'}
{component_define_params params=[ 'user' ]}

<div class="{$component}">
    {$oSession = $user->getSession()}

    <div class="{$component}-body">
        {* Для вывода информации бана *}
        {hook run='admin_user_profile_center_info' oUserProfile=$user}

        {* Форма редактирования информации *}
        {component 'admin:p-user.profile-section'
            title=$aLang.plugin.admin.users.profile.info.resume
            content={component 'admin:p-user.form' user=$user}}

        {* Авторизация *}
        {capture 'profile_section'}
            {$list = [
                [ label => $aLang.plugin.admin.users.profile.info.reg_date, content => {date_format date=$user->getDateRegister()} ],
                [
                    label => $aLang.plugin.admin.users.profile.info.ip,
                    content => "<a href=\"{router page='admin/users/list'}{request_filter name=array('ip_register') value=array($user->getIpRegister())}\" title=\"{$aLang.plugin.admin.users.profile.info.search_this_ip}\">{$user->getIpRegister()}</a>"
                ]
            ]}

            {if $oSession}
                {$list[] = [ label => $aLang.plugin.admin.users.profile.info.last_visit, content => {date_format date=$oSession->getDateLast()} ]}
                {$list[] = [
                    label => $aLang.plugin.admin.users.profile.info.ip,
                    content => "<a href=\"{router page='admin/users/list'}{request_filter name=array('session_ip_last') value=array($oSession->getIpLast())}\" title=\"{$aLang.plugin.admin.users.profile.info.search_this_ip}\">{$oSession->getIpLast()}</a>"
                ]}
            {/if}

            {component 'admin:info-list' list=$list}
        {/capture}

        {component 'admin:p-user.profile-section'
            title='Авторизация'
            content=$smarty.capture.profile_section}

        {* Статистика *}
        {capture 'profile_section'}
            <div class="p-user-table-stats">
                <div class="p-user-table-stats-row">
                    <div class="p-user-table-stats-header">{$aLang.plugin.admin.users.profile.info.created}</div>
                    <ul>
                        <li><a href="{$user->getUserWebPath()}created/topics/" class="link-border"><span>{$iCountTopicUser} {$aLang.plugin.admin.users.profile.info.topics}</span></a></li>
                        <li><a href="{$user->getUserWebPath()}created/comments/" class="link-border"><span>{$iCountCommentUser} {$aLang.plugin.admin.users.profile.info.comments}</span></a></li>
                        <li><span>{$iCountBlogsUser} {$aLang.plugin.admin.users.profile.info.blogs}</span></li>
                    </ul>
                </div>

                <div class="p-user-table-stats-row">
                    <div class="p-user-table-stats-header">{$aLang.plugin.admin.users.profile.info.fav}</div>
                    <ul>
                        <li><a href="{$user->getUserWebPath()}favourites/topics/" class="link-border"><span>{$iCountTopicFavourite} {$aLang.plugin.admin.users.profile.info.topics}</span></a></li>
                        <li><a href="{$user->getUserWebPath()}favourites/comments/" class="link-border"><span>{$iCountCommentFavourite} {$aLang.plugin.admin.users.profile.info.comments}</span></a></li>
                    </ul>
                </div>

                <div class="p-user-table-stats-row">
                    <div class="p-user-table-stats-header">{$aLang.plugin.admin.users.profile.info.reads}</div>
                    <ul>
                        <li><span>{$iCountBlogReads} {$aLang.plugin.admin.users.profile.info.blogs}</span></li>
                    </ul>
                </div>

                <div class="p-user-table-stats-row">
                    <div class="p-user-table-stats-header">{$aLang.plugin.admin.users.profile.info.has}</div>
                    <ul>
                        <li><a href="{$user->getUserWebPath()}friends/" class="link-border"><span>{$iCountFriendsUser} {$aLang.plugin.admin.users.profile.info.friends}</span></a></li>
                    </ul>
                </div>
            </div>
        {/capture}

        {component 'admin:p-user.profile-section'
            title=$aLang.plugin.admin.users.profile.info.stats_title
            content=$smarty.capture.profile_section}

        {* Как голосовал пользователь *}
        {$votings_direction = [
            plus    => '<i class="p-icon-stats-up"></i>',
            minus   => '<i class="p-icon-stats-down"></i>',
            abstain => '&mdash;'
        ]}

        {capture 'profile_section'}
            <div class="p-user-table-stats">
            {foreach ['topic', 'comment', 'blog', 'user'] as $sType}
                <div class="p-user-table-stats-row">
                    <div class="p-user-table-stats-header">
                        <a href="{router page="admin/users/votes/{$user->getId()}"}?filter[type]={$sType}">{$aLang.plugin.admin.users.profile.info.votings[$sType]}</a>
                    </div>
                    <ul>
                        {foreach ['plus', 'minus', 'abstain'] as $sVoteDir}
                            {if $aUserVotedStat[$sType][$sVoteDir]}
                                <li title="{$sVoteDir}">
                                    <a href="{router page="admin/users/votes/{$user->getId()}"}?filter[type]={$sType}&filter[dir]={$sVoteDir}">{$aUserVotedStat[$sType][$sVoteDir]}</a>
                                    {$votings_direction[$sVoteDir]}
                                </li>
                            {/if}
                        {/foreach}
                    </ul>
                </div>
            {/foreach}
            </div>
        {/capture}

        {component 'admin:p-user.profile-section'
            title=$aLang.plugin.admin.users.profile.info.votings_title
            content=$smarty.capture.profile_section}

        {* Контакты *}
        {$aUserFieldContactValues = $user->getUserFieldValues(true,array('contact'))}
        {$aUserFieldSocialValues = $user->getUserFieldValues(true,array('social'))}

        {if $aUserFieldContactValues || $aUserFieldSocialValues}
            {capture 'profile_section'}
                <div class="p-user-contacts ls-clearfix">
                    {if $aUserFieldContactValues}
                        <ul class="p-user-contact-list">
                            {foreach $aUserFieldContactValues as $oField}
                                <li>
                                    <i class="fa p-icon--contact p-icon--contact-{$oField->getName()}" title="{$oField->getName()}"></i>
                                    {$oField->getValue(true,true)}
                                </li>
                            {/foreach}
                        </ul>
                    {/if}

                    {if $aUserFieldSocialValues}
                        <ul class="p-user-contact-list">
                            {foreach $aUserFieldSocialValues as $oField}
                                <li>
                                    <i class="fa p-icon--contact p-icon--contact-{$oField->getName()}" title="{$oField->getName()}"></i>
                                    {$oField->getValue(true,true)}
                                </li>
                            {/foreach}
                        </ul>
                    {/if}
                </div>
            {/capture}

            {component 'admin:p-user.profile-section' title='Контакты' content=$smarty.capture.profile_section}
        {/if}
    </div>

    <aside class="{$component}-aside">
        <div class="{$component}-aside-block">
            <a href="{$user->getUserWebPath()}"><img src="{$user->getProfileFotoPath()}" alt="photo" class="photo" /></a>
        </div>

        {if $oUserCurrent->getId() != $user->getId()}
            <div class="{$component}-aside-block">
                {component 'note' targetId=$user->getId() note=$user->getUserNote() classes='js-user-profile-note'}
            </div>
        {/if}

        <div class="{$component}-aside-block">
            <ul class="p-user-menu">
                <li class="p-user-menu-item"><a href="{$user->getUserWebPath()}"><span>{$aLang.plugin.admin.users.profile.middle_bar.profile}</span></a></li>
                <li class="p-user-menu-item"><a href="{$user->getUserWebPath()}created/"><span>{$aLang.plugin.admin.users.profile.middle_bar.publications}</span></a></li>
                <li class="p-user-menu-item"><a href="{$user->getUserWebPath()}stream/"><span>{$aLang.plugin.admin.users.profile.middle_bar.activity}</span></a></li>
                <li class="p-user-menu-item"><a href="{$user->getUserWebPath()}friends/"><span>{$aLang.plugin.admin.users.profile.middle_bar.friends}</span></a></li>
                <li class="p-user-menu-item"><a href="{$user->getUserWebPath()}wall/"><span>{$aLang.plugin.admin.users.profile.middle_bar.wall}</span></a></li>
                <li class="p-user-menu-item"><a href="{$user->getUserWebPath()}favourites/"><span>{$aLang.plugin.admin.users.profile.middle_bar.fav}</span></a></li>
            </ul>
        </div>
    </aside>
</div>