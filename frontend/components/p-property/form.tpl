{**
 * Форма добавления/редактирования свойств
 *}

{$component = 'p-property-form'}
{component_define_params params=[ 'property' ]}

{if $property}
    {$_aRequest = [
        property => [
            type => $property->getTypeTitle(),
            title => $property->getTitle(),
            code => $property->getCode(),
            description => $property->getDescription()
        ]
    ]}
{/if}

<form method="post">
    {component 'admin:field' template='hidden.security-key'}

    {* Тип поля *}
    {$types = [
        [ 'value' => 'int',         'text' => 'Целое число' ],
        [ 'value' => 'float',       'text' => 'Дробное число' ],
        [ 'value' => 'varchar',     'text' => 'Строка' ],
        [ 'value' => 'text',        'text' => 'Текст' ],
        [ 'value' => 'checkbox',    'text' => 'Чекбокс' ],
        [ 'value' => 'date',        'text' => 'Дата' ],
        [ 'value' => 'select',      'text' => 'Выпадающий список' ],
        [ 'value' => 'tags',        'text' => 'Теги' ],
        [ 'value' => 'video_link',  'text' => 'Ссылка на видео' ],
        [ 'value' => 'file',        'text' => 'Файл' ],
        [ 'value' => 'image',       'text' => 'Изображение' ]
    ]}

    {component 'admin:field' template='select' name='property[type]' label='Тип поля' items=$types}

    {* Название *}
    {component 'admin:field' template='text' name='property[title]' label='Название'}

    {* Код *}
    {component 'admin:field' template='text' name='property[code]' label='Код'}

    {if $property}
        {* Краткое описание *}
        {component 'admin:field' template='text' name='property[description]' label='Краткое описание'}

        {* Дополнительные параметры для каждого типа *}
        {component "admin:p-property.type-{$property->getType()}" property=$property propertyParams=$property->getParamsEscape() rules=$property->getValidateRulesEscape()}
    {/if}

    {* Кнопки *}
    {component 'admin:button'
        name="{($property) ? 'property_update_submit' : 'property_create_submit'}"
        text="{($property) ? $aLang.plugin.admin.save : $aLang.plugin.admin.add}"
        value=1
        mods='primary'}
</form>