{**
 * Skin
 *}

{$component = 'ls-plugin'}
{component_define_params params=[ 'skin', 'mods', 'classes', 'attributes' ]}

{$mods = "$mods skin"}

<div class="{$component} {cmods name=$component mods=$mods} {$classes}" {cattr list=$attributes}>
    {* Изображение *}
    <img class="{$component}-image" src="{$skin->getPreviewImage()}">

    <div class="{$component}-body">
        {* Заголовок *}
        <h2 class="{$component}-title">
            {$skin->getViewName()|escape}
        </h2>

        <div class="{$component}-info-main">
            {* Версия *}
            <div class="{$component}-version">v{$skin->getVersion()}</div>

            {* Автор *}
            <span class="{$component}-author">
                от <span class="{$component}-author-name">{$skin->getAuthor()}</span>
            </span>
        </div>

        {* Описание *}
        <div class="{$component}-desc ls-text">
            {$skin->getDescription()|strip_tags|escape}
        </div>

        {* Информация *}
        {if $skin->getXml() || ! $skin->getIsCurrent()}
            <ul class="{$component}-info">
                {if $skin->getHomepage()}
                    <li class="{$component}-info-item">
                        {component 'icon' icon='home'} {$skin->getHomepage()}
                    </li>
                {/if}

                {if ! $skin->getIsCurrent() && $skin->getThemes()}
                    <li class="{$component}-info-item">
                        {$aLang.plugin.admin.skin.themes}:
                        {foreach from=$skin->getThemes() item=aTheme}
                            <strong>{$aTheme.value}</strong>
                            ({$aTheme.description|escape})
                            {if ! $aTheme@last},{/if}
                        {/foreach}
                    </li>
                {/if}
            </ul>
        {/if}
    </div>

    {* Управление *}
    <div class="{$component}-actions">
        {if $skin->getIsCurrent()}
            {* Выбор темы *}
            {$menu = []}

            {foreach $skin->getThemes() as $theme}
                {$menu[] = [
                    name => $theme.value,
                    url => "{router page='admin/skins/changetheme/'|cat:$skin->getName()}?theme={$theme.value}&security_ls_key={$LIVESTREET_SECURITY_KEY}",
                    text => $theme.description
                ]}
            {/foreach}

            {component 'dropdown' text='...' classes='js-admin-actionbar-dropdown' activeItem=Config::Get('view.theme') menu=$menu}
        {else}
            {* Активировать *}
            {component 'admin:button' mods='block primary' url=$skin->getChangeSkinUrl() text=$aLang.plugin.admin.skin.use_skin}

            {* Превью *}
            {if $skin->getInPreview()}
                {component 'admin:button' mods='block' classes='active' url=$skin->getTurnOffPreviewUrl() text=$aLang.plugin.admin.skin.preview_skin}
            {else}
                {component 'admin:button' mods='block' url=$skin->getTurnOnPreviewUrl() text=$aLang.plugin.admin.skin.preview_skin}
            {/if}
        {/if}
    </div>
</div>
