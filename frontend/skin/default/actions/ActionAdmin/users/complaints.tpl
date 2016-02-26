{**
 * Жалобы на пользователей
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_page_title'}
	{$aLang.plugin.admin.users.complaints.title} <span>({$iUsersComplaintsTotalCount})</span>
{/block}

{*{block 'layout_content_actionbar'}
	<div class="ls-fl-r">
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

{block 'layout_content'}
    {component 'admin:p-user' template='report-list' reports=$aUsersComplaints pagination=$aPaging}
{/block}