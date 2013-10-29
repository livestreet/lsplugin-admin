{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content_actionbar'}
	<div class="fl-r">
		<a class="button {if $sBanSelectType=='all'}active{/if}"
		   href="{router page='admin/users/bans'}">{$aLang.plugin.admin.bans.filter.all}</a>
		<a class="button {if $sBanSelectType=='permanent'}active{/if}"
		   href="{router page='admin/users/bans/permanent'}">{$aLang.plugin.admin.bans.filter.permanent}</a>
		<a class="button {if $sBanSelectType=='period'}active{/if}"
		   href="{router page='admin/users/bans/period'}">{$aLang.plugin.admin.bans.filter.period}</a>
	</div>
	<a class="button button-primary" href="{router page='admin/users/bans/add'}">{$aLang.plugin.admin.bans.add_ban}</a>
{/block}


{block name='layout_page_title'}
	{$aLang.plugin.admin.bans.title} <span>{$iBansTotalCount}</span>
{/block}


{block name='layout_content'}
	<div class="mb-20">
		{$aLang.plugin.admin.bans.list.current_date_on_server}:
		<b>{date("Y-m-d H:i:s")}</b>
	</div>

	{if $aBans and count($aBans)>0}
		<table class="table">
			<thead>
				<tr>
					<th>
						#
					</th>
					{*
						правило бана
					*}
					{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
						sCellClassName='block_rule'
						mSortingOrder=array('block_type', 'user_id', 'ip', 'ip_start', 'ip_finish', 'add_date', 'edit_date')
						mLinkHtml=array(
							$aLang.plugin.admin.bans.table_header.block_type,
							$aLang.plugin.admin.bans.table_header.user_id,
							$aLang.plugin.admin.bans.table_header.ip,
							$aLang.plugin.admin.bans.table_header.ip_start,
							$aLang.plugin.admin.bans.table_header.ip_finish,
							$aLang.plugin.admin.bans.table_header.add_date,
							$aLang.plugin.admin.bans.table_header.edit_date
						)
						sDropDownHtml=$aLang.plugin.admin.bans.table_header.block_rule
						sBaseUrl=$sFullPagePathToEvent
					}
					{*include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
						sCellClassName='block_type'
						mSortingOrder='block_type'
						mLinkHtml=$aLang.plugin.admin.bans.table_header.block_type
						sBaseUrl=$sFullPagePathToEvent
					*}
					{*include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
						sCellClassName='user_id'
						mSortingOrder='user_id'
						mLinkHtml=$aLang.plugin.admin.bans.table_header.user_id
						sBaseUrl=$sFullPagePathToEvent
					*}
					{*include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
						sCellClassName='ip'
						mSortingOrder='ip'
						mLinkHtml=$aLang.plugin.admin.bans.table_header.ip
						sBaseUrl=$sFullPagePathToEvent
					*}
					{*include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
						sCellClassName='ip_start'
						mSortingOrder='ip_start'
						mLinkHtml=$aLang.plugin.admin.bans.table_header.ip_start
						sBaseUrl=$sFullPagePathToEvent
					*}
					{*include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
						sCellClassName='ip_finish'
						mSortingOrder='ip_finish'
						mLinkHtml=$aLang.plugin.admin.bans.table_header.ip_finish
						sBaseUrl=$sFullPagePathToEvent
					*}

					{*
						Тип временного интервала для бана и даты начала и конца
					*}
					{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
						sCellClassName='time_type'
						mSortingOrder='time_type'
						mLinkHtml=$aLang.plugin.admin.bans.table_header.time_type
						sBaseUrl=$sFullPagePathToEvent
					}
					{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
						sCellClassName='date_start'
						mSortingOrder='date_start'
						mLinkHtml=$aLang.plugin.admin.bans.table_header.date_start
						sBaseUrl=$sFullPagePathToEvent
					}
					{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
						sCellClassName='date_finish'
						mSortingOrder='date_finish'
						mLinkHtml=$aLang.plugin.admin.bans.table_header.date_finish
						sBaseUrl=$sFullPagePathToEvent
					}

					{*
						Дата создания и редактирования
					*}
					{*include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
						sCellClassName='add_date'
						mSortingOrder='add_date'
						mLinkHtml=$aLang.plugin.admin.bans.table_header.add_date
						sBaseUrl=$sFullPagePathToEvent
					*}
					{*include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
						sCellClassName='edit_date'
						mSortingOrder='edit_date'
						mLinkHtml=$aLang.plugin.admin.bans.table_header.edit_date
						sBaseUrl=$sFullPagePathToEvent
					*}

					{*
						Причина и комментарий для себя
					*}
					{*include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
						sCellClassName='reason_for_user'
						mSortingOrder='reason_for_user'
						mLinkHtml=$aLang.plugin.admin.bans.table_header.reason_for_user
						sBaseUrl=$sFullPagePathToEvent
					*}
					{*include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
						sCellClassName='comment'
						mSortingOrder='comment'
						mLinkHtml=$aLang.plugin.admin.bans.table_header.comment
						sBaseUrl=$sFullPagePathToEvent
					*}
					<th class="width-50">
						{$aLang.plugin.admin.controls}
					</th>
				</tr>
			</thead>

			<tbody>
				{foreach from=$aBans item=oBan name=BanCycle}
					{$oSession = $oBan->getSession()}
					
					<tr class="{if $smarty.foreach.BanCycle.iteration % 2 == 0}second{/if}">
						<td>
							<a href="{router page="admin/users/bans/view/{$oBan->getId()}"}">
								{$oBan->getId()}
							</a>
						</td>
						<td>
							{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/bans_block_type_description.tpl"}
						</td>
						{*<td>
							{if $oBan->getBlockType()==PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_USER_ID}
								{$aLang.plugin.admin.bans.list.block_type.user}
							{elseif $oBan->getBlockType()==PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_IP}
								{$aLang.plugin.admin.bans.list.block_type.ip}
							{elseif $oBan->getBlockType()==PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_IP_RANGE}
								{$aLang.plugin.admin.bans.list.block_type.ip_range}
							{/if}
						</td>*}
						{*<td>
							{if $oBan->getUserId()}
								<a href="{router page="admin/users/profile/{$oBan->getUserId()}"}">{$oBan->getUserId()}</a>
							{/if}
						</td>*}

						{* IPs *}
						{*<td>
							{if $oBan->getIp()}
								<a href="{router page='admin/users/list'}{request_filter
								name=array('session_ip_last')
								value=array(convert_long2ip($oBan->getIp()))
								}">{convert_long2ip($oBan->getIp())}</a>
							{/if}
						</td>*}
						{*<td>
							{if $oBan->getIpStart()}
								<a href="{router page='admin/users/list'}{request_filter
								name=array('session_ip_last')
								value=array(convert_long2ip($oBan->getIpStart()))
								}">{convert_long2ip($oBan->getIpStart())}</a>
							{/if}
						</td>*}
						{*<td>
							{if $oBan->getIpFinish()}
								<a href="{router page='admin/users/list'}{request_filter
								name=array('session_ip_last')
								value=array(convert_long2ip($oBan->getIpFinish()))
								}">{convert_long2ip($oBan->getIpFinish())}</a>
							{/if}
						</td>*}

						{* dates *}
						<td>
							{if $oBan->getTimeType()==PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERMANENT}
								{$aLang.plugin.admin.bans.list.time_type.permanent}
							{elseif $oBan->getTimeType()==PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERIOD}
								{$aLang.plugin.admin.bans.list.time_type.period}
							{/if}
						</td>
						<td>
							{if $oBan->getTimeType()==PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERIOD}
								{$oBan->getDateStart()}
							{else}
								&mdash;
							{/if}
						</td>
						<td>
							{if $oBan->getTimeType()==PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERIOD}
								{$oBan->getDateFinish()}
							{else}
								&mdash;
							{/if}
						</td>

						{* create and edit dates *}
						{*<td>
							{$oBan->getAddDate()}
						</td>
						<td>
							{$oBan->getEditDate()}
						</td>*}

						{* reason and comments *}
						{*<td>
							{$oBan->getReasonForUser()|escape:'html'|truncate:100:'...'}
						</td>
						<td>
							{$oBan->getComment()|escape:'html'|truncate:100:'...'}
						</td>*}

						<td class="ta-r">
							{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/bans_controls.tpl"}
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
		
		{include file="{$aTemplatePathPlugin.admin}forms/elements_on_page.tpl"
			sFormActionPath="{router page='admin/bans/ajax-on-page'}"
			iCurrentValue = $oConfig->GetValue('plugin.admin.bans.per_page')
		}

		{include file="{$aTemplatePathPlugin.admin}pagination.tpl" aPaging=$aPaging}
	{else}
		{include file='alert.tpl' mAlerts=$aLang.plugin.admin.bans.list.no_bans sAlertStyle='empty'}
	{/if}
{/block}