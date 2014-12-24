
{**
 * Сообщение в профиле что пользователь забанен с указанием причины
 * tip: в профиле админки и на сайте, для пользователя профиля и для админа
 *}

{if $oUserCurrent->isAdministrator()}
	{* Полное описание бана для администраторов *}
	{$sBanMessage = "`$aLang.plugin.admin.bans.user_is_banned` `$oBan->getReasonForUser()`"}
	{if $oBan->getComment()}
		{$sBanMessage = $sBanMessage|cat:'<br />'|cat:$oBan->getComment()}
	{/if}
	{$sBanMessage = $sBanMessage|cat:"<br /><a href=\"{$oBan->getBanViewUrl()}\">{$aLang.plugin.admin.bans.more_info}</a>"}

{elseif $oUserCurrent->getId() == $oUserProfile->getId()}
	{* Сообщение для хозяина профиля *}
	{$sBanMessage = $oBan->getBanMessageForUser()}
{/if}

{if $sBanMessage}
	{include file="{$aTemplatePathPlugin.admin}alert.tpl" sAlertStyle='error' mAlerts=$sBanMessage}
{/if}
