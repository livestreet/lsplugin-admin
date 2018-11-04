{**
 * Форма добавления/редактирования категории
 *}

{$component = 'p-cron-form'}
{component_define_params params=[ 'menuItems' ]}

<form method="post">
    {component 'admin:field' template='hidden.security-key'}

    {$items = [[
        'value' => '',
        'text' => ''
    ]]}

    {foreach $menuItems as $menuItem}
        {$items[] = [
            'text' => ''|str_pad:(2 * $menuItem.level):'-'|cat:{lang name=$menuItem['entity']->getTitle()},
            'value' => $menuItem['entity']->getId()
        ]}
    {/foreach}

    {component 'admin:field' template='select' name='item[pid]' label='Вложить в' items=$items}
    
    {* Код *}
    {component 'admin:field' template='text' name='item[name]' label='Код'}

    {* Название *}
    {component 'admin:field' template='text' name='item[title]' label='Название'}

    {* URL *}
    {component 'admin:field' template='text' name='item[url]' label='Url'}

    {* Сортировка *}
    {component 'admin:field' template='text' name='item[priority]' label='Приоритет'}
    
    {* Статус *}
    {component 'admin:field' template='checkbox' name='item[enable]' label='Включен'}
    
    {* Активный *}
    {component 'admin:field' template='checkbox' name='item[active]' label='Активный'}

    {* Кнопки *}
    {component 'admin:button' name='item_submit' text="{($_aRequest) ? $aLang.plugin.admin.save : $aLang.plugin.admin.add}" value=1 mods='primary'}
</form>