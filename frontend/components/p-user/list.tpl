{**
 * Список пользователей
 *}

{$component = 'p-user-list'}
{component_define_params params=[ 'users', 'pagination' ]}

<table class="table table-users">
    <thead>
        <tr>
            <th class="cell-check">
                <input type="checkbox" class="js-check-all" data-checkboxes-class="js-user-list-item" />
            </th>

            {include file="{$aTemplatePathPlugin.admin}forms/sorting_cell.tpl"
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

            {include file="{$aTemplatePathPlugin.admin}forms/sorting_cell.tpl"
                sCellClassName='birth'
                mSortingOrder='u.user_profile_birthday'
                mLinkHtml=$aLang.plugin.admin.users.table_header.birth
                sBaseUrl=$sFullPagePathToEvent}

            {include file="{$aTemplatePathPlugin.admin}forms/sorting_cell.tpl"
                sCellClassName='signup'
                mSortingOrder=array('u.user_date_register', 's.session_date_last')
                mLinkHtml=array($aLang.plugin.admin.users.table_header.reg, $aLang.plugin.admin.users.table_header.last_visit)
                sDropDownHtml=$aLang.plugin.admin.users.table_header.reg_and_last_visit
                sBaseUrl=$sFullPagePathToEvent}

            {include file="{$aTemplatePathPlugin.admin}forms/sorting_cell.tpl"
                sCellClassName='ip'
                mSortingOrder=array('u.user_ip_register', 's.session_ip_last')
                mLinkHtml=array($aLang.plugin.admin.users.table_header.user_ip_register, $aLang.plugin.admin.users.table_header.session_ip_last)
                sDropDownHtml=$aLang.plugin.admin.users.table_header.ip
                sBaseUrl=$sFullPagePathToEvent}

            {include file="{$aTemplatePathPlugin.admin}forms/sorting_cell.tpl"
                sCellClassName='rating'
                mSortingOrder=array('u.user_rating')
                mLinkHtml=array($aLang.plugin.admin.users.table_header.user_rating)
                sDropDownHtml=$aLang.plugin.admin.users.table_header.rating_and_skill
                sBaseUrl=$sFullPagePathToEvent}

        </tr>
    </thead>

    <tbody>
        {foreach $users as $user}
            {$session = $user->getSession()}

            <tr>
                <td class="cell-check">
                    <input type="checkbox" name="checked[]" class="js-user-list-item" value="1" />
                </td>

                {* Пользователь *}
                <td class="cell-user">
                    <div class="cell-user-wrapper">
                        <a href="{router page="admin/users/profile/{$user->getId()}"}" class="cell-user-avatar {if $user->isOnline()}user-is-online{/if}">
                            <img src="{$user->getProfileAvatarPath(48)}"
                                 alt="avatar"
                                 title="{if $user->isOnline()}{$aLang.user_status_online}{else}{$aLang.user_status_offline}{/if}" />
                        </a>

                        <p class="cell-user-login word-wrap">
                            <a href="{router page="admin/users/profile/{$user->getId()}"}" class="link-border"
                               title="{$aLang.plugin.admin.users.table_header.login}"><span>{$user->getLogin()}</span></a>

                            {if $user->isAdministrator()}
                                <i class="icon-user-admin" title="{$aLang.plugin.admin.users.admin}"></i>
                            {/if}

                            {if $oBan = $user->getBannedCached()}
                                <a href="{$oBan->getBanViewUrl()}"><i class="fa fa-lock" title="{$aLang.plugin.admin.users.banned}"></i></a>
                            {/if}
                        </p>

                        {if $user->getProfileName()}
                            <p class="cell-user-name" title="{$aLang.plugin.admin.users.table_header.profile_name}">{$user->getProfileName()}</p>
                        {/if}

                        <p class="cell-user-mail" title="{$aLang.plugin.admin.users.table_header.mail}">{$user->getMail()}</p>
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
                    <p title="{$aLang.plugin.admin.users.table_header.reg}">
                        {date_format date=$user->getDateRegister() format="d.m.Y"},
                        <span>{date_format date=$user->getDateRegister() format="H:i"}</span>
                    </p>

                    {if $session}
                        <p title="{$aLang.plugin.admin.users.table_header.last_visit}">
                            {date_format date=$session->getDateLast() format="d.m.Y"},
                            <span>{date_format date=$session->getDateLast() format="H:i"}</span>
                        </p>
                    {/if}
                </td>

                {* IP *}
                <td class="cell-ip">
                    <p title="{$aLang.plugin.admin.users.table_header.user_ip_register}">
                        <a href="{router page='admin/users/list'}{request_filter
                            name=array('ip_register')
                            value=array($user->getIpRegister())
                        }">{$user->getIpRegister()}</a>
                    </p>
                    {if $session}
                        {* <p title="sess ip create">{$session->getIpCreate()}</p> *}
                        <p title="{$aLang.plugin.admin.users.table_header.session_ip_last}">
                            <a href="{router page='admin/users/list'}{request_filter
                                name=array('session_ip_last')
                                value=array($session->getIpLast())
                            }" title="{$aLang.plugin.admin.users.profile.info.search_this_ip}">{$session->getIpLast()}</a>
                        </p>
                    {/if}
                </td>

                {* Рейтинг и сила *}
                <td class="cell-rating">
                    {include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/user_actions.tpl" classes='dropdown-circle' oUser=$user}

                    <p class="user-rating {if $user->getRating() < 0}user-rating-negative{/if}" title="{$aLang.plugin.admin.users.table_header.user_rating}">
                        {$user->getRating()}
                    </p>
                </td>
            </tr>
        {/foreach}
    </tbody>
</table>

{include file="{$aTemplatePathPlugin.admin}forms/elements_on_page.tpl"
    sFormActionPath="{router page='admin/users/ajax-on-page'}"
    iCurrentValue = Config::Get('plugin.admin.users.per_page')}

{component 'admin:pagination' total=+$pagination.iCountPage current=+$pagination.iCurrentPage url="{$pagination.sBaseUrl}/page__page__/{$pagination.sGetParams}"}