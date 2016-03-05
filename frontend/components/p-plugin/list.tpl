{**
 * Plugin list
 *}

{component_define_params params=[ 'plugins', 'pagination', 'updates', 'type' ]}

{if $plugins}
    <div class="ls-plugin-list">
        {foreach $plugins as $plugin}
            {component 'admin:p-plugin' plugin=$plugin updates=$updates}
        {/foreach}
    </div>
{else}
    {component 'admin:blankslate' text=$aLang.plugin.admin.plugins.no_plugins[$type]}
{/if}

{if $pagination}
    {component 'admin:pagination' total=+$pagination.iCountPage current=+$pagination.iCurrentPage url="{$pagination.sBaseUrl}/page__page__/{$pagination.sGetParams}"}
{/if}