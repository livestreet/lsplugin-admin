{**
 * Plugin
 *}

{$component = 'p-form'}
{component_define_params params=[ 'form', 'action', 'method', 'submit', 'isEdit', 'mods', 'classes', 'attributes' ]}

{$action = $action|default:''}
{$method = $method|default:'post'}

<form action="{$action}" method="{$method}" class="{$component} {cmods name=$component mods=$mods} {$classes}" {cattr list=$attributes}>
    {component 'admin:field' template='hidden.security-key'}

    {foreach $form as $field}
        {component 'admin:field' template=$field.field params=$field}
    {/foreach}

    {component 'admin:button'
        name='submit'
        text="{($isEdit) ? $aLang.plugin.admin.save : $aLang.plugin.admin.add}"
        mods='primary'
        value=1
        params=$submit}
</form>