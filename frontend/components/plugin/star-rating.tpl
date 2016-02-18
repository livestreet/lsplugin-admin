{**
 * Рейтинг звездочками
 *
 * @param integer $rating Рейтинг от 0 до 100
 * @param integer $count Кол-во голосов
 *}

{$component = 'star-rating'}
{component_define_params params=[ 'rating', 'count', 'mods', 'classes', 'attributes' ]}

<div class="{$component} {cmods name=$component mods=$mods} {$classes}" {cattr list=$attributes}>
    <ul class="{$component}-stars ls-clearfix" title="Средняя оценка: {$rating / 20}">
        {strip}
        {section stars start=10 step=20 loop=100}
    	    <li class="{$component}-item {if $rating >= $smarty.section.stars.index + 10}{$component}-item--full{elseif $rating >= $smarty.section.stars.index}{$component}-item--half{/if}"></li>
        {/section}
        {/strip}
    </ul>

    {if isset($count)}
        <span class="{$component}-count">{lang 'plugin.admin.plugins.install.reviews_declension' count=$count plural=true}</span>
    {/if}
</div>