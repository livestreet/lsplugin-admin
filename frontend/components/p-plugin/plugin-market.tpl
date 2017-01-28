{**
 * Plugin market
 *}

{$component = 'ls-plugin'}
{component_define_params params=[ 'plugin', 'mods', 'classes', 'attributes' ]}

{$mods = "$mods market"}

{if $plugin->getAlreadyInstalled()}
    {$mods = "$mods installed"}
{/if}

{$compatibleWithCurrentSitesLSVersion = $plugin->getCompatibleWithCurrentSitesLSVersion()}

<div class="{$component} {cmods name=$component mods=$mods} {$classes}" {cattr list=$attributes}>
    {* Изображение *}
    <img class="{$component}-image" src="{$plugin->getAvatar()}">

    <div class="{$component}-body">
        {* Заголовок *}
        <h2 class="{$component}-title">
            <a href="{$plugin->getUrl()}?utm_source=site&utm_medium=install&utm_campaign=catalog">{$plugin->getTitle()}</a>
        </h2>

        <div class="{$component}-info-main">
            {* Версия *}
            <div class="{$component}-version">v{$plugin->getVersion()}</div>

            {* Автор *}
            {$user = $plugin->getUser()}

            <span class="{$component}-author">
                от <a href="{$user.profile}?utm_source=site&utm_medium=install&utm_campaign=catalog" target="_blank" class="{$component}-author-name">{$user.login}</a>
            </span>
        </div>

        {* Рейтинг *}
        {component 'admin:p-plugin' template='star-rating' classes="{$component}-rating" rating=$plugin->getMarkPercent() count=$plugin->getCountMark()}

        {* Оповещение о совместимости *}
        {if !$compatibleWithCurrentSitesLSVersion}
            {component 'admin:alert' mods='error' text='Не совместим с установленной версией движка'}
        {/if}

        {* Описание *}
        <div class="{$component}-desc ls-text">
            {$plugin->getDescriptionShort()}
        </div>

        {* Общая информация *}
        <ul class="{$component}-info">
            <li class="{$component}-info-item">
                Совместимость: {$plugin->getCompatibleLSVersionsString()}
            </li>

            <li class="{$component}-info-item">
                Добавлен: {date_format date=$plugin->getDateAdd() format="j F Y"}
                {if $plugin->getDateUpdate()}
                    | Обновлен: {date_format date=$plugin->getDateUpdate() format="j F Y"}
                {/if}
            </li>

            {* Количество установок (выводить только если есть) *}
            {if $plugin->getCountUse()}
                <li class="{$component}-info-item">
                    {if $plugin->getCost()}
                        {lang 'plugin.admin.plugins.plugin.installed_count' count=$plugin->getCountUse() plural=true}
                    {else}
                        {lang 'plugin.admin.plugins.plugin.downloaded_count' count=$plugin->getCountUse() plural=true}
                    {/if}
                </li>
            {/if}
        </ul>
    </div>

    {* Управление *}
    <div class="{$component}-actions">
        {if ! $plugin->getAlreadyInstalled() && $compatibleWithCurrentSitesLSVersion}
            {if $plugin->getCost()}
                {component 'admin:button' url=$plugin->getUrlUse() mods='primary' classes='addon-price' text="Купить за {$plugin->getCost()|round} {$aLang.plugin.admin.plugins.install.rubles}"}
            {else}
                {component 'admin:button' url=$plugin->getUrlUse() mods='primary' text="Установить"}
            {/if}
        {/if}
    </div>
</div>
