{**
 * Удаление комментария
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_page_title'}
	{$aLang.plugin.admin.comments.delete.title} #{$oComment->getId()} ({$oComment->getText()|truncate:15:'...'|escape})?
{/block}

{block 'layout_content'}
    {component 'admin:alert' text=$aLang.plugin.admin.comments.delete.delete_info mods='info'}

    {component 'admin:p-form'
        action={router page='admin/comments/delete'}
        submit = [ name => 'submit_comment_delete', classes => 'js-confirm-remove', text => $aLang.plugin.admin.delete ]
        form = [
            [ field => 'hidden', name => 'id', value => $oComment->getId() ]
        ]}
{/block}