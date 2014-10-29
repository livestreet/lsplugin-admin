{**
 * Проверка и восстановление
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}


{block name='layout_page_title'}
	{$aLang.plugin.admin.utils.optimization.title}
{/block}


{block name='layout_content'}
    {**
	 * Сброс данных
	 *}
    {* todo: добавить иконки *}
    <h2 class="page-header"><span>{$aLang.plugin.admin.utils.optimization.datareset.title}</span></h2>

    <div class="mb-20">
        {$aLang.plugin.admin.utils.optimization.datareset.info}
    </div>

    <div class="mb-10">
        <a href="{router page='admin/utils/optimization/resetallbansstats'}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
                >{$aLang.plugin.admin.utils.optimization.datareset.resetallbansstats}</a>
    </div>

    <div class="mb-10">
        <a href="{router page='admin/utils/optimization/deleteoldbanrecords'}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
                >{$aLang.plugin.admin.utils.optimization.datareset.deleteoldbanrecords}</a>
    </div>

    <div class="mb-10">
        <a href="{router page='admin/utils/optimization/resetalllscache'}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
                >{$aLang.plugin.admin.utils.optimization.datareset.resetalllscache}</a>
    </div>

    {*
    <div class="mb-10">
        <a href="{router page='admin/utils/optimization/resetconfigsheme'}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
                >{$aLang.plugin.admin.utils.optimization.datareset.resetconfigsheme}</a>
    </div>
    *}

    {hook run='admin_utils_optimization_datareset_item'}
	{**
	 * Проверка таблиц БД
	 *}
	{* todo: добавить иконки *}
	<h2 class="page-header"><span>{$aLang.plugin.admin.utils.optimization.tables.title}</span></h2>

	<div class="mb-20">
		{$aLang.plugin.admin.utils.optimization.tables.info}
	</div>

	<div class="mb-10">
		<a href="{router page='admin/utils/optimization/repaircomments'}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
				>{$aLang.plugin.admin.utils.optimization.tables.repair_comments}</a>
	</div>

	<div class="mb-10">
		<a href="{router page='admin/utils/optimization/cleanstream'}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
				>{$aLang.plugin.admin.utils.optimization.tables.clean_stream}</a>
	</div>

	<div class="mb-10">
		<a href="{router page='admin/utils/optimization/cleanvotings'}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
				>{$aLang.plugin.admin.utils.optimization.tables.clean_votings}</a>
	</div>

	<div class="mb-10">
		<a href="{router page='admin/utils/optimization/cleanfavourites'}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
				>{$aLang.plugin.admin.utils.optimization.tables.clean_favourites}</a>
	</div>

	{hook run='admin_utils_optimization_tables_item'}


	{**
	 * Проверка файлов
	 *}
	{* todo: добавить иконки *}
	<h2 class="page-header mt-30"><span>{$aLang.plugin.admin.utils.optimization.files.title}</span></h2>

	<div class="mb-20">
		{$aLang.plugin.admin.utils.optimization.files.info}
	</div>

	<div class="mb-10">
		<a href="{router page='admin/utils/optimization/checkencoding'}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
				>{$aLang.plugin.admin.utils.optimization.files.check_encoding}</a>
	</div>

	{hook run='admin_utils_optimization_files_item'}

{/block}