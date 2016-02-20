{**
 * Строковый тип
 *}

{extends 'component@admin:field.text'}

{block 'field_options' append}
    {component_define_params params=[ 'parameter', 'key', 'formid' ]}

    {$label = $parameter->getName()}
    {$note = $parameter->getDescription()}
    {$value = $parameter->getValue()|escape}
{/block}

{block 'field_input' prepend}
    {component 'admin:field' template='hidden' name=$name value=$formid}
    {component 'admin:field' template='hidden' name=$name value=$key}
{/block}
