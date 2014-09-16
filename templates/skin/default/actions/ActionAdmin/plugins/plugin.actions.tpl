{**
 * Плагин / Элементы управления
 *}

{if $oPlugin->getActive()}
	<a href="{$oPlugin->getDeactivateUrl()}" title="{$aLang.plugin.admin.plugins.list.deactivate}" class="button width-150">{$aLang.plugin.admin.plugins.list.deactivate}</a>
{else}
	<a href="{$oPlugin->getActivateUrl()}" title="{$aLang.plugin.admin.plugins.list.activate}" class="button button-primary width-150">{$aLang.plugin.admin.plugins.list.activate}</a>
{/if}

{if $oPlugin->getApplyUpdate() and $oPlugin->getActive()}
	<a href="{$oPlugin->getApplyUpdateUrl()}" title="{$aLang.plugin.admin.plugins.list.apply_update}" class="button">{$aLang.plugin.admin.plugins.list.apply_update}</a>
{/if}

<a href="{$oPlugin->getRemoveUrl()}" title="{$aLang.plugin.admin.plugins.list.remove}" class="button width-150" onclick="return confirm('{$aLang.common.remove_confirm}');">{$aLang.plugin.admin.plugins.list.remove}</a>