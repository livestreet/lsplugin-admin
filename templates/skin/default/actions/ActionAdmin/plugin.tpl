{**
 * Управление своими настройками плагином (интеграция интерфейса плагина в админку)
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_head_end' append}
	<script>
		ls.registry.set('sAdminUrl',{json var=$oAdminUrl->get()});
	</script>
{/block}

{block name='layout_page_title'}
	{* todo: lang *}

	Управление плагином "<b>{$oAdminUrl->getPlugin()}</b>"
{/block}

{block name='layout_content'}
	{if $sAdminTemplateInclude}
		{include file=$sAdminTemplateInclude}
	{/if}
{/block}