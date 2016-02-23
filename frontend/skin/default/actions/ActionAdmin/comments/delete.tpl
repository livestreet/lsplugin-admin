{**
 * Удаление комментария
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_page_title'}
	{$aLang.plugin.admin.comments.delete.title} #{$oComment->getId()} ({$oComment->getText()|truncate:15:'...'|escape:'html'})?
{/block}

{block 'layout_content'}
	<form action="{router page='admin/comments/delete'}" method="post" enctype="application/x-www-form-urlencoded">
		{* Скрытые поля *}
    	{component 'admin:field' template='hidden.security-key'}
    	{component 'admin:field' template='hidden' name='id' value=$oComment->getId()}

    	{component 'admin:alert' text=$aLang.plugin.admin.comments.delete.delete_info mods='info'}

		{* Кнопки *}
    	{component 'admin:button' name='submit_comment_delete' text=$aLang.plugin.admin.delete classes='js-confirm-remove' mods='primary'}
	</form>
{/block}