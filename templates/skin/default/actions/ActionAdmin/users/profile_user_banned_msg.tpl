
{*
	Сообщение в профиле что пользователь забанен с указанием причины
	tip: в профиле админки и на сайте
	для пользователя профиля и для админа

	todo: дополнить информацией на основе ограничений (полный бан или "только чтение")
*}

<div class="mt-10">
	<i class="icon-lock" title="{$aLang.plugin.admin.users.banned}"></i>

	{if $oUserCurrent->isAdministrator()}
		{*
			полное описание бана для администраторов
		*}
		<a href="{router page="admin/users/bans/view/{$oBan->getId()}"}">
			{$aLang.plugin.admin.bans.user_is_banned}
			<br />
			"{$oBan->getReasonForUser()}"
			<br />
			{$oBan->getComment()}
		</a>

	{elseif $oUserCurrent->getId() == $oUserProfile->getId()}
		{*
			сообщение для хозяина профиля
		*}
		{$oBan->getBanMessageForUser()}

	{/if}

</div>
