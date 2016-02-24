{**
 * Список пользователей роли
 *}

{$component = 'p-rbac-role-users'}
{component_define_params params=[ 'users', 'pagination', 'role' ]}

<div>
    Логин: <input type="text" class="width-250 autocomplete-users" value="" data-role-id="{$role->getId()}" id="rbac-role-users-input" autocomplete="off">

    {component 'admin:button' text='Добавить пользователя' classes='js-rbac-role-user-add'}
</div>

<br/>

<ul class="js-rbac-role-user-area">
    {foreach $users as $user}
        {component 'admin:p-rbac' template='role-users-item' user=$user role=$role}
    {/foreach}
</ul>

{component 'admin:pagination' total=+$pagination.iCountPage current=+$pagination.iCurrentPage url="{$pagination.sBaseUrl}/page__page__/{$pagination.sGetParams}"}