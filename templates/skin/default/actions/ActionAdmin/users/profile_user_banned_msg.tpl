
{*
	Сообщение в профиле что пользователь забанен с указанием причины
*}

<div class="mt-10">
	<i class="icon-lock" title="{$aLang.plugin.admin.users.banned}"></i>
	<a href="{router page="admin/users/bans/view/{$oBan->getId()}"}">
		{$aLang.plugin.admin.bans.user_is_banned}
		<br />
		"{$oBan->getReasonForUser()}"
		<br />
		{$oBan->getComment()}
	</a>
</div>
