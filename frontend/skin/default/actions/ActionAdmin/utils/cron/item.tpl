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
		<a href="#" class="ls-icon-play" title="Запустить сейчас" onclick="return ls.admin_cron.runTask({$oTaskItem->getId()});"></a>
		<a href="{router page='admin/utils/cron/update'}{$oTaskItem->getId()}/" class="ls-icon-edit" title="Изменить"></a>
		<a href="{router page='admin/utils/cron/remove'}{$oTaskItem->getId()}/?security_ls_key={$LIVESTREET_SECURITY_KEY}" class="ls-icon-remove" title="Удалить" onclick="if (confirm('Действительно удалить?')) { ls.plugin.article.admin.removeArticle({$oTaskItem->getId()}); } return false;"></a>
	</td>
</tr>