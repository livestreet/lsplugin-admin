{**
 * Список ролей
 *}

{$component = 'p-rbac-role-list'}
{component_define_params params=[ 'roles' ]}

{if $roles}
    <table class="ls-table">
        <thead>
            <tr>
                <th>Название</th>
                <th>Код</th>
                <th align="center">Пользователей</th>
                <th align="center">Разрешений</th>
                <th align="center">Статус</th>
                <th class="ls-table-cell-actions"></th>
            </tr>
        </thead>
        <tbody>
            {foreach $roles as $roleWrapper}
                {$role = $roleWrapper['entity']}
                {$level = $roleWrapper['level']}

                <tr data-id="{$role->getId()}">
                    <td>
                        <i class="fa fa-file" style="margin-left: {$level * 20}px;"></i>
                        {$role->getTitle()}
                    </td>
                    <td>{$role->getCode()}</td>
                    <td align="center">
                        {if $role->getCode()==ModuleRbac::ROLE_CODE_GUEST}
                            &mdash;
                        {else}
                            {strip}
                            <a href="{$role->getUrlAdminAction('users')}">
                                {$iCount=$role->getCountUsers()}
                                {if $iCount}
                                    {$iCount}
                                {else}
                                    &mdash;
                                {/if}
                            </a>
                            {/strip}
                        {/if}
                    </td>
                    <td align="center">
                        {strip}
                        <a href="{$role->getUrlAdminAction('permissions')}">
                            {$iCount=count($role->getPermissions())}
                            {if $iCount}
                                {$iCount}
                            {else}
                                &mdash;
                            {/if}
                        </a>
                        {/strip}
                    </td>
                    <td align="center">
                        {if $role->getState()==ModuleRbac::ROLE_STATE_ACTIVE}
                            <span class="fa fa-eye"></span>
                        {else}
                            <span class="fa fa-eye-slash"></span>
                        {/if}
                    </td>
                    <td class="ls-table-cell-actions">
                        <a href="{$role->getUrlAdminAction('update')}" class="fa fa-edit" title="{$aLang.plugin.admin.edit}"></a>
                        <a href="{$role->getUrlAdminAction('remove')}?security_ls_key={$LIVESTREET_SECURITY_KEY}" class="fa fa-trash-o js-confirm-remove" title="{$aLang.plugin.admin.delete}"></a>
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>
{else}
    {component 'admin:blankslate' text='Нет ролей'}
{/if}