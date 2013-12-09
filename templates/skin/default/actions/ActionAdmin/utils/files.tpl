{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}


{block name='layout_page_title'}
	{$aLang.plugin.admin.utils.files.title}
{/block}


{block name='layout_content'}
	<div class="mb-20">
		{$aLang.plugin.admin.utils.files.info}
	</div>
	<div class="mb-10">
		<a class="js-question" href="{router page='admin/utils/files/checkencoding'}?security_ls_key={$LIVESTREET_SECURITY_KEY}">{$aLang.plugin.admin.utils.files.check_encoding}</a>
	</div>
	{hook run='admin_utils_files_item'}

{/block}