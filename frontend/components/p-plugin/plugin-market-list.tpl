{**
 * Plugin market list
 *}

{component_define_params params=[ 'plugins', 'pagination' ]}

{if $plugins}
    <div class="ls-plugin-list">
        {foreach $plugins as $plugin}
            {component 'admin:p-plugin' template='plugin-market' plugin=$plugin}
        {/foreach}
    </div>
{else}
    {component 'admin:blankslate' text=$aLang.plugin.admin.plugins.install.no_addons}
{/if}

{if $pagination}
    {component 'admin:pagination' total=+$pagination.iCountPage current=+$pagination.iCurrentPage url="{$pagination.sBaseUrl}/page__page__/{$pagination.sGetParams}"}
{/if}