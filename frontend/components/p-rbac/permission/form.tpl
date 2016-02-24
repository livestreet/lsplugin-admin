{**
 * Форма добавления/редактирования разрешения
 *}

{$component = 'p-rbac-permission-form'}
{component_define_params params=[ 'permission', 'groups' ]}

{$items = [[ 'value' => '', 'text' => '' ]]}

{foreach $groups as $group}
    {$items[] = [ 'text' => $group->getTitle(), 'value' => $group->getId() ]}
{/foreach}

{component 'admin:p-form' isEdit=$permission submit=[ name => 'permission_submit' ] form=[
    [ field => 'select',   name => 'permission[group_id]',  label => 'Группа', items => $items ],
    [ field => 'text',     name => 'permission[title]',     label => 'Название' ],
    [ field => 'text',     name => 'permission[code]',      label => 'Код' ],
    [ field => 'text',     name => 'permission[plugin]',    label => 'Плагин' ],
    [ field => 'text',     name => 'permission[msg_error]', label => 'Сообщение об ошибке' ],
    [ field => 'checkbox', name => 'permission[state]',     label => 'Активно' ]
]}