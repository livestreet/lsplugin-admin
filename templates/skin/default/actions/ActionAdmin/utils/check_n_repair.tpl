{**
 * Проверка и восстановление
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}


{block name='layout_page_title'}
	{$aLang.plugin.admin.utils.check_n_repair.title}
{/block}


{block name='layout_content'}
	{**
	 * Проверка таблиц БД
	 *}
	{* todo: добавить иконки *}
	<h2 class="page-header"><span>{$aLang.plugin.admin.utils.check_n_repair.tables.title}</span></h2>

	<div class="mb-20">
		{$aLang.plugin.admin.utils.check_n_repair.tables.info}
	</div>

	<div class="mb-10">
		<a class="js-question" href="{router page='admin/utils/check_n_repair/repaircomments'}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
				>{$aLang.plugin.admin.utils.check_n_repair.tables.repair_comments}</a>
	</div>

	<div class="mb-10">
		<a class="js-question" href="{router page='admin/utils/check_n_repair/cleanstream'}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
				>{$aLang.plugin.admin.utils.check_n_repair.tables.clean_stream}</a>
	</div>

	{hook run='admin_utils_check_n_repair_tables_item'}


	{**
	 * Проверка файлов
	 *}
	{* todo: добавить иконки *}
	<h2 class="page-header mt-30"><span>{$aLang.plugin.admin.utils.check_n_repair.files.title}</span></h2>

	<div class="mb-20">
		{$aLang.plugin.admin.utils.check_n_repair.files.info}
	</div>

	<div class="mb-10">
		<a class="js-question" href="{router page='admin/utils/check_n_repair/checkencoding'}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
				>{$aLang.plugin.admin.utils.check_n_repair.files.check_encoding}</a>
	</div>

	{hook run='admin_utils_check_n_repair_files_item'}

{/block}