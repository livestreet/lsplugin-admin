{**
 * Список пользователей
 *}

{$component = 'p-user-list'}
{component_define_params params=[ 'users', 'pagination' ]}

<table class="ls-table ls-table--condensed ls-table--striped ls-table--hover p-user-list">
    <thead>
        <tr>
            {component 'admin:table.sorting-cell'
                sCellClassName='user'
                mSortingOrder=array('u.user_id', 'u.user_login', 'u.user_profile_name', 'u.user_mail')
                mLinkHtml=array(
                    $aLang.plugin.admin.users.table_header.id,
                    $aLang.plugin.admin.users.table_header.login,
                    $aLang.plugin.admin.users.table_header.profile_name,
                    $aLang.plugin.admin.users.table_header.mail
                )
                sDropDownHtml=$aLang.plugin.admin.users.table_header.name
                sBaseUrl=$sFullPagePathToEvent}

            {component 'admin:table.sorting-cell'
                sCellClassName='birth'
                mSortingOrder='u.user_profile_birthday'
                mLinkHtml=$aLang.plugin.admin.users.table_header.birth
                sBaseUrl=$sFullPagePathToEvent}

            {component 'admin:table.sorting-cell'
                sCellClassName='signup'
                mSortingOrder=array('u.user_date_register', 's.session_date_last')
                mLinkHtml=array($aLang.plugin.admin.users.table_header.reg, $aLang.plugin.admin.users.table_header.last_visit)
                sDropDownHtml=$aLang.plugin.admin.users.table_header.reg_and_last_visit
                sBaseUrl=$sFullPagePathToEvent}

            {component 'admin:table.sorting-cell'
                sCellClassName='ip'
                mSortingOrder=array('u.user_ip_register', 's.session_ip_last')
                mLinkHtml=array($aLang.plugin.admin.users.table_header.user_ip_register, $aLang.plugin.admin.users.table_header.session_ip_last)
                sDropDownHtml=$aLang.plugin.admin.users.table_header.ip
                sBaseUrl=$sFullPagePathToEvent}

            {component 'admin:table.sorting-cell'
                sCellClassName='rating'
                mSortingOrder=array('u.user_rating')
                mLinkHtml=array($aLang.plugin.admin.users.table_header.user_rating)
                sDropDownHtml=$aLang.plugin.admin.users.table_header.rating_and_skill
                sBaseUrl=$sFullPagePathToEvent}

            <th></th>
        </tr>
    </thead>

    <tbody>
        {foreach $users as $user}
            {$session = $user->getSession()}

            <tr>
                {* Пользователь *}
                <td class="cell-user">
                    <div class="p-user-list-card">
                        <a href="{router page="admin/users/profile/{$user->getId()}"}" class="cell-user-avatar {if $user->isOnline()}user-is-online{/if}">
                            <img src="{$user->getProfileAvatarPath(48)}"
                                 alt="avatar"
                                 title="{if $user->isOnline()}{$aLang.user_status_online}{else}{$aLang.user_status_offline}{/if}" />
                        </a>

                        <div class="cell-user-login word-wrap">
                            <a href="{router page="admin/users/profile/{$user->getId()}"}" class="link-border"
                               title="{$aLang.plugin.admin.users.table_header.login}"><span>{$user->getLogin()}</span></a>

                            {if $user->isAdministrator()}
                                <i class="p-icon--user-admin" title="{$aLang.plugin.admin.users.admin}"></i>
                            {/if}

                            {if $oBan = $user->getBannedCached()}
                                <a href="{$oBan->getBanViewUrl()}"><i class="fa fa-lock" title="{$aLang.plugin.admin.users.banned}"></i></a>
                            {/if}
                        </div>

                        {if $user->getProfileName()}
                            <div class="cell-user-name" title="{$aLang.plugin.admin.users.table_header.profile_name}">{$user->getProfileName()}</div>
                        {/if}

                        <div class="cell-user-mail" title="{$aLang.plugin.admin.users.table_header.mail}">{$user->getMail()}</div>
                    </div>
                </td>

                {* Дата рождения *}
                <td class="cell-birth">
                    {if $user->getProfileBirthday()}
                        {date_format date=$user->getProfileBirthday() format="j.m.Y" notz=true}
                    {else}
                        &mdash;
                    {/if}
                </td>

                {* Дата регистрации и дата последнего входа *}
                <td class="cell-signup">
                    <div title="{$aLang.plugin.admin.users.table_header.reg}">
                        {date_format date=$user->getDateRegister() format="d.m.Y"},
                        <span>{date_format date=$user->getDateRegister() format="H:i"}</span>
                    </div>

                    {if $session}
                        <div title="{$aLang.plugin.admin.users.table_header.last_visit}">
                            {date_format date=$session->getDateLast() format="d.m.Y"},
                            <span>{date_format date=$session->getDateLast() format="H:i"}</span>
                        </div>
                    {/if}
                </td>

                {* IP *}
                <td class="cell-ip">
                    <div title="{$aLang.plugin.admin.users.table_header.user_ip_register}">
                        <a href="{router page='admin/users/list'}{request_filter
                            name=array('ip_register')
                            value=array($user->getIpRegister())
                        }">{$user->getIpRegister()}</a>
                    </div>

                    {if $session}
                        {* <div title="sess ip create">{$session->getIpCreate()}</div> *}
                        <div title="{$aLang.plugin.admin.users.table_header.session_ip_last}">
                            <a href="{router page='admin/users/list'}{request_filter
                                name=array('session_ip_last')
                                value=array($session->getIpLast())
                            }" title="{$aLang.plugin.admin.users.profile.info.search_this_ip}">{$session->getIpLast()}</a>
                        </div>
                    {/if}
                </td>

                {* Рейтинг и сила *}
                <td class="cell-rating">
                    <div class="p-user-list-rating {if $user->getRating() < 0}p-user-list-rating--negative{/if}" title="{$aLang.plugin.admin.users.table_header.user_rating}">
                        {$user->getRating()}
                    </div>
                </td>

                {* Actions *}
                <td class="ls-table-cell-actions">
                    {component 'admin:p-user.actions' user=$user}
                </td>
            </tr>
        {/foreach}
    </tbody>
</table>

{component 'admin:pagination.on-page' url={router page='admin/users/ajax-on-page'} value=Config::Get('plugin.admin.users.per_page')}
{component 'admin:pagination' total=+$pagination.iCountPage current=+$pagination.iCurrentPage url="{$pagination.sBaseUrl}/page__page__/{$pagination.sGetParams}"}