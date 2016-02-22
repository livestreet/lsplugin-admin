{**
 * Экшнбар
 *}

{$component = 'p-actionbar'}
{component_define_params params=[ 'content', 'backUrl', 'backText', 'mods', 'classes', 'attributes' ]}

{if trim($content) || $backUrl}
    <div class="{$component} {cmods name=$component mods=$mods} {$classes} ls-clearfix" {cattr list=$attributes}>
        {if $backUrl}
            {component 'admin:button' text=$backText|default:'Назад' url=$backUrl}
        {/if}

        {$content}
    </div>
{/if}