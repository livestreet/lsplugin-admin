{**
 * Список разрешений
 *}

{$component = 'p-rbac-permission-list'}
{component_define_params params=[ 'permissionGroups', 'groups' ]}

{if $permissionGroups}
    <table class="ls-table">
        <thead>
            <tr>
                <th>Название</th>
                <th>Код</th>
                <th>Плагин</th>
                <th align="center">Статус</th>
                <th class="ls-table-cell-actions"></th>
            </tr>
        </thead>
        <tbody>
            {foreach $permissionGroups as $permissionGroup}
                {$group = $groups[$permissionGroup@key]}

                <tr>
                    <td colspan="5">
                        <b>
                            {if $group}
                                {$group->getTitle()}
                            {else}
                                Без группы
                            {/if}
                        </b>
                    </td>
                </tr>

                {foreach $permissionGroup as $permission}
                    <tr data-id="{$permission->getId()}">
                        <td style="padding-left: 30px;">
                            {$permission->getTitleLang()}
                        </td>
                        <td>{$permission->getCode()}</td>
                        <td>{$permission->getPlugin()}</td>
                        <td align="center">
                            {if $permission->getState() == ModuleRbac::PERMISSION_STATE_ACTIVE}
                                <span class="fa fa-eye"></span>
                            {else}
                                <span class="fa fa-eye-slash"></span>
                            {/if}
                        </td>
                        <td class="ls-table-cell-actions">
                            <a href="{$permission->getUrlAdminUpdate()}" class="fa fa-edit" title="{$aLang.plugin.admin.edit}"></a>
                            <a href="{$permission->getUrlAdminRemove()}?security_ls_key={$LIVESTREET_SECURITY_KEY}" class="fa fa-trash-o js-confirm-remove" title="{$aLang.plugin.admin.delete}"></a>
                        </td>
                    </tr>
                {/foreach}
            {/foreach}
        </tbody>
    </table>
{else}
    {component 'admin:blankslate' text='Нет разрешений'}
{/if}