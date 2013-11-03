{*
	Кнопки управления баном
*}

<a class="edit" href="{router page="admin/users/bans/edit/{$oBan->getId()}"}"><i class="icon-edit"></i></a>
<a class="delete question"
   href="{router page="admin/users/bans/delete/{$oBan->getId()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
   data-question-title="{$aLang.plugin.admin.delete}?"><i class="icon-remove"></i></a>
{*
	вывод статистики сколько раз данный бан сработал
*}
{if isset($aBansStats[$oBan->getId()])}
	<i class="icon-info-sign" title="{$aLang.plugin.admin.bans.list.this_ban_triggered|ls_lang:"count%%`$aBansStats[$oBan->getId()]`"}"></i>
{/if}
