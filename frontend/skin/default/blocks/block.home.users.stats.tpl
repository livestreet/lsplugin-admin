{**
 * Статистика по активности юзеров
 *}

{capture 'block_content'}
	<table class="table table-stats">
		<tbody>
			<tr>
				<td>{$aLang.plugin.admin.users_stats.activity_active}</td>
				<td class="ta-r">{$aStats.count_active}</td>
				<td class="ta-r percent">{number_format($aStats.count_active*100/$aStats.count_all, 1, '.', '')} %</td>
			</tr>
			<tr>
				<td>{$aLang.plugin.admin.users_stats.activity_passive}</td>
				<td class="ta-r">{$aStats.count_inactive}</td>
				<td class="ta-r percent">{number_format($aStats.count_inactive*100/$aStats.count_all, 1, '.', '')} %</td>
			</tr>
			<tr>
				<td>{$aLang.plugin.admin.users_stats.good_users}</td>
				<td class="ta-r">{$aGoodAndBadUsers.good_users}</td>
				<td class="ta-r percent">{number_format($aGoodAndBadUsers.good_users*100/$aGoodAndBadUsers.total, 1, '.', '')} %</td>
			</tr>
			<tr>
				<td>{$aLang.plugin.admin.users_stats.bad_users}</td>
				<td class="ta-r">{$aGoodAndBadUsers.bad_users}</td>
				<td class="ta-r percent">{number_format($aGoodAndBadUsers.bad_users*100/$aGoodAndBadUsers.total, 1, '.', '')} %</td>
			</tr>
		</tbody>
	</table>
{/capture}

{component 'admin:block' title=$aLang.plugin.admin.users_stats.activity content=$smarty.capture.block_content}