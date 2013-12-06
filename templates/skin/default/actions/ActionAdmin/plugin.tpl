{**
 * Управление своими настройками плагином (интеграция интерфейса плагина в админку)
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_head_end' append}
	<script>
		ls.registry.set('sAdminUrl',{json var=$oAdminUrl->get()});
	</script>
{/block}

{block name='layout_content'}
	управление конкретным плагином<br/>

	содержание плагина "<b>{$oAdminUrl->getPlugin()}</b>":<br/><br/>
	
	{if $sAdminTemplateInclude}
		{include file=$sAdminTemplateInclude}
	{/if}
{/block}