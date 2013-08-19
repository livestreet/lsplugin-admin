{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}

	<h2 class="title mb20">
		{$aLang.plugin.admin.users.votes.title}
	</h2>

	<div class="mb-20">
		{$aLang.plugin.admin.users.votes.votes_for}
		{$aLang.plugin.admin.users.votes.votes_type.$sVotingTargetType}
	</div>

	{if aVotingList and count($aVotingList)>0}

		<table class="table table-sorting">
			<thead>
				<tr>
					{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
						sCellClassName='targetid'
						sSortingOrder='target_id'
						sLinkHtml='target id'
						sBaseUrl="{router page="admin/users/votes/{$oUser->getId()}"}"
					}
					{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
						sCellClassName='vote_direction'
						sSortingOrder='vote_direction'
						sLinkHtml='direction'
						sBaseUrl="{router page="admin/users/votes/{$oUser->getId()}"}"
					}
					{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
						sCellClassName='vote_value'
						sSortingOrder='vote_value'
						sLinkHtml='value'
						sBaseUrl="{router page="admin/users/votes/{$oUser->getId()}"}"
					}
					{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
						sCellClassName='vote_date'
						sSortingOrder='vote_date'
						sLinkHtml='date'
						sBaseUrl="{router page="admin/users/votes/{$oUser->getId()}"}"
					}
					{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
						sCellClassName='vote_ip'
						sSortingOrder='vote_ip'
						sLinkHtml='ip'
						sBaseUrl="{router page="admin/users/votes/{$oUser->getId()}"}"
					}
					<th>
						target object
					</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$aVotingList item="oVote"}
					<tr>
						<td>
							{$oVote->getTargetId()}
						</td>
						<td>
							{$oVote->getDirection()}
						</td>
						<td>
							{$oVote->getValue()}
						</td>
						<td>
							{$oVote->getDate()}
						</td>
						<td>
							{$oVote->getIp()}
						</td>
						<td>
							<a href="{$oVote->getTargetFullUrl()}"
							   target="_blank"
							   title="{$oVote->getTargetTitle()|escape:'html'}">{$oVote->getTargetTitle()|truncate:100:'...'}</a>
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	{else}
		{$aLang.plugin.admin.users.votes.no_votes}
	{/if}

	{include file="{$aTemplatePathPlugin.admin}/pagination.tpl" aPaging=$aPaging}

{/block}