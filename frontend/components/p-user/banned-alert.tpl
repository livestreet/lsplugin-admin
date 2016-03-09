{**
 * Сообщение в профиле что пользователь забанен с указанием причины
 * tip: в профиле админки и на сайте, для пользователя профиля и для админа
 *}

{component_define_params params=[ 'ban' ]}

{if $oUserCurrent->isAdministrator()}
	{* Полное описание бана для администраторов *}
	{$text = "`$aLang.plugin.admin.bans.user_is_banned` `$ban->getReasonForUser()`"}

	{if $ban->getComment()}
		{$text = $text|cat:'<br />'|cat:$ban->getComment()}
	{/if}

	{$text = $text|cat:'<br><br>'|cat:{component 'admin:button' mods='danger' url=$ban->getBanViewUrl() text=$aLang.plugin.admin.bans.more_info}}
{elseif $oUserCurrent->getId() == $oUserProfile->getId()}
	{* Сообщение для хозяина профиля *}
	{$text = $ban->getBanMessageForUser()}
{/if}

{if $text}
    {component 'admin:alert' text=$text mods='error'}
{/if}
