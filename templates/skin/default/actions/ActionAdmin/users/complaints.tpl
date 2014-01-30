{**
 * Жалобы на пользователей
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}


{block name='layout_page_title'}
	{$aLang.plugin.admin.users.complaints.title} <span>({$iUsersComplaintsTotalCount})</span>
{/block}


{*{block name='layout_content_actionbar'}
	<div class="fl-r">
		*}{*
			статус
		*}{*
		{foreach array(null, ModuleUser::COMPLAINT_STATE_NEW, ModuleUser::COMPLAINT_STATE_READ) as $sState}
			<a href="{router page='admin/users/complaints'}{request_filter
				name=array('state')
				value=array($sState)
			}" class="button {if $sStateCurrent==$sState}active{/if}">{$aLang.plugin.admin.users.complaints.list.filter.state.$sState}</a>
		{/foreach}
	</div>
{/block}*}


{block name='layout_content'}
	{if $aUsersComplaints and count($aUsersComplaints)>0}
		<table class="table complaints">
			<thead>
				<tr>
					{*
						ид
					*}
					{include file="{$aTemplatePathPlugin.admin}forms/sorting_cell.tpl"
						sCellClassName='id'
						mSortingOrder='c.id'
						mLinkHtml=$aLang.plugin.admin.users.complaints.list.table_header.id
						sBaseUrl="{router page='admin/users/complaints'}"
					}
					{*
						на кого
					*}
					{include file="{$aTemplatePathPlugin.admin}forms/sorting_cell.tpl"
						sCellClassName='target_user_id'
						mSortingOrder='c.target_user_id'
						mLinkHtml=$aLang.plugin.admin.users.complaints.list.table_header.target_user_id
						sBaseUrl="{router page='admin/users/complaints'}"
					}
					{*
						от кого
					*}
					{include file="{$aTemplatePathPlugin.admin}forms/sorting_cell.tpl"
						sCellClassName='user_id'
						mSortingOrder='c.user_id'
						mLinkHtml=$aLang.plugin.admin.users.complaints.list.table_header.user_id
						sBaseUrl="{router page='admin/users/complaints'}"
					}
					{*
						тип
					*}
					{include file="{$aTemplatePathPlugin.admin}forms/sorting_cell.tpl"
						sCellClassName='type'
						mSortingOrder='c.type'
						mLinkHtml=$aLang.plugin.admin.users.complaints.list.table_header.type
						sBaseUrl="{router page='admin/users/complaints'}"
					}
					{*
						текст
					*}
					<th>{$aLang.plugin.admin.users.complaints.list.table_header.text}</th>

					{*
						дата создания
					*}
					{include file="{$aTemplatePathPlugin.admin}forms/sorting_cell.tpl"
						sCellClassName='date_add'
						mSortingOrder='c.date_add'
						mLinkHtml=$aLang.plugin.admin.users.complaints.list.table_header.date_add
						sBaseUrl="{router page='admin/users/complaints'}"
					}
					{*
						статус
					*}
					{include file="{$aTemplatePathPlugin.admin}forms/sorting_cell.tpl"
						sCellClassName='state'
						mSortingOrder='c.state'
						mLinkHtml=$aLang.plugin.admin.users.complaints.list.table_header.state
						sBaseUrl="{router page='admin/users/complaints'}"
					}
					<th class="width-50">
						{$aLang.plugin.admin.controls}
					</th>
				</tr>
			</thead>

			<tbody>
				{foreach from=$aUsersComplaints item=oComplaint}
					<tr class="{if $oComplaint@iteration % 2 == 0}second{/if} {if $oComplaint->getState()==ModuleUser::COMPLAINT_STATE_NEW}new{/if}">
						<td>
							{$oComplaint->getId()}
						</td>
						<td>
							{$oTargetUser = $oComplaint->getTargetUser()}
							<a href="{router page="admin/users/profile/{$oTargetUser->getId()}"}" class="link-border"
							   title="{$aLang.plugin.admin.users.list.table_header.login}"><span>{$oTargetUser->getLogin()}</span></a>
						</td>
						<td>
							{$oUserFrom = $oComplaint->getUser()}
							<a href="{router page="admin/users/profile/{$oUserFrom->getId()}"}" class="link-border"
							   title="{$aLang.plugin.admin.users.list.table_header.login}"><span>{$oUserFrom->getLogin()}</span></a>
						</td>
						<td>
							{$oComplaint->getTypeTitle()}
						</td>
						<td>
							<a href="#"
							   data-type="modal-toggle"
							   data-modal-url="{router page="admin/users/complaints/ajax-modal-view"}"
							   data-param-complaint_id="{$oComplaint->getId()}"
							   title="{$aLang.plugin.admin.show}">{$oComplaint->getText()|escape:'html'|truncate:20:'...'}</a>
						</td>
						<td>
							{date_format date=$oComplaint->getDateAdd() format="j.m.Y" notz=true}
						</td>
						<td>
							{$aLang.plugin.admin.users.complaints.list.state[$oComplaint->getState()]}
						</td>
						<td class="ta-r">
							<a href="#"
							   data-type="modal-toggle"
							   data-modal-url="{router page="admin/users/complaints/ajax-modal-view"}"
							   data-param-complaint_id="{$oComplaint->getId()}"
							   title="{$aLang.plugin.admin.show}"><i class="icon-list"></i></a>

							<a href="{router page="admin/users/complaints/delete/{$oComplaint->getId()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}" title="{$aLang.plugin.admin.delete}"
							   class="js-question"><i class="icon-remove"></i></a>
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>

		{include file="{$aTemplatePathPlugin.admin}forms/elements_on_page.tpl"
			sFormActionPath="{router page='admin/users/complaints/ajax-on-page'}"
			iCurrentValue = $oConfig->Get('plugin.admin.users.complaints.per_page')
		}

		{include file="{$aTemplatePathPlugin.admin}pagination.tpl" aPaging=$aPaging}

	{else}
		{include file='alert.tpl' mAlerts=$aLang.plugin.admin.users.complaints.list.empty sAlertStyle='empty'}
	{/if}
{/block}