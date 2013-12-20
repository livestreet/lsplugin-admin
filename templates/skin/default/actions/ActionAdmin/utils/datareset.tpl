{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}


{block name='layout_page_title'}
	{$aLang.plugin.admin.utils.datareset.title}
{/block}


{block name='layout_content'}
	<div class="mb-20">
		{$aLang.plugin.admin.utils.datareset.info}
	</div>
	<div class="mb-10">
		<a class="js-question" href="{router page='admin/utils/datareset/resetallbansstats'}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
				>{$aLang.plugin.admin.utils.datareset.resetallbansstats}</a>
	</div>
	{hook run='admin_utils_files_item'}

{/block}