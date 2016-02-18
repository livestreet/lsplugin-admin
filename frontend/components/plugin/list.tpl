{**
 * Plugin list
 *}

{component_define_params params=[ 'plugins', 'updates', 'type' ]}

{if $plugins}
    {foreach $plugins as $plugin}
        {component 'admin:plugin' plugin=$plugin updates=$updates}
    {/foreach}
{else}
    {component 'admin:blankslate' text=$aLang.plugin.admin.plugins.no_plugins[$type]}
{/if}