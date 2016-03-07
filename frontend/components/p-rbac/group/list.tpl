{**
 * Список групп
 *}

{$component = 'p-rbac-group-list'}
{component_define_params params=[ 'groups' ]}

{if $groups}
    <table class="ls-table">
        <thead>
            <tr>
                <th>Название</th>
                <th>Код</th>
                <th>Разрешений</th>
                <th class="ls-table-cell-actions">Действие</th>
            </tr>
        </thead>
        <tbody>
            {foreach $groups as $group}
                <tr data-id="{$group->getId()}">
                    <td>
                        {$group->getTitle()}
                    </td>
                    <td>{$group->getCode()}</td>
                    <td>
                        {$count = count($group->getPermissions())}

                        {if $count}
                            {$count|default:'&mdash;'}
                        {else}
                            &mdash;
                        {/if}
                    </td>
                    <td class="ls-table-cell-actions">
                        <a href="{$group->getUrlAdminUpdate()}" class="fa fa-edit" title="{$aLang.plugin.admin.edit}"></a>
                        <a href="{$group->getUrlAdminRemove()}?security_ls_key={$LIVESTREET_SECURITY_KEY}" class="fa fa-trash-o js-confirm-remove" title="{$aLang.plugin.admin.delete}"></a>
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>
{else}
    {component 'admin:blankslate' text='Нет групп'}
{/if}