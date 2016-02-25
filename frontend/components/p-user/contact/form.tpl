{**
 * Форма добавления/редактирования контактов
 *}

{$component = 'p-user-contact-form'}
{component_define_params params=[ 'field', 'types' ]}

{$items = [[ 'value' => '', 'text' => '' ]]}

{foreach $types as $type}
    {$items[] = [ 'text' => $type, 'value' => $type ]}
{/foreach}

{component 'admin:p-form' isEdit=$field form=[
    [ field => 'select',   name => 'type',    label => 'Тип', items => $items ],
    [ field => 'text',     name => 'title',   label => 'Название' ],
    [ field => 'text',     name => 'name',    label => 'Имя' ],
    [ field => 'text',     name => 'pattern', label => 'Шаблон' ]
]}