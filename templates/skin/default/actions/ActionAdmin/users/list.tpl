{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}
	<h2 class="title mb20">
		{$aLang.plugin.admin.users.title}
	</h2>

	<div class="UserSearch">
		<form action="{$sFullPagePathToEvent}" method="get" enctype="application/x-www-form-urlencoded" id="admin_user_list_search_form">
			{assign var=sSearchValue value=array_shift(array_values($aSearchRulesWithOriginalQueries))}			{* need only first field=>value *}
			{assign var=sSearchField value=array_shift(array_keys($aSearchRulesWithOriginalQueries))}

			<input type="text" class="input-text width-200" value="{$sSearchValue}" id="admin_user_list_search_form_q" />
			<select class="width-150" id="admin_user_list_search_form_field" >
				{foreach from=array_keys($oConfig->GetValue('plugin.admin.user_search_allowed_types')) item=sSearchIn}
					<option value="{$sSearchIn}" {if $sSearchIn==$sSearchField}selected="selected"{/if}>
						{$aLang.plugin.admin.users.search_allowed_in.$sSearchIn}
					</option>
				{/foreach}
			</select>
			<input type="submit" value="{$aLang.plugin.admin.users.search}" class="button button-primary" />
		</form>
	</div>


	<table class="table table-sorting">
		<thead>
			<tr>
				<th class="checked">
					<label>
						<input type="checkbox" name="checked[]" value="1" />
						&darr;																			{* todo: select menu *}
					</label>
				</th>
				<th class="avatar"></th>
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
					sCellClassName='name'
					sSortingOrder='u.user_login'
					sLinkHtml=$aLang.plugin.admin.users.table_header.name
					sBaseUrl=$sFullPagePathToEvent
				}
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
					sCellClassName='birth'
					sSortingOrder='u.user_profile_birthday'
					sLinkHtml=$aLang.plugin.admin.users.table_header.birth
					sBaseUrl=$sFullPagePathToEvent
				}
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
					sCellClassName='visitandreg'
					sSortingOrder='s.session_date_last'
					sLinkHtml=$aLang.plugin.admin.users.table_header.reg_and_last_visit
					sBaseUrl=$sFullPagePathToEvent
				}
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
					sCellClassName='ips'
					sSortingOrder='s.session_ip_last'
					sLinkHtml=$aLang.plugin.admin.users.table_header.ip
					sBaseUrl=$sFullPagePathToEvent
				}
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
					sCellClassName='rating'
					sSortingOrder='u.user_rating'
					sLinkHtml=$aLang.plugin.admin.users.table_header.rating_and_skill
					sBaseUrl=$sFullPagePathToEvent
				}
				<th class="controls"></th>
			</tr>
		</thead>

		<tbody>
			{foreach from=$aUsers item=oUser name=UserCycle}
				{assign var="oSession" value=$oUser->getSession()}
				<tr class="{if $smarty.foreach.UserCycle.iteration % 2 == 0}second{/if}">
					<td class="checked">
						<input type="checkbox" name="checked[]" value="1" />
					</td>
					<td class="avatar">
						<a href="{router page="admin/users/profile/{$oUser->getId()}"}"><img src="{$oUser->getProfileAvatarPath(48)}" alt="avatar" class="avatar" /></a>
						{if $oUser->isOnline()}
							<div class="user-is-online"
								 title="{if $oUser->isOnline()}{$aLang.user_status_online}{else}{$aLang.user_status_offline}{/if}"></div>
						{/if}
					</td>
					<td class="name">
						<div class="name {if !$oUser->getProfileName()}no-realname{/if}">
							<p class="username word-wrap">
								<a href="{router page="admin/users/profile/{$oUser->getId()}"}">{$oUser->getLogin()}</a>
								{if $oUser->isAdministrator()}
									<i class="icon-user" title="Admin"></i>
								{/if}
							</p>
							{if $oUser->getProfileName()}
								<p class="realname">{$oUser->getProfileName()}</p>
							{/if}
							<p class="mail">{$oUser->getMail()}</p>
						</div>
					</td>
					<td class="birth">
						{if $oUser->getProfileBirthday()}
							{date_format date=$oUser->getProfileBirthday() format="j.m.Y" notz=true}
						{/if}
					</td>
					<td class="visitandreg">
						<p title="reg date">
							{date_format date=$oUser->getDateRegister() format="d.m.Y"},
							<span>{date_format date=$oUser->getDateRegister() format="H:i"}</span>
						</p>
						{if $oSession}
							<p title="date last">
								{date_format date=$oSession->getDateLast() format="d.m.Y"},
								<span>{date_format date=$oSession->getDateLast() format="H:i"}</span>
							</p>
						{/if}
					</td>
					<td class="ips">
						<p title="reg ip">{$oUser->getIpRegister()}</p>
						{if $oSession}
							{* <p title="sess ip create">{$oSession->getIpCreate()}</p> *}
							<p title="sess ip last">{$oSession->getIpLast()}</p>
						{/if}
					</td>
					<td class="ratings">
						<p class="rating {if $oUser->getRating() < 0}negative{/if}">
							{$oUser->getRating()}
						</p>
						<p class="skill">
							{$oUser->getSkill()}
						</p>
					</td>
					<td class="controls">
						{* <p></p>  TODO *}
					</td>
				</tr>
			{/foreach}
		</tbody>
	</table>

	{include file="{$aTemplatePathPlugin.admin}/forms/elements_on_page.tpl"
		sFormActionPath="{router page='admin/users/ajax-on-page'}"
		sFormId = 'admin_onpage'
		iCurrentValue = $oConfig->GetValue('plugin.admin.user.per_page')
	}

	{include file="{$aTemplatePathPlugin.admin}/pagination.tpl" aPaging=$aPaging}
		
{/block}