{**
 * Таблица новых объектов за период
 *}

<table class="table table-stats">
	<tbody>
		<tr>
			<td class="name">
				{$aLang.plugin.admin.index.new_topics}
			</td>
			<td class="growth" title="{$aLang.plugin.admin.index.new_topics_info}">
				{include "./new_items_table_growth.tpl" sObjectsType='topics'}
			</td>
			<td class="graph-line">
				{include "./new_items_table_line_stats.tpl"
					sObjectsType='topics'
					sDataType='ratings'
					sGraphLineTitle='рейтинг объектов в периоде'
				}

				{include "./new_items_table_line_stats.tpl"
					sObjectsType='topics'
					sDataType='votings'
					sGraphLineTitle='голоса за объекты в периоде'
				}
			</td>
		</tr>
		<tr>
			<td class="name">
				{$aLang.plugin.admin.index.new_comments}
			</td>
			<td class="growth" title="{$aLang.plugin.admin.index.new_comments_info}">
				{include "./new_items_table_growth.tpl" sObjectsType='comments'}
			</td>
			<td class="graph-line">
				{include "./new_items_table_line_stats.tpl"
					sObjectsType='comments'
					sDataType='ratings'
					sGraphLineTitle='рейтинг объектов в периоде'
				}

				{include "./new_items_table_line_stats.tpl"
					sObjectsType='comments'
					sDataType='votings'
					sGraphLineTitle='голоса за объекты в периоде'
				}
			</td>
		</tr>
		<tr>
			<td class="name">
				{$aLang.plugin.admin.index.new_blogs}
			</td>
			<td class="growth" title="{$aLang.plugin.admin.index.new_blogs_info}">
				{include "./new_items_table_growth.tpl" sObjectsType='blogs'}
			</td>
			<td class="graph-line">
				{include "./new_items_table_line_stats.tpl"
					sObjectsType='blogs'
					sDataType='ratings'
					sGraphLineTitle='рейтинг объектов в периоде'
				}

				{include "./new_items_table_line_stats.tpl"
					sObjectsType='blogs'
					sDataType='votings'
					sGraphLineTitle='голоса за объекты в периоде'
				}
			</td>
		</tr>
		<tr>
			<td class="name">
				{$aLang.plugin.admin.index.new_users}
			</td>
			<td class="growth" title="{$aLang.plugin.admin.index.new_users_info}">
				{include "./new_items_table_growth.tpl" sObjectsType='registrations'}
			</td>
			<td class="graph-line">
				{include "./new_items_table_line_stats.tpl"
					sObjectsType='registrations'
					sDataType='ratings'
					sGraphLineTitle='рейтинг объектов в периоде'
				}

				{include "./new_items_table_line_stats.tpl"
					sObjectsType='registrations'
					sDataType='votings'
					sGraphLineTitle='голоса за объекты в периоде'
				}
			</td>
		</tr>
	</tbody>
</table>
