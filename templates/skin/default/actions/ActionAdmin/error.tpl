{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_options'}
	{$bNoSidebar = true}
	{$noShowSystemMessage = true}
{/block}

{block name='layout_content'}
	{if $aMsgError[0].title}
    	<h2>{$aLang.error}: <span>{$aMsgError[0].title}</span></h2>
	{/if}

	<p>{$aMsgError[0].msg}</p>
	<p><a href="javascript:history.go(-1);">{$aLang.site_history_back}</a>, <a href="{router page='admin'}">{$aLang.site_go_main}</a></p>
{/block}