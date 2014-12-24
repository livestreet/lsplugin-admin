{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content_actionbar'}
	<a href="{router page="admin/utils/cron"}" class="button">&larr; Назад к списку</a>
{/block}

{block name='layout_page_title'}
	{if $oTask}
		Изменение задачи
	{else}
		Добавление задачи
	{/if}
{/block}

{block name='layout_content'}
	<form method="post">
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.hidden.security_key.tpl"}

		{* Название *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
				 sFieldName  = 'task[title]'
				 sFieldValue = $_aRequest.task.title
				 sFieldLabel = 'Название'}

		{* Метод *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
				sFieldName  = 'task[method]'
				sFieldValue = $_aRequest.task.method
				sFieldNote  = 'Указывается в полной форме, например, PluginArticle_Main_RunCron'
				sFieldLabel = 'Метод вызова'}


		{* Период *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
				 sFieldName  = 'task[period_run]'
				 sFieldValue = $_aRequest.task.period_run
				 sFieldNote  = 'С какой периодичностью запускать задачу, в минутах. Минимальное значение - 2 минуты.'
				 sFieldLabel = 'Период'}

		{* Активность *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.checkbox.tpl"
				sFieldName    = 'task[state]'
				bFieldChecked = $_aRequest.task.state
				sFieldLabel   = 'Активна'}

		<br/>

		{* Кнопки *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.button.tpl"
				 sFieldName  = 'task_submit'
				 sFieldText  = ($oTask) ? $aLang.plugin.admin.save : $aLang.plugin.admin.add
				 sFieldValue = '1'
				 sFieldStyle = 'primary'}
	</form>
{/block}