{**
 * Плагин / Элементы управления
 *}

{if $oPlugin->getActive()}
	<a href="{$oPlugin->getDeactivateUrl()}" title="{$aLang.plugins_plugin_deactivate}" class="button width-150">{$aLang.plugins_plugin_deactivate}</a>
{else}
	<a href="{$oPlugin->getActivateUrl()}" title="{$aLang.plugins_plugin_activate}" class="button button-primary width-150">{$aLang.plugins_plugin_activate}</a>
{/if}