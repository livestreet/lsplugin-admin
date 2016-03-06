{$component = 'p-user-profile'}
{component_define_params params=[ 'title', 'content' ]}

<div class="{$component}">
    {$oSession = $oUser->getSession()}

    <div class="{$component}-body">
        {* Для вывода информации бана *}
        {hook run='admin_user_profile_center_info' oUserProfile=$oUser}

        {* Форма редактирования информации *}
        {component 'admin:p-user.profile-section'
            title=$aLang.plugin.admin.users.profile.info.resume
            content={component 'admin:p-user.form' user=$oUser}}

        {* Авторизация *}
        {capture 'profile_section'}
            <dl class="dotted-list-item mt-20">
                <dt class="dotted-list-item-label">{$aLang.plugin.admin.users.profile.info.reg_date}</dt>
                <dd class="dotted-list-item-value">{date_format date=$oUser->getDateRegister()}</dd>
            </dl>

            <dl class="dotted-list-item">
                <dt class="dotted-list-item-label">{$aLang.plugin.admin.users.profile.info.ip}</dt>
                <dd class="dotted-list-item-value">
                    <a href="{router page='admin/users/list'}{request_filter
                        name=array('ip_register')
                        value=array($oUser->getIpRegister())
                    }" title="{$aLang.plugin.admin.users.profile.info.search_this_ip}">{$oUser->getIpRegister()}</a>
                </dd>
            </dl>

            {if $oSession}
                <dl class="dotted-list-item mt-20">
                    <dt class="dotted-list-item-label">{$aLang.plugin.admin.users.profile.info.last_visit}</dt>
                    <dd class="dotted-list-item-value">{date_format date=$oSession->getDateLast()}</dd>
                </dl>

                <dl class="dotted-list-item">
                    <dt class="dotted-list-item-label">{$aLang.plugin.admin.users.profile.info.ip}</dt>
                    <dd class="dotted-list-item-value">
                        <a href="{router page='admin/users/list'}{request_filter
                            name=array('session_ip_last')
                            value=array($oSession->getIpLast())
                        }" title="{$aLang.plugin.admin.users.profile.info.search_this_ip}">{$oSession->getIpLast()}</a>
                    </dd>
                </dl>
            {/if}
        {/capture}

        {component 'admin:p-user.profile-section'
            title='Авторизация'
            content=$smarty.capture.profile_section}

        {* Статистика *}
        {capture 'profile_section'}
            <div class="user-info-block-stats-row">
                <div class="user-info-block-stats-header">{$aLang.plugin.admin.users.profile.info.created}</div>
                <ul>
                    <li><a href="{$oUser->getUserWebPath()}created/topics/" class="link-border"><span>{$iCountTopicUser} {$aLang.plugin.admin.users.profile.info.topics}</span></a></li>
                    <li><a href="{$oUser->getUserWebPath()}created/comments/" class="link-border"><span>{$iCountCommentUser} {$aLang.plugin.admin.users.profile.info.comments}</span></a></li>
                    <li><span>{$iCountBlogsUser} {$aLang.plugin.admin.users.profile.info.blogs}</span></li>
                </ul>
            </div>

            <div class="user-info-block-stats-row">
                <div class="user-info-block-stats-header">{$aLang.plugin.admin.users.profile.info.fav}</div>
                <ul>
                    <li><a href="{$oUser->getUserWebPath()}favourites/topics/" class="link-border"><span>{$iCountTopicFavourite} {$aLang.plugin.admin.users.profile.info.topics}</span></a></li>
                    <li><a href="{$oUser->getUserWebPath()}favourites/comments/" class="link-border"><span>{$iCountCommentFavourite} {$aLang.plugin.admin.users.profile.info.comments}</span></a></li>
                </ul>
            </div>

            <div class="user-info-block-stats-row">
                <div class="user-info-block-stats-header">{$aLang.plugin.admin.users.profile.info.reads}</div>
                <ul>
                    <li><span>{$iCountBlogReads} {$aLang.plugin.admin.users.profile.info.blogs}</span></li>
                </ul>
            </div>

            <div class="user-info-block-stats-row">
                <div class="user-info-block-stats-header">{$aLang.plugin.admin.users.profile.info.has}</div>
                <ul>
                    <li><a href="{$oUser->getUserWebPath()}friends/" class="link-border"><span>{$iCountFriendsUser} {$aLang.plugin.admin.users.profile.info.friends}</span></a></li>
                </ul>
            </div>
        {/capture}

        {component 'admin:p-user.profile-section'
            title=$aLang.plugin.admin.users.profile.info.stats_title
            content=$smarty.capture.profile_section}

        {* Как голосовал пользователь *}
        {capture 'profile_section'}
            {foreach from=array('topic', 'comment', 'blog', 'user') item=sType}
                <div class="user-info-block-stats-row">
                    <div class="user-info-block-stats-header">
                        <a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]={$sType}">{$aLang.plugin.admin.users.profile.info.votings[$sType]}</a>
                    </div>
                    <ul>
                        {foreach from=array('plus', 'minus', 'abstain') item=sVoteDir}
                            {if $aUserVotedStat[$sType][$sVoteDir]}
                                <li title="{$sVoteDir}">
                                    <a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]={$sType}&filter[dir]={$sVoteDir}">{$aUserVotedStat[$sType][$sVoteDir]}</a>
                                    {$aLang.plugin.admin.users.profile.info.votings_direction[$sVoteDir]}
                                </li>
                            {/if}
                        {/foreach}
                    </ul>
                </div>
            {/foreach}
        {/capture}

        {component 'admin:p-user.profile-section'
            title=$aLang.plugin.admin.users.profile.info.votings_title
            content=$smarty.capture.profile_section}

        {* Контакты *}
        {$aUserFieldContactValues = $oUser->getUserFieldValues(true,array('contact'))}
        {$aUserFieldSocialValues = $oUser->getUserFieldValues(true,array('social'))}

        {if $aUserFieldContactValues || $aUserFieldSocialValues}
            {capture 'profile_section'}
                <div class="ls-clearfix">
                    {if $aUserFieldContactValues}
                        <ul class="user-contact-list">
                            {foreach $aUserFieldContactValues as $oField}
                                <li>
                                    <i class="icon-contact icon-contact-{$oField->getName()}" title="{$oField->getName()}"></i>
                                    {$oField->getValue(true,true)}
                                </li>
                            {/foreach}
                        </ul>
                    {/if}

                    {if $aUserFieldSocialValues}
                        <ul class="user-contact-list">
                            {foreach $aUserFieldSocialValues as $oField}
                                <li>
                                    <i class="icon-contact icon-contact-{$oField->getName()}" title="{$oField->getName()}"></i>
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
            <a href="{$oUser->getUserWebPath()}"><img src="{$oUser->getProfileFotoPath()}" alt="photo" class="photo" /></a>
        </div>

        {if $oUserCurrent->getId() != $oUser->getId()}
            <div class="{$component}-aside-block">
                {component 'note' targetId=$oUser->getId() note=$oUser->getUserNote() classes='js-user-profile-note'}
            </div>
        {/if}

        <div class="{$component}-aside-block">
            <ul class="user-menu">
                <li class="user-menu-item"><a href="{$oUser->getUserWebPath()}" class="link-border"><span>{$aLang.plugin.admin.users.profile.middle_bar.profile}</span></a></li>
                <li class="user-menu-item"><a href="{$oUser->getUserWebPath()}created/" class="link-border"><span>{$aLang.plugin.admin.users.profile.middle_bar.publications}</span></a></li>
                <li class="user-menu-item"><a href="{$oUser->getUserWebPath()}stream/" class="link-border"><span>{$aLang.plugin.admin.users.profile.middle_bar.activity}</span></a></li>
                <li class="user-menu-item"><a href="{$oUser->getUserWebPath()}friends/" class="link-border"><span>{$aLang.plugin.admin.users.profile.middle_bar.friends}</span></a></li>
                <li class="user-menu-item"><a href="{$oUser->getUserWebPath()}wall/" class="link-border"><span>{$aLang.plugin.admin.users.profile.middle_bar.wall}</span></a></li>
                <li class="user-menu-item"><a href="{$oUser->getUserWebPath()}favourites/" class="link-border"><span>{$aLang.plugin.admin.users.profile.middle_bar.fav}</span></a></li>
            </ul>
        </div>
    </aside>
</div>