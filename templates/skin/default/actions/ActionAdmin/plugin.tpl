{extends file="{$aTemplatePathPlugin.admin}/layouts/layout.base.tpl"}

{block name='layout_head_end' append}
	<script type="text/javascript">
		ls.registry.set('sAdminUrl',{json var=$oAdminUrl->get()});
	</script>
{/block}

{block name='layout_content'}
	управление конкретным плагином<br/>

	содержание плагина:<br/><br/>
	
	{if $sAdminTemplateInclude}
		{include file=$sAdminTemplateInclude}
	{/if}
{/block}