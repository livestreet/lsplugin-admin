{**
 * Инструкция по установке плагина
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_page_title'}
	{$aLang.plugin.admin.plugins.instructions.title} <span>{$oPlugin->getName()}</span>
{/block}

{block 'layout_content_actionbar'}
	{component 'admin:button' icon='arrow-left' url="{router page='admin/plugins/list'}" text=$aLang.plugin.admin.plugins.back_to_list}
{/block}

{block 'layout_content'}
	{component 'admin:p-plugin' template='instruction' plugin=$oPlugin}
{/block}