{**
 * Plugin
 *}

{$component = 'ls-plugin'}
{component_define_params params=[ 'plugin', 'updates', 'mods', 'classes', 'attributes' ]}

{if $plugin->getActive()}
    {$mods = "$mods activated"}
{else}
    {$mods = "$mods deactivated"}
{/if}

<div class="{$component} {cmods name=$component mods=$mods} {$classes}" {cattr list=$attributes}>
    {* Изображение *}
    <img class="{$component}-image" src="{$plugin->getLogo()}">

    <div class="{$component}-body">
        {* Заголовок *}
        <h2 class="{$component}-title">
            {* Редактировать настройки можно только активированного плагина *}
            {if $plugin->getActive() and $plugin->getOwnSettingsPageUrl()}
                <a href="{$plugin->getOwnSettingsPageUrl()}" title="{$aLang.plugin.admin.plugins.list.settings_tip}">{$plugin->getName()}</a>
            {else}
                {$plugin->getName()}
            {/if}
        </h2>

        <div class="{$component}-info-main">
            {* Версия *}
            <div class="{$component}-version">v{$plugin->getVersion()}</div>

            {* Автор *}
            <span class="{$component}-author">
                от <span class="{$component}-author-name">{$plugin->getAuthor()}</span>
            </span>
        </div>

        {* Описание *}
        <div class="{$component}-desc ls-text">
            {$plugin->getDescription()|strip_tags|escape}
        </div>

        {* Вывод информации об обновлении *}
        {if $updates && isset($updates[$plugin->getCode()])}
            {$info = $updates[$plugin->getCode()]}
            {$text = "<a href=\"{$info->getUrlDownload()}\" target=\"_blank\">{$aLang.plugin.admin.plugins.list.new_version_avaible} <b>{$info->getVersion()}</b></a>"}

            {component 'admin:alert' text=$text mods='info'}
        {/if}

        {* Информация *}
        <ul class="{$component}-info">
            <li class="{$component}-info-item">
                {component 'icon' icon='folder-o'} /plugins/{$plugin->getCode()}/
            </li>

            {if $plugin->getHomepage()}
                <li class="{$component}-info-item">
                    {component 'icon' icon='home'} {$plugin->getHomepage()}
                </li>
            {/if}

            {if $plugin->getInstallInstructionsText()}
                <li class="{$component}-info-item">
                    {component 'icon' icon='question-circle'} <a href="{$plugin->getInstallInstructionsUrl()}">Инструкция по установке</a>
                </li>
            {/if}
        </ul>
    </div>

    {* Управление *}
    <div class="{$component}-actions">
        {if $plugin->getActive()}
            {* Управление конфигом плагина *}
            {component 'admin:button'
                mods='block'
                url=$plugin->getConfigSettingsPageUrl()
                text=$aLang.plugin.admin.plugins.list.config
                attributes=[ title => $aLang.plugin.admin.plugins.list.config_tip ]}

            {* Активация *}
            {component 'admin:button'
                mods='block'
                url=$plugin->getDeactivateUrl()
                text=$aLang.plugin.admin.plugins.list.deactivate
                attributes=[ title => $aLang.plugin.admin.plugins.list.deactivate ]}
        {else}
            {component 'admin:button'
                mods='block'
                url=$plugin->getActivateUrl()
                text=$aLang.plugin.admin.plugins.list.activate
                attributes=[ title => $aLang.plugin.admin.plugins.list.activate ]}
        {/if}

        {* Обновление *}
        {if $plugin->getApplyUpdate() && $plugin->getActive()}
            {component 'admin:button'
                mods='block'
                url=$plugin->getApplyUpdateUrl()
                text=$aLang.plugin.admin.plugins.list.apply_update
                attributes=[ title => $aLang.plugin.admin.plugins.list.apply_update ]}
        {/if}

        {* Удаление *}
        {component 'admin:button'
            mods='block'
            url=$plugin->getRemoveUrl()
            text=$aLang.plugin.admin.plugins.list.remove
            attributes=[ title => $aLang.plugin.admin.plugins.list.remove, 'data-question-title' => $aLang.common.remove_confirm ]
            classes='js-question'}
    </div>
</div>
