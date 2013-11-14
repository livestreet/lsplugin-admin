{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}


{block name='layout_page_title'}
	{$aLang.plugin.admin.utils.title}
{/block}


{block name='layout_content'}
	<div class="mb-20">
		{$aLang.plugin.admin.utils.tables.info}
	</div>
	<div class="mb-10">
		<a class="question" href="{router page='admin/utils/tables/repaircomments'}?security_ls_key={$LIVESTREET_SECURITY_KEY}">{$aLang.plugin.admin.utils.tables.repair_comments}</a>
	</div>
	<div class="mb-10">
		<a class="question" href="{router page='admin/utils/tables/cleanstream'}?security_ls_key={$LIVESTREET_SECURITY_KEY}">{$aLang.plugin.admin.utils.tables.clean_stream}</a>
	</div>
	{hook run='admin_utils_tables_item'}

{/block}