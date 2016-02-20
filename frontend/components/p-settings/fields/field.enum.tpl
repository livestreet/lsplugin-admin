{**
 * Enum
 *}

{extends 'component@admin:field.select'}

{block 'field_options' append}
    {component_define_params params=[ 'parameter', 'key', 'formid' ]}

    {$label = $parameter->getName()}
    {$note = $parameter->getDescription()}
    {$selectedValue = $parameter->getValue()|escape}

    {* получить данные валидатора *}
    {$validatorData = $parameter->getValidator()}
    {$validatorParams = $validatorData['params']}

    {* Перечисление разрешенных значений в селекте *}
    {$enum = $validatorParams['enum']}
    {$items = []}

    {* Если разрешено не выбирать значение - добавить пустое значение *}
    {if $validatorParams['allowEmpty']}
        {$items[] = [
            'text' => '---',
            'value' => ''
        ]}
    {/if}

    {foreach $enum as $item}
        {$items[] = [
            'text' => $item|escape,
            'value' => $item|escape
        ]}
    {/foreach}
{/block}

{block 'field_input' prepend}
    {component 'admin:field' template='hidden' name=$name value=$formid}
    {component 'admin:field' template='hidden' name=$name value=$key}
{/block}
