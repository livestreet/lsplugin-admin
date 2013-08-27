{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}
	<h2 class="title mb20">
		{$aLang.plugin.admin.bans.title}
	</h2>

	<div class="top-controls mb-20 fl-r">
		<a class="button" href="{router page='admin/users/bans/add'}">Добавить бан</a>
	</div>

	<table class="table table-sorting">
		<thead>
			<tr>
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
					sCellClassName='block_type'
					sSortingOrder='block_type'
					sLinkHtml=$aLang.plugin.admin.bans.table_header.block_type
					sBaseUrl=$sFullPagePathToEvent
				}
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
					sCellClassName='user_id'
					sSortingOrder='user_id'
					sLinkHtml=$aLang.plugin.admin.bans.table_header.user_id
					sBaseUrl=$sFullPagePathToEvent
				}
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
					sCellClassName='ip'
					sSortingOrder='ip'
					sLinkHtml=$aLang.plugin.admin.bans.table_header.ip
					sBaseUrl=$sFullPagePathToEvent
				}
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
					sCellClassName='ip_start'
					sSortingOrder='ip_start'
					sLinkHtml=$aLang.plugin.admin.bans.table_header.ip_start
					sBaseUrl=$sFullPagePathToEvent
				}
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
					sCellClassName='ip_finish'
					sSortingOrder='ip_finish'
					sLinkHtml=$aLang.plugin.admin.bans.table_header.ip_finish
					sBaseUrl=$sFullPagePathToEvent
				}

				{* dates *}
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
					sCellClassName='time_type'
					sSortingOrder='time_type'
					sLinkHtml=$aLang.plugin.admin.bans.table_header.time_type
					sBaseUrl=$sFullPagePathToEvent
				}
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
					sCellClassName='date_start'
					sSortingOrder='date_start'
					sLinkHtml=$aLang.plugin.admin.bans.table_header.date_start
					sBaseUrl=$sFullPagePathToEvent
				}
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
					sCellClassName='date_finish'
					sSortingOrder='date_finish'
					sLinkHtml=$aLang.plugin.admin.bans.table_header.date_finish
					sBaseUrl=$sFullPagePathToEvent
				}

				{* create and edit dates *}
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
					sCellClassName='add_date'
					sSortingOrder='add_date'
					sLinkHtml=$aLang.plugin.admin.bans.table_header.add_date
					sBaseUrl=$sFullPagePathToEvent
				}
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
					sCellClassName='edit_date'
					sSortingOrder='edit_date'
					sLinkHtml=$aLang.plugin.admin.bans.table_header.edit_date
					sBaseUrl=$sFullPagePathToEvent
				}

				{* reason and comments *}
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
					sCellClassName='reason_for_user'
					sSortingOrder='reason_for_user'
					sLinkHtml=$aLang.plugin.admin.bans.table_header.reason_for_user
					sBaseUrl=$sFullPagePathToEvent
				}
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
					sCellClassName='comment'
					sSortingOrder='comment'
					sLinkHtml=$aLang.plugin.admin.bans.table_header.comment
					sBaseUrl=$sFullPagePathToEvent
				}
				<th class="controls"></th>
			</tr>
		</thead>

		<tbody>
			{foreach from=$aBans item=oBan name=BanCycle}
				{assign var="oSession" value=$oBan->getSession()}
				<tr class="{if $smarty.foreach.BanCycle.iteration % 2 == 0}second{/if}">
					<td class="block_type">
						{if $oBan->getBlockType()==PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_USER_ID}
							пользователь
						{elseif $oBan->getBlockType()==PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_IP}
							ip
						{elseif $oBan->getBlockType()==PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_IP_RANGE}
							диапазон ip
						{/if}
					</td>
					<td class="user_id">
						{if $oBan->getUserId()}
							<a href="{router page="admin/users/profile/{$oBan->getUserId()}"}">{$oBan->getUserId()}</a>
						{/if}
					</td>
					<td class="ip fS-10">
						{if $oBan->getIp()}
							<a href="{router page='admin/users/list'}{request_filter
							name=array('session_ip_last')
							value=array($oBan->getIp())
							}">{$oBan->getIp()}</a>
						{/if}
					</td>
					<td class="ip_start fS-10">
						{if $oBan->getIpStart()}
							<a href="{router page='admin/users/list'}{request_filter
							name=array('session_ip_last')
							value=array($oBan->getIpStart())
							}">{$oBan->getIpStart()}</a>
						{/if}
					</td>
					<td class="ip_finish fS-10">
						{if $oBan->getIpFinish()}
							<a href="{router page='admin/users/list'}{request_filter
							name=array('session_ip_last')
							value=array($oBan->getIpFinish())
							}">{$oBan->getIpFinish()}</a>
						{/if}
					</td>

					{* dates *}
					<td class="time_type">
						{if $oBan->getTimeType()==PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERMANENT}
							постоянный
						{elseif $oBan->getTimeType()==PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERIOD}
							период
						{/if}
					</td>
					<td class="date_start fS-10">
						{if $oBan->getTimeType()==PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERIOD}
							{$oBan->getDateStart()}
						{/if}
					</td>
					<td class="date_finish fS-10">
						{if $oBan->getTimeType()==PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERIOD}
							{$oBan->getDateFinish()}
						{/if}
					</td>

					{* create and edit dates *}
					<td class="add_date fS-10">
						{$oBan->getAddDate()}
					</td>
					<td class="edit_date fS-10">
						{$oBan->getEditDate()}
					</td>

					{* reason and comments *}
					<td class="reason_for_user fS-10">
						{$oBan->getReasonForUser()|escape:'html'|truncate:100:'...'}
					</td>
					<td class="comment fS-10">
						{$oBan->getComment()|escape:'html'|truncate:100:'...'}
					</td>

					<td class="controls">
						<a class="edit" href="#"><i class="icon-edit"></i></a>
						<a class="delete" href="#"><i class="icon-remove"></i></a>
					</td>
				</tr>
			{/foreach}
		</tbody>
	</table>


	<div class="OnPageSelect">
		<form action="{router page='admin/bans/ajax-on-page'}" method="post" enctype="application/x-www-form-urlencoded" id="admin_bans_onpage">
			<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
			{$aLang.plugin.admin.bans.on_page}
			<select name="onpage" class="width-50">
				{foreach from=range(5,100,5) item=iVal}
					<option value="{$iVal}" {if $iVal==$oConfig->GetValue('plugin.admin.bans.per_page')}selected="selected"{/if}>{$iVal}</option>
				{/foreach}
			</select>
		</form>
	</div>

	{include file="{$aTemplatePathPlugin.admin}/pagination.tpl" aPaging=$aPaging}
		
{/block}