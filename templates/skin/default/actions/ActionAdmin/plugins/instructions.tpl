{**
 * Инструкция по установке плагина
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_page_title'}
	{$aLang.plugin.admin.plugins.instructions.title} {if $oPlugin}"{$oPlugin->getName()}"{/if}
{/block}


{block name='layout_content_actionbar'}
	<a class="button" href="{router page='admin/plugins/list'}">&larr; {$aLang.plugin.admin.plugins.back_to_list}</a>
{/block}


{block name='layout_content'}
	{if $oPlugin}
		<div class="mb-30">
			{$aLang.plugin.admin.plugins.instructions.description}
		</div>

		<div class="mb-30 text plugin-instructions">
			{$oPlugin->getInstallInstructionsText()|escape|nl2br}
		</div>

		<div>
			<a href="{$oPlugin->getActivateUrl(false)}" title="{$aLang.plugins_plugin_activate}"
			   class="button button-primary">{$aLang.plugin.admin.plugins.instructions.controls.activate}</a>

			<a href="{router page='admin/plugins/list'}"
			   class="button" >{$aLang.plugin.admin.plugins.instructions.controls.dont_activate}</a>
		</div>
	{/if}
{/block}