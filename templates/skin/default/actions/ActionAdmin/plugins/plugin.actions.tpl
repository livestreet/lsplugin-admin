{**
 * Плагин / Элементы управления
 *}

{if $oPlugin->getActive()}
	<a href="{$oPlugin->getDeactivateUrl()}" title="{$aLang.plugin.admin.plugins.list.deactivate}" class="button width-150">{$aLang.plugin.admin.plugins.list.deactivate}</a>
{else}
	<a href="{$oPlugin->getActivateUrl()}" title="{$aLang.plugin.admin.plugins.list.activate}" class="button button-primary width-150">{$aLang.plugin.admin.plugins.list.activate}</a>
{/if}