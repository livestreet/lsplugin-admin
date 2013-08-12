{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}

	<h2 class="title mb20">
		Голосования
	</h2>

	{if aVotingList and count($aVotingList)>0}

		<table class="table">
			<thead>
				<tr>
					<th>target id</th>
					<th>target type</th>
					<th>dir</th>
					<th>val</th>
					<th>date</th>
					<th>ip</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$aVotingList item="oVote"}
					<tr>
						<td>
							{$oVote->getTargetId()}
						</td>
						<td>
							{$oVote->getTargetType()}
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
					</tr>
				{/foreach}
			</tbody>
		</table>
	{else}
		no votings yet
	{/if}

	{include file="{$aTemplatePathPlugin.admin}/pagination.tpl" aPaging=$aPaging}

{/block}