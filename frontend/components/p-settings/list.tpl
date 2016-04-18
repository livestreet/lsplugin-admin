{**
 * Вывод настроек движка или плагина
 *}

{component_define_params params=[ 'sections', 'formid' ]}

{if $sections}
    <script>
        ls.registry.set('settings.admin_save_form_ajax_use', {json var=Config::Get('plugin.admin.settings.admin_save_form_ajax_use')});
    </script>

    <form action="{router page="admin/settings/save/{$sConfigName}"}" method="post" enctype="application/x-www-form-urlencoded" id="admin_settings_save">
        {component 'admin:field' template='hidden.security-key'}

        {foreach $sections as $section}
            {component 'admin:p-settings' template='fieldset' section=$section sectionIteration=$section@iteration formid=$formid}
        {/foreach}

        {component 'admin:button' name='submit_save_settings' mods='primary' text=$aLang.plugin.admin.save attributes=[ 'id' => 'admin_settings_submit' ]}
    </form>
{else}
    {component 'admin:blankslate' text=$aLang.plugin.admin.settings.no_settings_for_this_plugin}
{/if}