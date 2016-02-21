{**
 * 
 *}

{$component = 'p-actionbar'}
{component_define_params params=[ 'content', 'backUrl', 'backText', 'mods', 'classes', 'attributes' ]}

<div class="{$component} {cmods name=$component mods=$mods} {$classes} ls-clearfix" {cattr list=$attributes}>
    {if $backUrl}
        {component 'admin:button' text=$backText|default:'Назад' url=$backUrl}
    {/if}

    {$content}
</div>