{**
 * Статистика по активности юзеров
 *
 * @styles blocks.css
 *}

{extends file="{$aTemplatePathPlugin.admin}blocks/block.aside.base.tpl"}

{block name='block_title'}{$aLang.plugin.admin.users_stats.activity}{/block}
{block name='block_type'}home-stats{/block}
{block name='block_class'}block-home{/block}

{block name='block_content'}
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
{/block}