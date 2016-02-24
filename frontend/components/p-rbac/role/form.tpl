{**
 * Форма добавления/редактирования роли
 *}

{$component = 'p-rbac-role-form'}
{component_define_params params=[ 'role', 'roles' ]}

{$items = [[ 'value' => '', 'text' => '' ]]}

{foreach $roles as $_role}
    {$items[] = [
        'text' => ''|str_pad:(2 * $_role.level):'-'|cat:$_role['entity']->getTitle(),
        'value' => $_role['entity']->getId()
    ]}
{/foreach}

{component 'admin:p-form' isEdit=$role submit=[ name => 'role_submit' ] form=[
    [ field => 'select',   name => 'role[pid]',   label => 'Наследовать от', items => $items ],
    [ field => 'text',     name => 'role[title]', label => 'Название' ],
    [ field => 'text',     name => 'role[code]',  label => 'Код' ],
    [ field => 'checkbox', name => 'role[state]', label => 'Активна' ]
]}