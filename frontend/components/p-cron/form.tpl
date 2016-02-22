{**
 * Форма добавления/редактирования задачи
 *}

{$component = 'p-cron-form'}
{component_define_params params=[ 'task' ]}

<form method="post">
    {component 'admin:field' template='hidden.security-key'}

    {* Название *}
    {component 'admin:field' template='text' name='task[title]' label='Название'}

    {* Метод *}
    {component 'admin:field' template='text'
        name  = 'task[method]'
        note  = 'Указывается в полной форме, например, PluginArticle_Main_RunCron'
        label = 'Метод вызова'}

    {* Период *}
    {component 'admin:field' template='text'
        name  = 'task[period_run]'
        note  = 'С какой периодичностью запускать задачу, в минутах. Минимальное значение - 5 минуты.'
        label = 'Период'}

    {* Активность *}
    {component 'admin:field' template='checkbox' name='task[state]' label='Активна'}

    {* Кнопки *}
    {component 'admin:button' name='task_submit' text="{($task) ? $aLang.plugin.admin.save : $aLang.plugin.admin.add}" value=1 mods='primary'}
</form>