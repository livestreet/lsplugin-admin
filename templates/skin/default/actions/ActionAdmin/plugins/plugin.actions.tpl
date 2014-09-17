{**
 * Плагин / Элементы управления
 *}

{*
	управление конфигом плагина
*}
{if $oPlugin->getActive()}
	<a href="{$oPlugin->getConfigSettingsPageUrl()}" class="button width-150" title="{$aLang.plugin.admin.plugins.list.config_tip}">{$aLang.plugin.admin.plugins.list.config}</a>
{/if}

{*
	активация
*}
{if $oPlugin->getActive()}
	<a href="{$oPlugin->getDeactivateUrl()}" title="{$aLang.plugin.admin.plugins.list.deactivate}" class="button width-150">{$aLang.plugin.admin.plugins.list.deactivate}</a>
{else}
	<a href="{$oPlugin->getActivateUrl()}" title="{$aLang.plugin.admin.plugins.list.activate}" class="button button-primary width-150">{$aLang.plugin.admin.plugins.list.activate}</a>
{/if}

{*
	обновление
*}
{if $oPlugin->getApplyUpdate() and $oPlugin->getActive()}
	<a href="{$oPlugin->getApplyUpdateUrl()}" title="{$aLang.plugin.admin.plugins.list.apply_update}" class="button width-150">{$aLang.plugin.admin.plugins.list.apply_update}</a>
{/if}

{*
	удаление
*}
<a href="{$oPlugin->getRemoveUrl()}" title="{$aLang.plugin.admin.plugins.list.remove}" class="button width-150 js-question" data-question-title="{$aLang.common.remove_confirm}"
		>{$aLang.plugin.admin.plugins.list.remove}</a>
