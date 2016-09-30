{**
 * Форма добавления/редактирования категории
 *}

{$component = 'p-cron-form'}
{component_define_params params=[ 'categories' ]}

<form method="post">
    {component 'admin:field' template='hidden.security-key'}

    {$items = [[
        'value' => '',
        'text' => ''
    ]]}

    {foreach $categories as $category}
        {$items[] = [
            'text' => ''|str_pad:(2 * $category.level):'-'|cat:$category['entity']->getTitle(),
            'value' => $category['entity']->getId()
        ]}
    {/foreach}

    {component 'admin:field' template='select' name='category[pid]' label='Вложить в' items=$items}

    {* Название *}
    {component 'admin:field' template='text' name='category[title]' label='Название'}

    {* Описиание *}
    {component 'admin:field' template='textarea' name='category[description]' label='Описание' escape=false}

    {* URL *}
    {component 'admin:field' template='text' name='category[url]' label='Url'}

    {* Сортировка *}
    {component 'admin:field' template='text' name='category[order]' label='Сортировка'}

    {* Кнопки *}
    {component 'admin:button' name='category_submit' text="{($_aRequest) ? $aLang.plugin.admin.save : $aLang.plugin.admin.add}" value=1 mods='primary'}
</form>