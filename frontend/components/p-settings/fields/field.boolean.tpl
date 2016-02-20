{**
 * Логическое поле (да/нет)
 *}

{extends 'component@admin:field.checkbox'}

{block 'field_options' append}
    {component_define_params params=[ 'parameter', 'key', 'formid' ]}

    {$label = $parameter->getName()}
    {$note = $parameter->getDescription()}
    {$checked = $parameter->getValue()}
{/block}

{block 'field_input' prepend}
    {component 'admin:field' template='hidden' name=$name value=$formid}
    {component 'admin:field' template='hidden' name=$name value=$key}
{/block}
