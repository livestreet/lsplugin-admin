{**
 * Список задач
 *}

{$component = 'p-notifications'}

{$notifications = [
    [
        name => 'plugins',
        url => {router page='admin/plugins/list'},
        title => {lang 'plugin.admin.index.updates.plugins.title'},
        text => {lang 'plugin.admin.index.updates.plugins.there_are_n_updates' count=$iPluginUpdates plural=true},
        text_no => {lang 'plugin.admin.index.updates.plugins.no_updates'},
        count => $iPluginUpdates
    ],
    [
        name => 'reports',
        url => {router page='admin/users/complaints'},
        title => {lang 'plugin.admin.index.updates.complaints.title'},
        text => {lang 'plugin.admin.index.updates.complaints.there_are_n_complaints' count=$iUsersComplaintsCountNew plural=true},
        text_no => {lang 'plugin.admin.index.updates.complaints.no_complaints'},
        count => $iUsersComplaintsCountNew
    ],
    [
        name => 'support',
        url => '/',
        title => 'Обратная связь',
        text => 'Есть 2 новых обращения',
        text_no => 'Нет новых обращений',
        count => 2
    ]
]}

<div class="{$component}">
    {foreach $notifications as $item}
        <div class="{$component}-item {if $item.count}active{/if}">
            <a href="{$item.url}" class="{$component}-item-image">
                {if $item.count}
                    <div class="{$component}-item-count">
                        {($item.count < 1000) ? $item.count : '999+'}
                    </div>
                {/if}
            </a>
            <div class="{$component}-item-body">
                <h2 class="{$component}-item-title">
                    <a href="{$item.url}">{$item.title}</a>
                </h2>
                <div class="{$component}-item-text">{($item.count) ? $item.text : $item.text_no}</div>
            </div>
        </div>
    {/foreach}
</div>

{hook run='admin_stats_notification_item'}