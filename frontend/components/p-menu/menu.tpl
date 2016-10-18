{**
 * Главное меню
 *}

{$component = 'p-menu'}
{component_define_params params=[ 'menu' ]}

<div class="{$component} {cmods name=$component mods=$mods} {$classes} js-menu" {cattr list=$attributes}>
    <div class="{$component}-toggle js-menu-mobile-toggle">
        Навигация
    </div>

    <ul class="{$component}-nav js-menu-nav">
        {* Основные пункты меню *}
        {foreach $menu->GetSections() as $section}
            {if $section->getName() != 'addition'}
                {component 'admin:p-menu.section' section=$section uid="c{$section@index}"}
            {/if}
        {/foreach}

        {* Дополнительные пункты *}
        {if $section = $menu->GetSection('addition')}
            {component 'admin:p-menu.section' section=$section uid="a{$section@index}"}
        {/if}

        {* Свернуть *}
        <div class="{$component}-section {$component}-section--fold">
            <a href="#" class="{$component}-section-item js-menu-fold">
                <i class="{$component}-section-icon {$component}-section-icon-custom {$component}-section-icon-custom--fold"></i>
                <span class="{$component}-section-text">Свернуть меню</span>
            </a>
        </div>
    </ul>
</div>