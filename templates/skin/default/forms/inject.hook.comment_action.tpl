{*
	Добавить ссылку полного удаления комментария
*}
{if $oUserCurrent and $oUserCurrent->isAdministrator()}
	<li><a href="{router page="admin/comments/delete"}?id={$oComment->getId()}" class="link-dotted">{$aLang.plugin.admin.comments.full_deleting}...</a></li>
{/if}
