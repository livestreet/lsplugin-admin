{**
 * Install instruction
 *}

{$component = 'ls-plugin-instruction'}
{component_define_params params=[ 'plugin' ]}

<div class="{$component}">
    <div class="{$component}-text ls-text">
        {$plugin->getInstallInstructionsText()|trim|escape|nl2br}
    </div>

    <div class="{$component}-buttons">
        {component 'admin:button' mods='primary' url=$plugin->getActivateUrl(false) text=$aLang.plugin.admin.plugins.instructions.controls.activate}
        {component 'admin:button' url={router page='admin/plugins/list'} text=$aLang.plugin.admin.plugins.instructions.controls.dont_activate}
    </div>
</div>