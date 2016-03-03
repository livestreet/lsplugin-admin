{**
 * Vertical bar chart
 *
 * @param data  Данные
 * @param title Заголовок
 *}

{$component = 'p-chart-age'}
{component_define_params params=[ 'data', 'title' ]}

{if $data && $data.collection && count($data.collection) > 0}
    <div class="{$component}">
        <h3 class="page-sub-header">{$title}</h3>

        {if count($data.collection) < 20}
            {component 'admin:alert' text=$aLang.plugin.admin.users_stats.need_more_data mods='info'}
        {/if}

        {strip}
        <ul class="{$component}-items">
            {foreach $data.collection as $item}
                {* Высота столбика в процентах *}
                {$percentage = number_format($item.count * 100 / $data.max_one_age_users_count, 2, '.', '')}

                <li class="{$component}-item">
                    <div class="{$component}-item-bar" style="height: {$percentage}%;" title="{$item.count} {$aLang.plugin.admin.users_stats.users}"></div>

                    <div class="{$component}-item-value" title="{$item.count} {$aLang.plugin.admin.users_stats.users}">
                        {$item.years_old}
                    </div>
                </li>
            {/foreach}
        </ul>
        {/strip}
    </div>
{/if}