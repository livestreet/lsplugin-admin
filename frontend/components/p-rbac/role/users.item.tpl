{**
 * Список пользователей роли
 *}

{$component = 'p-rbac-role-users-item'}
{component_define_params params=[ 'user', 'role' ]}

{$login = $user->getLogin()}
{$displayName = $user->getDisplayName()}

<li class="js-rbac-role-user-item" data-id="{$user->getId()}">
    <a href="{router page='admin/users/profile'}{$user->getId()}/">{$displayName|escape} {if $login != $displayName}({$login}){/if}</a> &mdash;
	<a href="#" class="fa fa-trash-o js-confirm-remove js-rbac-role-user-remove" data-user="{$user->getId()}" data-role="{$role->getId()}" title="{$aLang.plugin.admin.delete}"></a>
</li>