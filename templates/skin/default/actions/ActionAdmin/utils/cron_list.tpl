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
				<tr id="cron-item-{$oTaskItem->getId()}">
					<td>
						{$oTaskItem->getTitleWithLang()}<br/>
						{$oTaskItem->getMethod()}
					</td>
					<td>{$oTaskItem->getPlugin()}</td>
					<td>{$oTaskItem->getPeriodRun()}</td>
					<td>{$oTaskItem->getCountRun()}</td>
					<td>{date_format date=$oTaskItem->getDateRunLast() format='j F Y <\b\r/> H:i:s'}</td>
					<td>
						{if $oTaskItem->getState()==ModuleCron::TASK_STATE_ACTIVE}
							да
						{else}
							нет
						{/if}
					</td>
					<td class="ta-r">
						<a href="#" class="icon-play" title="Запустить сейчас"></a>
						<a href="{router page='admin/utils/cron/update'}{$oTaskItem->getId()}/" class="icon-edit" title="Изменить"></a>
						<a href="{router page='admin/utils/cron/remove'}{$oTaskItem->getId()}/?security_ls_key={$LIVESTREET_SECURITY_KEY}" class="icon-remove" title="Удалить" onclick="if (confirm('Действительно удалить?')) { ls.plugin.article.admin.removeArticle({$oTaskItem->getId()}); } return false;"></a>
					</td>
				</tr>
			{/foreach}
			</tbody>
		</table>
	{else}
		{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts="Список задач пуст" sAlertStyle='empty'}
	{/if}

{/block}