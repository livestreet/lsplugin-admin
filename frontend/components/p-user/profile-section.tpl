{$component = 'p-user-profile-section'}
{component_define_params params=[ 'title', 'content', 'mods', 'classes', 'attributes' ]}

<div class="{$component} {cmods name=$component mods=$mods} {$classes}" {cattr list=$attributes}>
    <h2 class="{$component}-title">{$title}</h2>

    <div class="{$component}-body">
        {$content}
    </div>
</div>