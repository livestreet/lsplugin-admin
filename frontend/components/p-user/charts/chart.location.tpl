{**
 * Стат-ка по городам и странам
 *
 * @param data   Данные
 * @param total  Суммарное кол-во объектов
 *}

{$component = 'p-chart-location'}
{component_define_params params=[ 'data', 'total', 'section', 'sorting' ]}

{if $data and $data.collection and count($data.collection) > 0}
    {*
        получить массив со списком объектов для короткого представления (в селекте)
    *}
    {$aShortViewLivingStats = array_splice($data.collection, Config::Get('plugin.admin.users.max_items_in_living_users_stats'))}
    {*
        получить массив со списком объектов для полного вида (графиком)
    *}
    {$aNormalViewLivingStats = $data.collection}

    {*
        нужно для пересчета процентного соотношения представления стран или городов в коротком виде (в селекте)
    *}
    <script>
        var totalUsersCount = {$total};
    </script>

    <div class="{$component} ls-clearfix">
        {*
            кнопки управления сортировкой
        *}
        {component 'admin:button.group' classes="{$component}-sort" buttons=[
            [
                text => 'A-z',
                url => "{router page='admin/users/stats'}{request_filter name=array('living_sorting') value=array('alphabetic')}",
                classes => "js-ajax-load {if $sorting == 'alphabetic'}active{/if}"
            ],
            [
                text => '3-2-1',
                url => "{router page='admin/users/stats'}{request_filter name=array('living_sorting') value=array(null)}",
                classes => "js-ajax-load {if $sorting == 'top'}active{/if}"
            ]
        ]}

        {*
            кнопки управления типом отображаемых данных (страны или города)
        *}
        <h3 class="{$component}-title page-sub-header">
            {if $section == 'countries'}
                {$aLang.plugin.admin.users_stats.countries} {$aLang.plugin.admin.users_stats.and_text}
                <a href="{router page='admin/users/stats'}{request_filter
                    name=array('living_section')
                    value=array('cities')
                }" class="js-ajax-load">{$aLang.plugin.admin.users_stats.cities}</a>
            {elseif $section == 'cities'}
                <a href="{router page='admin/users/stats'}{request_filter
                    name=array('living_section')
                    value=array(null)
                }" class="js-ajax-load">{$aLang.plugin.admin.users_stats.countries}</a>
                {$aLang.plugin.admin.users_stats.and_text} {$aLang.plugin.admin.users_stats.cities}
            {/if}
        </h3>

        <table class="ls-table {$component}-data">
            {*
                вывод данных в полном виде (графиком)
            *}
            {foreach $aNormalViewLivingStats as $dataItem}
                {$iPercentage = number_format($dataItem.count * 100 / $total, 2, '.', '')}
                {$oEnt = $dataItem.entity}

                <tr>
                    <td class="{$component}-label" title="{$dataItem.count} {$aLang.plugin.admin.users_stats.users}">
                        {*
                            название страны или города
                        *}
                        {if $oEnt}
                            {*
                                вывод флага для страны
                            *}
                            {if $oEnt->getType()=='country'}
                                <span class="flag styled flag-{strtolower($oEnt->getCode())}"></span>
                            {/if}
                            <a href="{router page='people'}{$oEnt->getType()}/{$oEnt->getId()}/"
                               target="_blank"
                               class="{$oEnt->getType()} {if $oEnt->getType()=='country'}{$oEnt->getCode()}{/if}">{$oEnt->getName()|escape:'html'}</a>
                        {else}
                            {$dataItem.item}
                        {/if}
                    </td>
                    
                    <td class="{$component}-count">
                        {$dataItem.count}
                    </td>
                    
                    <td class="{$component}-percentages percent" title="{$dataItem.count} {$aLang.plugin.admin.users_stats.users}">
                        {$iPercentage}%
                    </td>

                    <td>
                        <div class="{$component}-bar" title="{$dataItem.count} {$aLang.plugin.admin.users_stats.users}">
                            <div class="{$component}-bar-value" style="width: {$iPercentage}%;"></div>
                        </div>
                    </td>
                </tr>
            {/foreach}

            {*
                вывод данных для короткого отображения (в селекте)
            *}
            {if $aShortViewLivingStats and count($aShortViewLivingStats) > 0}
                <tr class="chart-bar-location-custom">
                    <td class="{$component}-label">
                        <select id="admin_users_stats_living_stats_short_view_select" class="width-full">
                            {foreach $aShortViewLivingStats as $aItemRecord}
                                <option value="{$aItemRecord.count}">{$aItemRecord.item}</option>
                            {/foreach}
                        </select>
                    </td>
                    <td class="{$component}-count" id="admin_users_stats_living_stats_short_view_count"></td>
                    <td class="{$component}-percentages" id="admin_users_stats_living_stats_short_view_percentage"></td>
                    <td></td>
                </tr>
            {/if}
        </table>
    </div>
{/if}