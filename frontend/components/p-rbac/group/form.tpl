{**
 * Форма добавления/редактирования группы
 *}

{$component = 'p-rbac-group-form'}
{component_define_params params=[ 'group' ]}

{component 'admin:p-form' isEdit=$group submit=[ name => 'group_submit' ] form=[
    [ field => 'text', name => 'group[title]', label => 'Название' ],
    [ field => 'text', name => 'group[code]',  label => 'Код' ]
]}