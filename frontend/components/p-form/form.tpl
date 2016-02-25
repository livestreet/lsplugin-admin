{**
 * Plugin
 *}

{$component = 'p-form'}
{component_define_params params=[ 'form', 'action', 'method', 'submit', 'isEdit', 'mods', 'classes', 'attributes' ]}

{$action = $action|default:''}
{$method = $method|default:'post'}

{$submit = array_merge([
    text => ($isEdit) ? $aLang.plugin.admin.save : $aLang.plugin.admin.add,
    name => 'submit',
    value => 1,
    mods => 'primary'
], $submit|default:[])}

<form action="{$action}" method="{$method}" class="{$component} {cmods name=$component mods=$mods} {$classes}" {cattr list=$attributes}>
    {component 'admin:field' template='hidden.security-key'}

    {if is_array($form)}
        {foreach $form as $field}
            {component 'admin:field' template=$field.field params=$field}
        {/foreach}
    {else}
        {$form}
    {/if}

    {component 'admin:button' params=$submit}
</form>