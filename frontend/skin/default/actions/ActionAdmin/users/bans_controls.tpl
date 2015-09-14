{**
 * Кнопки управления баном
 *}

{* Вывод статистики сколько раз данный бан сработал *}
{if isset($aBansStats[$oBan->getId()])}
	<i class="fa fa-info js-tooltip" title="{$aLang.plugin.admin.bans.list.this_ban_triggered|ls_lang:"count%%`$aBansStats[$oBan->getId()]`"}"></i>
{/if}

<a href="{router page="admin/users/bans/edit/{$oBan->getId()}"}"><i class="fa fa-edit"></i></a>
<a class="js-question"
   href="{router page="admin/users/bans/delete/{$oBan->getId()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
   data-question-title="{$aLang.plugin.admin.delete}?"><i class="fa fa-trash-o"></i></a>