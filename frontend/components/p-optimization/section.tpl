{**
 * Section
 *}

{$component = 'p-optimization-section'}
{component_define_params params=[ 'title', 'desc', 'actions' ]}

<div class="{$component} {cmods name=$component mods=$mods} {$classes}" {cattr list=$attributes}>
    <h2 class="{$component}-title">{$title}</h2>

    <div class="{$component}-desc">
        {$desc}
    </div>

    <div class="{$component}-body">
        {component 'admin:nav' showSingle=true mods='stacked' items=$actions}
    </div>
</div>