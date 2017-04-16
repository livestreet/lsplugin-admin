{**
 * Проверка и восстановление
 *
 * TODO: Hooks
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}


{block name='layout_page_title'}
	{$aLang.plugin.admin.utils.optimization.title}
{/block}


{block name='layout_content'}
    {**
	 * Сброс данных
	 *}
    {component 'admin:p-optimization' template='section'
        title=$aLang.plugin.admin.utils.optimization.datareset.title
        desc=$aLang.plugin.admin.utils.optimization.datareset.info
        actions=[
            [
                url => "{router page='admin/utils/optimization/resetallbansstats'}?security_ls_key={$LIVESTREET_SECURITY_KEY}",
                text => $aLang.plugin.admin.utils.optimization.datareset.resetallbansstats
            ],
            [
                url => "{router page='admin/utils/optimization/deleteoldbanrecords'}?security_ls_key={$LIVESTREET_SECURITY_KEY}",
                text => $aLang.plugin.admin.utils.optimization.datareset.deleteoldbanrecords
            ],
            [
                url => "{router page='admin/utils/optimization/resetalllscache'}?security_ls_key={$LIVESTREET_SECURITY_KEY}",
                text => $aLang.plugin.admin.utils.optimization.datareset.resetalllscache
            ]
        ]}

    {*
    <div class="mb-10">
        <a href="{router page='admin/utils/optimization/resetconfigsheme'}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
                >{$aLang.plugin.admin.utils.optimization.datareset.resetconfigsheme}</a>
    </div>
    *}

    {hook run='admin_utils_optimization_datareset_item'}

    {**
	 * Восстановление данных
	 *}
    {component 'admin:p-optimization' template='section'
        title=$aLang.plugin.admin.utils.optimization.restore.title
        desc=$aLang.plugin.admin.utils.optimization.restore.info
        actions=[
            [
                url => "{router page='admin/utils/optimization/restore-comments'}?security_ls_key={$LIVESTREET_SECURITY_KEY}",
                text => $aLang.plugin.admin.utils.optimization.restore.comments
            ],
            [
                url => "{router page='admin/utils/optimization/restore-counter-favourite'}?security_ls_key={$LIVESTREET_SECURITY_KEY}",
                text => $aLang.plugin.admin.utils.optimization.restore.counter_favourite
            ],
            [
                url => "{router page='admin/utils/optimization/restore-counter-vote'}?security_ls_key={$LIVESTREET_SECURITY_KEY}",
                text => $aLang.plugin.admin.utils.optimization.restore.counter_vote
            ],
            [
                url => "{router page='admin/utils/optimization/restore-counter-topic'}?security_ls_key={$LIVESTREET_SECURITY_KEY}",
                text => $aLang.plugin.admin.utils.optimization.restore.counter_topic
            ],
            [
                url => "{router page='admin/utils/optimization/recreate-previews'}?security_ls_key={$LIVESTREET_SECURITY_KEY}",
                text => $aLang.plugin.admin.utils.optimization.recreate_previews
            ]
        ]}

    {hook run='admin_utils_optimization_restore'}

	{**
	 * Проверка таблиц БД
	 *}
    {component 'admin:p-optimization' template='section'
        title=$aLang.plugin.admin.utils.optimization.tables.title
        desc=$aLang.plugin.admin.utils.optimization.tables.info
        actions=[
            [
                url => "{router page='admin/utils/optimization/repaircomments'}?security_ls_key={$LIVESTREET_SECURITY_KEY}",
                text => $aLang.plugin.admin.utils.optimization.tables.repair_comments
            ],
            [
                url => "{router page='admin/utils/optimization/cleanstream'}?security_ls_key={$LIVESTREET_SECURITY_KEY}",
                text => $aLang.plugin.admin.utils.optimization.tables.clean_stream
            ],
            [
                url => "{router page='admin/utils/optimization/cleanvotings'}?security_ls_key={$LIVESTREET_SECURITY_KEY}",
                text => $aLang.plugin.admin.utils.optimization.tables.clean_votings
            ],
            [
                url => "{router page='admin/utils/optimization/cleanfavourites'}?security_ls_key={$LIVESTREET_SECURITY_KEY}",
                text => $aLang.plugin.admin.utils.optimization.tables.clean_favourites
            ]
        ]}

	{hook run='admin_utils_optimization_tables_item'}

	{**
	 * Проверка файлов
	 *}
    {component 'admin:p-optimization' template='section'
        title=$aLang.plugin.admin.utils.optimization.files.title
        desc=$aLang.plugin.admin.utils.optimization.files.info
        actions=[
            [
                url => "{router page='admin/utils/optimization/checkencoding'}?security_ls_key={$LIVESTREET_SECURITY_KEY}",
                text => $aLang.plugin.admin.utils.optimization.files.check_encoding
            ]
        ]}

	{hook run='admin_utils_optimization_files_item'}
{/block}