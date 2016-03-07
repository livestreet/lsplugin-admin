{**
 * Список задач
 *}

{$component = 'p-cron'}
{component_define_params params=[ 'items' ]}

{if $items}
    <table class="ls-table">
        <thead>
            <tr>
                <th>Название</th>
                <th>Плагин</th>
                <th>Период</th>
                <th>Запусков</th>
                <th>Последний запуск</th>
                <th>Активна</th>
                <th class="ls-table-cell-actions">Действие</th>
            </tr>
        </thead>

        <tbody>
            {foreach $items as $item}
                {component 'admin:p-cron' template='item' item=$item}
            {/foreach}
        </tbody>
    </table>
{else}
    {component 'admin:blankslate' text="Список задач пуст"}
{/if}