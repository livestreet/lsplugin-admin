{**
 * Добавить ссылку полного удаления комментария
 *}

{component_define_params params=[ 'comment' ]}

{if $oUserCurrent and $oUserCurrent->isAdministrator()}
	<li><a href="{router page="admin/comments/delete"}?id={$comment->getId()}" class="link-dotted" target="_blank">{$aLang.plugin.admin.comments.full_deleting}</a></li>
{/if}