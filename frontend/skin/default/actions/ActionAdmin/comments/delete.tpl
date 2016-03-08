{**
 * Удаление комментария
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_page_title'}
	{$aLang.plugin.admin.comments.delete.title} #{$oComment->getId()} ({$oComment->getText()|truncate:15:'...'|escape})?
{/block}

{block 'layout_content'}
    {component 'admin:p-comment.delete' comment=$oComment}
{/block}