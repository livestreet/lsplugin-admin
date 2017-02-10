{**
 * Страница вывода ошибок
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_options'}
	{$bNoSidebar = true}
	{$bNoSystemMessages = true}
{/block}

{block 'layout_page_title'}
	{if $aMsgError[0].title}
		{$aLang.common.error.error}: <span>{$aMsgError[0].title}</span>
	{/if}
{/block}

{block 'layout_content'}
	<p>{$aMsgError[0].msg}</p>
	<p>
		<a href="javascript:history.go(-1);">{$aLang.common.site_history_back}</a>,
		<a href="{Router::GetPath('/')}">{$aLang.common.site_go_main}</a>
	</p>
{/block}