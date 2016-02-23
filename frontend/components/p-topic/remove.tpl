{**
 * Удаление типа топика
 *}

{$component = 'p-property-list'}
{component_define_params params=[ 'currentType', 'types', 'count' ]}

<p>Топиков с данным типом: <strong>{$count|default:'нет'}</strong></p>

<form action="{router page="admin/settings/topic-type/remove"}{$currentType->getId()}/" method="post" enctype="application/x-www-form-urlencoded">
    {component 'admin:field' template='hidden.security-key'}

    {if $types}
        {component 'admin:field' template='radio' name='type-remove' value='replace' checked=true label='Топики НЕ удаляются, у них меняется тип. Пользовательские поля удаляются'}

        {$items = []}

        {foreach $types as $type}
            {$items[] = [
                'text' => "{$type->getName()} - {$type->getCode()}",
                'value' => $type->getId()
            ]}
        {/foreach}

        {component 'admin:field' template='select' name='type-replace-id' label='Сменить тип на' items=$items}
    {/if}

    {component 'admin:field' template='radio' name='type-remove' value='remove' checked=!$types label='Топики и пользовательские поля УДАЛЯЮТСЯ. Удаление может занять длительное время'}

    {component 'admin:alert' text='Будьте аккуратны, удаление данных отменить нельзя!' mods='info'}

    {component 'admin:button' name='submit-remove' classes='js-confirm-remove' text=$aLang.common.remove mods='primary'}
</form>