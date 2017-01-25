{**
 * Список жалоб
 *}

{$component = 'p-user-report-list'}
{component_define_params params=[ 'reports', 'pagination' ]}

{if $reports}
    <table class="ls-table">
        <thead>
            <tr>
                {* ид *}
                {component 'admin:table.sorting-cell'
                    sCellClassName='id'
                    mSortingOrder='c.id'
                    mLinkHtml=$aLang.plugin.admin.users.complaints.list.table_header.id
                    sBaseUrl="{router page='admin/users/complaints'}"}

                {* на кого *}
                {component 'admin:table.sorting-cell'
                    sCellClassName='target_user_id'
                    mSortingOrder='c.target_user_id'
                    mLinkHtml=$aLang.plugin.admin.users.complaints.list.table_header.target_user_id
                    sBaseUrl="{router page='admin/users/complaints'}"}

                {* от кого *}
                {component 'admin:table.sorting-cell'
                    sCellClassName='user_id'
                    mSortingOrder='c.user_id'
                    mLinkHtml=$aLang.plugin.admin.users.complaints.list.table_header.user_id
                    sBaseUrl="{router page='admin/users/complaints'}"}

                {* тип *}
                {component 'admin:table.sorting-cell'
                    sCellClassName='type'
                    mSortingOrder='c.type'
                    mLinkHtml=$aLang.plugin.admin.users.complaints.list.table_header.type
                    sBaseUrl="{router page='admin/users/complaints'}"}

                {* текст *}
                <th>{$aLang.plugin.admin.users.complaints.list.table_header.text}</th>

                {* дата создания *}
                {component 'admin:table.sorting-cell'
                    sCellClassName='date_add'
                    mSortingOrder='c.date_add'
                    mLinkHtml=$aLang.plugin.admin.users.complaints.list.table_header.date_add
                    sBaseUrl="{router page='admin/users/complaints'}"}

                {* статус *}
                {component 'admin:table.sorting-cell'
                    sCellClassName='state'
                    mSortingOrder='c.state'
                    mLinkHtml=$aLang.plugin.admin.users.complaints.list.table_header.state
                    sBaseUrl="{router page='admin/users/complaints'}"}

                <th class="ls-table-cell-actions">
                    {$aLang.plugin.admin.controls}
                </th>
            </tr>
        </thead>

        <tbody>
            {foreach $reports as $report}
                <tr class="{if $report@iteration % 2 == 0}second{/if} {if $report->getState()==ModuleUser::COMPLAINT_STATE_NEW}new{/if}">
                    <td>
                        {$report->getId()}
                    </td>
                    <td>
                        {$oTargetUser = $report->getTargetUser()}
                        <a href="{router page="admin/users/profile/{$oTargetUser->getId()}"}" class="link-border"
                           title="{$aLang.plugin.admin.users.list.table_header.login}"><span>{$oTargetUser->getLogin()}</span></a>
                    </td>
                    <td>
                        {$oUserFrom = $report->getUser()}
                        <a href="{router page="admin/users/profile/{$oUserFrom->getId()}"}" class="link-border"
                           title="{$aLang.plugin.admin.users.list.table_header.login}"><span>{$oUserFrom->getLogin()}</span></a>
                    </td>
                    <td>
                        {$report->getTypeTitle()}
                    </td>
                    <td>
                        <a href="#"
                           data-type="modal-toggle"
                           data-modal-url="{router page="admin/users/complaints/ajax-modal-view"}"
                           data-param-complaint_id="{$report->getId()}"
                           title="{$aLang.plugin.admin.show}">{$report->getText()|escape:'html'|truncate:20:'...'}</a>
                    </td>
                    <td>
                        {date_format date=$report->getDateAdd() format="j.m.Y" notz=true}
                    </td>
                    <td>
                        {$aLang.plugin.admin.users.complaints.list.state[$report->getState()]}
                    </td>
                    <td class="ls-table-cell-actions">
                        <a href="#"
                           data-type="modal-toggle"
                           data-modal-url="{router page="admin/users/complaints/ajax-modal-view"}"
                           data-param-complaint_id="{$report->getId()}"
                           title="{$aLang.plugin.admin.show}"><i class="fa fa-list"></i></a>

                        <a href="{router page="admin/users/complaints/delete/{$report->getId()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}" title="{$aLang.plugin.admin.delete}"
                           class="js-question"><i class="fa fa-trash-o"></i></a>
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>

    {component 'admin:pagination.on-page' url={router page='admin/users/complaints/ajax-on-page'} value=Config::Get('plugin.admin.users.complaints.per_page')}
    {component 'admin:pagination' total=+$pagination.iCountPage current=+$pagination.iCurrentPage url="{$pagination.sBaseUrl}/page__page__/{$pagination.sGetParams}"}
{else}
    {component 'admin:blankslate' text=$aLang.plugin.admin.users.complaints.list.empty}
{/if}