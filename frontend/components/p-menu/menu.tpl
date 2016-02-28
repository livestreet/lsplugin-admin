{**
 * Главное меню
 *}

{$component = 'p-menu'}
{component_define_params params=[ 'menu' ]}

<div class="{$component} {cmods name=$component mods=$mods} {$classes}" {cattr list=$attributes}>
    <div class="m-nav-toggle dropdown-toggle js-nav-main-fold-mobile"><i class="icon-list"></i> Навигация</div>

    <ul class="nav-main js-nav-main">
        {* Основные пункты меню *}
        {foreach $menu->GetSections() as $section}
            {if $section->getName() != 'addition'}
                <li class="nav-main-item nav-main-item-root {if $section->HasItems()}js-nav-main-item-root{/if} {if $section->GetActive()}active{/if}" data-item-id="{$section@index}">
                    <a {if ! $section->HasItems()}href="{$section->GetUrlFull()}"{else}href="#"{/if}
                       {if $section->HasItems()}class="js-dropdown-nav-main" data-dropdown-target="dropdown-menu-nav-main-{$section@index}"{/if}>
                        <i class="nav-main-item-icon nav-main-item-icon-{$section->GetName()}" title="{$section->GetCaption()|escape}"></i>
                        <span>{$section->GetCaption()|escape}</span>
                    </a>

                    {* Подменю *}
                    {if $section->HasItems()}
                        <ul class="js-nav-main-submenu">
                            {foreach $section->GetItems() as $oMenuItem}
                                <li {if $oMenuItem->GetActive()}class="active"{/if}>
                                    <a href="{$oMenuItem->GetUrlFull()}"><span>{$oMenuItem->GetCaption()|escape}</span></a>
                                </li>
                            {/foreach}
                        </ul>
                    {/if}
                </li>
            {/if}
        {/foreach}

        {if $section = $menu->GetSection('addition')}
            <li class="nav-main-item nav-main-item-root {if $section->HasItems()}js-nav-main-item-root{/if} {if $section->GetActive()}active{/if}" data-item-id="{$section@index + 1}">
                <a {if ! $section->HasItems()}href="{$section->GetUrlFull()}"{else}href="#"{/if}
                   {if $section->HasItems()}class="js-dropdown-nav-main" data-dropdown-target="dropdown-menu-nav-main-{$section@index + 1}"{/if}>
                    <i class="nav-main-item-icon nav-main-item-icon-{$section->GetName()}" title="{$section->GetCaption()|escape}"></i>
                    <span>{$section->GetCaption()|escape}</span>
                </a>

                {* Подменю *}
                {if $section->HasItems()}
                    <ul class="js-nav-main-submenu">
                        {foreach $section->GetItems() as $oMenuItem}
                            <li {if $oMenuItem->GetActive()}class="active"{/if}>
                                <a href="{$oMenuItem->GetUrlFull()}"><span>{$oMenuItem->GetCaption()|escape}</span></a>
                            </li>
                        {/foreach}
                    </ul>
                {/if}
            </li>
        {/if}

        {* todo: нужно пофиксить
        <li class="nav-main-item-root nav-main-item-fold">
            <a href="#" class="js-nav-main-fold">
                <i class="nav-main-item-icon nav-main-item-icon-fold"></i>
                <span class="link-dotted">Свернуть меню</span>
            </a>
        </li>
        *}
    </ul>
</div>