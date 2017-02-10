{**
 * Управление своей страницей настроек для плагина (интеграция интерфейса плагина в админку)
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_head_end' append}
	<script>
		ls.registry.set('sAdminUrl', {json var=$oAdminUrl->get()});
	</script>
{/block}


{block 'layout_page_title'}
	Плагин &laquo;<span title="{$oAdminUrl->getPluginCode()}">{$oAdminUrl->getPluginName()}</span>&raquo;
{/block}


{block 'layout_content'}
	{if $sAdminTemplateInclude}
		{include file=$sAdminTemplateInclude}
	{/if}
{/block}