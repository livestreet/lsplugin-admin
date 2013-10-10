{extends file="{$aTemplatePathPlugin.admin}/layouts/layout.base.tpl"}


{block name='layout_content_toolbar'}
	<form action="{$sFullPagePathToEvent}" method="get" enctype="application/x-www-form-urlencoded" id="admin_user_list_search_form">
		{$sSearchValue = array_shift(array_values($aSearchRulesWithOriginalQueries))}			{* need only first field=>value *}
		{$sSearchField = array_shift(array_keys($aSearchRulesWithOriginalQueries))}

		<input type="text" class="width-200" value="{$sSearchValue}" id="admin_user_list_search_form_q" placeholder="{$aLang.plugin.admin.users.search}" />

		<select class="width-150" id="admin_user_list_search_form_field">
			{foreach array_keys($oConfig->GetValue('plugin.admin.user_search_allowed_types')) as $sSearchIn}
				<option value="{$sSearchIn}" {if $sSearchIn == $sSearchField}selected="selected"{/if}>
					{$aLang.plugin.admin.users.search_allowed_in.$sSearchIn}
				</option>
			{/foreach}
		</select>

		<button type="submit" class="button button-primary">{$aLang.plugin.admin.users.search}</button>
	</form>
{/block}


{block name='layout_page_title'}
	{$aLang.plugin.admin.users.title} <span>{$iUsersTotalCount}</span>
{/block}


{block name='layout_content'}
	<table class="table table-users">
		<thead>
			<tr>
				<th class="cell-check">
					<input type="checkbox" class="js-check-all" data-checkboxes-class="js-user-list-item" />
				</th>
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
					sCellClassName='user'
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
					sCellClassName='signup'
					sSortingOrder='s.session_date_last'
					sLinkHtml=$aLang.plugin.admin.users.table_header.reg_and_last_visit
					sBaseUrl=$sFullPagePathToEvent
				}
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/sorting_cell.tpl"
					sCellClassName='ip'
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
			</tr>
		</thead>

		<tbody>
			{foreach from=$aUsers item=oUser name=UserCycle}
				{assign var="oSession" value=$oUser->getSession()}

				<tr class="{if $smarty.foreach.UserCycle.iteration % 2 == 0}second{/if}">
					<td class="cell-check">
						<input type="checkbox" name="checked[]" class="js-user-list-item" value="1" />
					</td>

					{* Пользователь *}
					<td class="cell-user">
						<div class="cell-user-wrapper {if $oUser->isOnline()}user-is-online{/if}">
							<a href="{router page="admin/users/profile/{$oUser->getId()}"}" class="cell-user-avatar">
								<img src="{$oUser->getProfileAvatarPath(48)}" 
									 alt="avatar" 
									 title="{if $oUser->isOnline()}{$aLang.user_status_online}{else}{$aLang.user_status_offline}{/if}" />
							</a>

							<p class="cell-user-login word-wrap">
								<a href="{router page="admin/users/profile/{$oUser->getId()}"}" class="link-border"><span>{$oUser->getLogin()}</span></a>

								{if $oUser->isAdministrator()}
									<i class="icon-user-admin" title="Admin"></i>
								{/if}
							</p>

							{if $oUser->getProfileName()}
								<p class="cell-user-name">{$oUser->getProfileName()}</p>
							{/if}

							<p class="cell-user-mail">{$oUser->getMail()}</p>
						</div>
					</td>

					{* Дата рождения *}
					<td class="cell-birth">
						{if $oUser->getProfileBirthday()}
							{date_format date=$oUser->getProfileBirthday() format="j.m.Y" notz=true}
						{else}
							&mdash;
						{/if}
					</td>

					{* Дата регистрации и дата последнего входа *}
					<td class="cell-signup">
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

					{* IP *}
					<td class="cell-ip">
						<p title="reg ip">{$oUser->getIpRegister()}</p>
						{if $oSession}
							{* <p title="sess ip create">{$oSession->getIpCreate()}</p> *}
							<p title="sess ip last">{$oSession->getIpLast()}</p>
						{/if}
					</td>

					{* Рейтинг *}
					<td class="cell-rating">
						<p class="user-rating {if $oUser->getRating() < 0}user-rating-negative{/if}">
							{$oUser->getRating()}
						</p>

						<div class="dropdown-circle js-dropdown" data-dropdown-target="dropdown-user-menu-{$oUser->getId()}"></div>

						<ul class="dropdown-menu" id="dropdown-user-menu-{$oUser->getId()}">
							<li><a href="#">Item</a></li>
							<li><a href="#">Item</a></li>
							<li><a href="#">Item</a></li>
						</ul>
					</td>
				</tr>
			{/foreach}
		</tbody>
	</table>

	{*
	{include file="{$aTemplatePathPlugin.admin}/forms/elements_on_page.tpl"
		sFormActionPath="{router page='admin/users/ajax-on-page'}"
		sFormId = 'admin_onpage'
		iCurrentValue = $oConfig->GetValue('plugin.admin.user.per_page')
	}
	*}

	{include file="{$aTemplatePathPlugin.admin}/pagination.tpl" aPaging=$aPaging}
{/block}