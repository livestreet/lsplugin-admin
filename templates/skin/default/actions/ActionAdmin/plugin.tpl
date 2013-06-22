{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}
	управление конкретным плагином<br/>

	содержание плагина:<br/><br/>
	
	{if $sAdminTemplateInclude}
		{include file=$sAdminTemplateInclude}
	{/if}
{/block}