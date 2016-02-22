{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_options' append}
	{$layoutBackUrl = {router page="admin/utils/cron"}}
{/block}

{block 'layout_page_title'}
	{if $oTask}
		Изменение задачи
	{else}
		Добавление задачи
	{/if}
{/block}

{block 'layout_content'}
	{component 'admin:p-cron' template='form' task=$oTask}
{/block}