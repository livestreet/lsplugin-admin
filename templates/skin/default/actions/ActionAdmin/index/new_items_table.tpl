<table class="table table-stats">
	<tbody>
		<tr>
			<td class="name">
				{$aLang.plugin.admin.index.new_topics}
			</td>
			<td class="growth" title="{$aLang.plugin.admin.index.new_topics_info}">
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/index/new_items_growth.tpl" sDataType='topics'}
			</td>
			<td class="voting-line">
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/index/new_items_voting_stats.tpl" sDataType='topics'}
			</td>
		</tr>
		<tr>
			<td class="name">
				{$aLang.plugin.admin.index.new_comments}
			</td>
			<td class="growth" title="{$aLang.plugin.admin.index.new_comments_info}">
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/index/new_items_growth.tpl" sDataType='comments'}
			</td>
			<td class="voting-line">
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/index/new_items_voting_stats.tpl" sDataType='comments'}
			</td>
		</tr>
		<tr>
			<td class="name">
				{$aLang.plugin.admin.index.new_blogs}
			</td>
			<td class="growth" title="{$aLang.plugin.admin.index.new_blogs_info}">
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/index/new_items_growth.tpl" sDataType='blogs'}
			</td>
			<td class="voting-line">
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/index/new_items_voting_stats.tpl" sDataType='blogs'}
			</td>
		</tr>
		<tr>
			<td class="name">
				{$aLang.plugin.admin.index.new_users}
			</td>
			<td class="growth" title="{$aLang.plugin.admin.index.new_users_info}">
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/index/new_items_growth.tpl" sDataType='registrations'}
			</td>
			<td class="voting-line">
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/index/new_items_voting_stats.tpl" sDataType='registrations'}
			</td>
		</tr>
	</tbody>
</table>
