{**
 * Сброс данных
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content_actionbar'}
	<a href="{router page="admin/utils/cron/create"}" class="button button-primary">{$aLang.plugin.admin.add}</a>
{/block}

{block name='layout_page_title'}
	{$aLang.plugin.admin.utils.cron.title}
{/block}


{block name='layout_content'}

	<div class="mb-20">
		{lang name='plugin.admin.utils.cron.instruction' path=$sPathCron}
	</div>

	{if $aTaskItems}
		<table class="table">
			<thead>
			<tr>
				<th>Название</th>
				<th>Плагин</th>
				<th>Период</th>
				<th>Запусков</th>
				<th>Последний запуск</th>
				<th>Активна</th>
				<th class="ta-r">Действие</th>
			</tr>
			</thead>

			<tbody>
			{foreach $aTaskItems as $oTaskItem}
				{include './item.tpl' oTaskItem=$oTaskItem}
			{/foreach}
			</tbody>
		</table>
	{else}
		{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts="Список задач пуст" sAlertStyle='empty'}
	{/if}

{/block}