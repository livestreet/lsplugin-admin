{**
 * Список разрешений роли
 *}

{$component = 'p-rbac-role-permissions'}
{component_define_params params=[ 'permissions', 'permissionGroups', 'groups', 'role' ]}

<div>
    <select id="rbac-role-permissions-select" data-role-id="{$role->getId()}">
        {foreach $permissionGroups as $permissionGroup}
            {$group = $groups[$permissionGroup@key]}

            {if $group}
                {$groupName = $group->getTitle()}
            {else}
                {$groupName = 'Без группы'}
            {/if}

            <optgroup label="{$groupName}">
                {foreach $permissionGroup as $permission}
                    <option value="{$permission->getId()}">{$permission->getTitleLang()} ({$permission->getCode()})</option>
                {/foreach}
            </optgroup>
        {/foreach}
    </select>

    {component 'admin:button' type='button' text='Добавить разрешение' classes='js-rbac-role-permission-add'}
</div>

{if $permissions}
    <ul class="js-rbac-role-permissions-area">
        {foreach $permissions as $permission}
            {component 'admin:p-rbac' template='role-permissions-item' role=$role permission=$permission}
        {/foreach}
    </ul>
{else}
    {component 'admin:blankslate' text='Нет ролей'}
{/if}