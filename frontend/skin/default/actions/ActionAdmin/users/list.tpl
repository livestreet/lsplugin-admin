{**
 * Список пользователей
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_content_actionbar'}
	{component 'admin:p-user.search' queries=$aSearchRulesWithOriginalQueries action=$sFullPagePathToEvent}
{/block}

{block 'layout_page_title'}
	{$aLang.plugin.admin.users.title} <span>({$iUsersTotalCount})</span>
{/block}

{block 'layout_content'}
	{component 'admin:p-user' template='list' users=$aUsers pagination=$aPaging}
{/block}