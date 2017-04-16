{$component = 'p-menu-section'}
{component_define_params params=[ 'section', 'uid', 'mods', 'classes', 'attributes' ]}

{if $section->HasItems()}
    {$classes = "$classes has-submenu"}
{/if}

{if $section->GetActive()}
    {$classes = "$classes active"}
{/if}

<div class="{$component} {cmods name=$component mods=$mods} {$classes} open js-menu-section" {cattr list=$attributes} {if $uid}data-uid="{$uid}"{/if}>
    <a {if ! $section->HasItems()}href="{$section->GetUrlFull()}"{else}href="#"{/if}
       class="{$component}-item {if $section->HasItems()}js-menu-section-toggle{/if}">
        {if $section->getIcon()}
            {component 'admin:icon' classes="{$component}-icon" icon=$section->getIcon()}
        {else}
            <i class="{$component}-icon {$component}-icon-custom {$component}-icon-custom--{$section->GetName()}" title="{$section->GetCaption()|escape}"></i>
        {/if}

        <span class="{$component}-text">{$section->GetCaption()|escape}</span>
    </a>

    {* Подменю *}
    {if $section->HasItems()}
        <ul class="{$component}-submenu">
            {foreach $section->GetItems() as $item}
                <li class="{$component}-submenu-item {if $item->GetActive()}active{/if}">
                    <a href="{$item->GetUrlFull()}" {if $item->GetColor()}style="color: {$item->GetColor()}"{/if}>{$item->GetCaption()|escape}</a>
                </li>
            {/foreach}
        </ul>
    {/if}
</div>