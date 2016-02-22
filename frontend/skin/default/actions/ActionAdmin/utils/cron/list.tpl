{**
 * Список задач
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_content_actionbar'}
	{component 'admin:button' text=$aLang.plugin.admin.add url={router page="admin/utils/cron/create"} mods='primary'}
{/block}

{block 'layout_page_title'}
	{$aLang.plugin.admin.utils.cron.title}
{/block}

{block 'layout_content'}
	{component 'admin:alert' text={lang 'plugin.admin.utils.cron.instruction' path=$sPathCron} mods='info'}
	{component 'admin:p-cron' template='list' items=$aTaskItems}
{/block}