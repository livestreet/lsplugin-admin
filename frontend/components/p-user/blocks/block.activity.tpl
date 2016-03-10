{**
 * Статистика по активности юзеров
 *}

{component_define_params params=[ 'stats', 'rating' ]}

{capture 'block_content'}
	<table class="ls-table">
		<tbody>
			<tr>
				<td>{$aLang.plugin.admin.users_stats.activity_active}</td>
				<td class="ls-ta-r">{$stats.count_active}</td>
				<td class="ls-ta-r">{number_format($stats.count_active*100/$stats.count_all, 1, '.', '')}%</td>
			</tr>
			<tr>
				<td>{$aLang.plugin.admin.users_stats.activity_passive}</td>
				<td class="ls-ta-r">{$stats.count_inactive}</td>
				<td class="ls-ta-r">{number_format($stats.count_inactive*100/$stats.count_all, 1, '.', '')}%</td>
			</tr>
			<tr>
				<td>{$aLang.plugin.admin.users_stats.good_users}</td>
				<td class="ls-ta-r">{$rating.good_users}</td>
				<td class="ls-ta-r">{number_format($rating.good_users*100/$rating.total, 1, '.', '')}%</td>
			</tr>
			<tr>
				<td>{$aLang.plugin.admin.users_stats.bad_users}</td>
				<td class="ls-ta-r">{$rating.bad_users}</td>
				<td class="ls-ta-r">{number_format($rating.bad_users*100/$rating.total, 1, '.', '')}%</td>
			</tr>
		</tbody>
	</table>
{/capture}

{component 'admin:block' title=$aLang.plugin.admin.users_stats.activity mods='nopadding' content=$smarty.capture.block_content}