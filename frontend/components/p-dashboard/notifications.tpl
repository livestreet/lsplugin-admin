{**
 * Список задач
 *}

{$component = 'p-notifications'}

{$items = [
    [
        name => 'plugins',
        icon => 'plug',
        url => {router page='admin/plugins/list'},
        title => {lang 'plugin.admin.index.updates.plugins.title'},
        text => {lang 'plugin.admin.index.updates.plugins.there_are_n_updates' count=$iPluginUpdates plural=true},
        text_no => {lang 'plugin.admin.index.updates.plugins.no_updates'},
        count => $iPluginUpdates
    ],
    [
        name => 'reports',
        icon => 'flag',
        url => {router page='admin/users/complaints'},
        title => {lang 'plugin.admin.index.updates.complaints.title'},
        text => {lang 'plugin.admin.index.updates.complaints.there_are_n_complaints' count=$iUsersComplaintsCountNew plural=true},
        text_no => {lang 'plugin.admin.index.updates.complaints.no_complaints'},
        count => $iUsersComplaintsCountNew
    ]
]}

{hook run="dashboard_notifications_items" assign='hookItems' items=$items array=true}
{$items = ( $hookItems ) ? $hookItems : $items}

<div class="{$component}">
    {foreach $items as $item}
        <div class="{$component}-item {if $item.count}active{/if}">
            <div class="{$component}-item-image">
                <a href="{$item.url}" class="{$component}-item-image-icon fa fa-{$item.icon}"></a>

                {if $item.count}
                    <div class="{$component}-item-count">
                        {($item.count < 1000) ? $item.count : '999+'}
                    </div>
                {/if}
            </div>

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