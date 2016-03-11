{**
 * Список банов
 *}

{$component = 'p-user-ban-list'}
{component_define_params params=[ 'bans', 'pagination' ]}

{if $bans}
    <table class="ls-table">
        <thead>
            <tr>
                <th>#</th>
                {*
                    правило бана
                *}
                {component 'admin:table.sorting-cell'
                    sCellClassName='block_rule'
                    mSortingOrder=array('block_type', 'user_id', 'ip', 'ip_start', 'ip_finish', 'add_date', 'edit_date')
                    mLinkHtml=array(
                        $aLang.plugin.admin.bans.table_header.block_type,
                        $aLang.plugin.admin.bans.table_header.user_id,
                        $aLang.plugin.admin.bans.table_header.ip,
                        $aLang.plugin.admin.bans.table_header.ip_start,
                        $aLang.plugin.admin.bans.table_header.ip_finish,
                        $aLang.plugin.admin.bans.table_header.add_date,
                        $aLang.plugin.admin.bans.table_header.edit_date
                    )
                    sDropDownHtml=$aLang.plugin.admin.bans.table_header.block_rule
                    sBaseUrl=$sFullPagePathToEvent}

                {*
                    тип ограничения пользования сайтом бана
                *}
                {component 'admin:table.sorting-cell'
                    sCellClassName='restriction_type'
                    mSortingOrder='restriction_type'
                    mLinkHtml=$aLang.plugin.admin.bans.table_header.restriction_type
                    sBaseUrl=$sFullPagePathToEvent}

                {*
                    тип временного интервала для бана
                *}
                {component 'admin:table.sorting-cell'
                    sCellClassName='time_type'
                    mSortingOrder='time_type'
                    mLinkHtml=$aLang.plugin.admin.bans.table_header.time_type
                    sBaseUrl=$sFullPagePathToEvent}
                {*
                    даты начала и конца
                *}
                {component 'admin:table.sorting-cell'
                    sCellClassName='date_start'
                    mSortingOrder='date_start'
                    mLinkHtml=$aLang.plugin.admin.bans.table_header.date_start
                    sBaseUrl=$sFullPagePathToEvent}

                {component 'admin:table.sorting-cell'
                    sCellClassName='date_finish'
                    mSortingOrder='date_finish'
                    mLinkHtml=$aLang.plugin.admin.bans.table_header.date_finish
                    sBaseUrl=$sFullPagePathToEvent}

                {*
                    дата создания и редактирования
                *}
                {*include file="{$aTemplatePathPlugin.admin}forms/sorting_cell.tpl"
                    sCellClassName='add_date'
                    mSortingOrder='add_date'
                    mLinkHtml=$aLang.plugin.admin.bans.table_header.add_date
                    sBaseUrl=$sFullPagePathToEvent
                *}
                {*include file="{$aTemplatePathPlugin.admin}forms/sorting_cell.tpl"
                    sCellClassName='edit_date'
                    mSortingOrder='edit_date'
                    mLinkHtml=$aLang.plugin.admin.bans.table_header.edit_date
                    sBaseUrl=$sFullPagePathToEvent
                *}

                {*
                    причина и комментарий для себя
                *}
                {*include file="{$aTemplatePathPlugin.admin}forms/sorting_cell.tpl"
                    sCellClassName='reason_for_user'
                    mSortingOrder='reason_for_user'
                    mLinkHtml=$aLang.plugin.admin.bans.table_header.reason_for_user
                    sBaseUrl=$sFullPagePathToEvent
                *}
                {*include file="{$aTemplatePathPlugin.admin}forms/sorting_cell.tpl"
                    sCellClassName='comment'
                    mSortingOrder='comment'
                    mLinkHtml=$aLang.plugin.admin.bans.table_header.comment
                    sBaseUrl=$sFullPagePathToEvent
                *}
                <th class="ls-table-cell-actions">
                    {$aLang.plugin.admin.controls}
                </th>
            </tr>
        </thead>

        <tbody>
            {foreach $bans as $ban}
                <tr>
                    <td>
                        <a href="{router page="admin/users/bans/view/{$ban->getId()}"}">{$ban->getId()}</a>
                    </td>
                    <td>
                        {component 'admin:p-user' template='ban-desc' ban=$ban}
                    </td>
                    <td>
                        {$aLang.plugin.admin.bans.list.restriction_types[$ban->getRestrictionType()]}
                    </td>

                    {* даты начала и окончания бана *}
                    <td>
                        {if $ban->getTimeType()==PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERMANENT}
                            {$aLang.plugin.admin.bans.list.time_type.permanent}
                        {elseif $ban->getTimeType()==PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERIOD}
                            {$aLang.plugin.admin.bans.list.time_type.period}
                        {/if}
                    </td>
                    <td>
                        {if $ban->getTimeType()==PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERIOD}
                            {$ban->getDateStart()}
                        {else}
                            &mdash;
                        {/if}
                    </td>
                    <td>
                        {if $ban->getTimeType()==PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERIOD}
                            {$ban->getDateFinish()}
                        {else}
                            &mdash;
                        {/if}
                    </td>

                    {* дата создания и редактирования *}
                    {*<td>
                        {$ban->getAddDate()}
                    </td>
                    <td>
                        {$ban->getEditDate()}
                    </td>*}

                    {* причина и комментарий для себя *}
                    {*<td>
                        {$ban->getReasonForUser()|escape:'html'|truncate:100:'...'}
                    </td>
                    <td>
                        {$ban->getComment()|escape:'html'|truncate:100:'...'}
                    </td>*}

                    <td class="ls-table-cell-actions">
                        <a href="{router page="admin/users/bans/edit/{$ban->getId()}"}"><i class="fa fa-edit"></i></a>
                        <a href="{router page="admin/users/bans/delete/{$ban->getId()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}" class="js-confirm-remove"><i class="fa fa-trash-o"></i></a>
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>

    {component 'admin:pagination.on-page' url={router page='admin/bans/ajax-on-page'} value=Config::Get('plugin.admin.bans.per_page')}
    {component 'admin:pagination' total=+$pagination.iCountPage current=+$pagination.iCurrentPage url="{$pagination.sBaseUrl}/page__page__/{$pagination.sGetParams}"}
{else}
    {component 'admin:blankslate' text=$aLang.plugin.admin.bans.list.no_bans}
{/if}