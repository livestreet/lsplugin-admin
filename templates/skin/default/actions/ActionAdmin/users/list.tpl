{**
 * Список пользователей
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}


{block name='layout_content_actionbar'}
	<form action="{$sFullPagePathToEvent}" method="get" enctype="application/x-www-form-urlencoded" id="js-admin-users-list-search-form-id">
		{*
			нужна только первая пара ключ => значение
		*}
		{$sSearchValueItems=array_values($aSearchRulesWithOriginalQueries)}
		{$sSearchFieldItems=array_keys($aSearchRulesWithOriginalQueries)}
		{$sSearchValue = array_shift($sSearchValueItems)}
		{$sSearchField = array_shift($sSearchFieldItems)}

		<script>
			var aAdminUsersSearchRules = {json var=$oConfig->Get('plugin.admin.users.search_allowed_types')};
		</script>

		<span id="js-admin-users-list-search-form-q-wrapper">
			<input type="text" class="width-200" value="{$sSearchValue}" placeholder="{$aLang.plugin.admin.users.search}" />
		</span>

		<select class="width-200" id="js-admin-users-list-search-form-field-name">
			{foreach array_keys($oConfig->Get('plugin.admin.users.search_allowed_types')) as $sSearchIn}
				<option value="{$sSearchIn}" {if $sSearchIn == $sSearchField}selected="selected"{/if}>
					{$aLang.plugin.admin.users.search_allowed_in.$sSearchIn}
				</option>
			{/foreach}
		</select>

		{**
		 * Кнопка отключения фильтра поиска
		 *}
		{if $sSearchField}
			<a href="{$sFullPagePathToEvent}{request_filter
				name=array($sSearchField)
				value=array(null)
			}" class="button button-icon"><i class="icon-remove"></i></a>
		{/if}

		<button type="submit" class="button button-primary">{$aLang.plugin.admin.users.search}</button>
	</form>
{/block}


{block name='layout_page_title'}
	{$aLang.plugin.admin.users.title} <span>({$iUsersTotalCount})</span>
{/block}


{block name='layout_content'}
	<table class="table table-users">
		<thead>
			<tr>
				<th class="cell-check">
					<input type="checkbox" class="js-check-all" data-checkboxes-class="js-user-list-item" />
				</th>
				{include file="{$aTemplatePathPlugin.admin}forms/sorting_cell.tpl"
					sCellClassName='user'
					mSortingOrder=array('u.user_id', 'u.user_login', 'u.user_profile_name', 'u.user_mail')
					mLinkHtml=array(
						$aLang.plugin.admin.users.table_header.id,
						$aLang.plugin.admin.users.table_header.login,
						$aLang.plugin.admin.users.table_header.profile_name,
						$aLang.plugin.admin.users.table_header.mail
					)
					sDropDownHtml=$aLang.plugin.admin.users.table_header.name
					sBaseUrl=$sFullPagePathToEvent
				}
				{include file="{$aTemplatePathPlugin.admin}forms/sorting_cell.tpl"
					sCellClassName='birth'
					mSortingOrder='u.user_profile_birthday'
					mLinkHtml=$aLang.plugin.admin.users.table_header.birth
					sBaseUrl=$sFullPagePathToEvent
				}
				{include file="{$aTemplatePathPlugin.admin}forms/sorting_cell.tpl"
					sCellClassName='signup'
					mSortingOrder=array('u.user_date_register', 's.session_date_last')
					mLinkHtml=array($aLang.plugin.admin.users.table_header.reg, $aLang.plugin.admin.users.table_header.last_visit)
					sDropDownHtml=$aLang.plugin.admin.users.table_header.reg_and_last_visit
					sBaseUrl=$sFullPagePathToEvent
				}
				{include file="{$aTemplatePathPlugin.admin}forms/sorting_cell.tpl"
					sCellClassName='ip'
					mSortingOrder=array('u.user_ip_register', 's.session_ip_last')
					mLinkHtml=array($aLang.plugin.admin.users.table_header.user_ip_register, $aLang.plugin.admin.users.table_header.session_ip_last)
					sDropDownHtml=$aLang.plugin.admin.users.table_header.ip
					sBaseUrl=$sFullPagePathToEvent
				}
				{include file="{$aTemplatePathPlugin.admin}forms/sorting_cell.tpl"
					sCellClassName='rating'
					mSortingOrder=array('u.user_rating', 'u.user_skill')
					mLinkHtml=array($aLang.plugin.admin.users.table_header.user_rating, $aLang.plugin.admin.users.table_header.user_skill)
					sDropDownHtml=$aLang.plugin.admin.users.table_header.rating_and_skill
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

					{*
						Пользователь
					*}
					<td class="cell-user">
						<div class="cell-user-wrapper">
							<a href="{router page="admin/users/profile/{$oUser->getId()}"}" class="cell-user-avatar {if $oUser->isOnline()}user-is-online{/if}">
								<img src="{$oUser->getProfileAvatarPath(48)}" 
									 alt="avatar" 
									 title="{if $oUser->isOnline()}{$aLang.user_status_online}{else}{$aLang.user_status_offline}{/if}" />
							</a>

							<p class="cell-user-login word-wrap">
								<a href="{router page="admin/users/profile/{$oUser->getId()}"}" class="link-border"
								   title="{$aLang.plugin.admin.users.table_header.login}"><span>{$oUser->getLogin()}</span></a>

								{if $oUser->isAdministrator()}
									<i class="icon-user-admin" title="{$aLang.plugin.admin.users.admin}"></i>
								{/if}

								{if $oBan = $oUser->getBannedCached()}
									<a href="{$oBan->getBanViewUrl()}"><i class="icon-lock" title="{$aLang.plugin.admin.users.banned}"></i></a>
								{/if}
							</p>

							{if $oUser->getProfileName()}
								<p class="cell-user-name" title="{$aLang.plugin.admin.users.table_header.profile_name}">{$oUser->getProfileName()}</p>
							{/if}

							<p class="cell-user-mail" title="{$aLang.plugin.admin.users.table_header.mail}">{$oUser->getMail()}</p>
						</div>
					</td>

					{*
						Дата рождения
					*}
					<td class="cell-birth">
						{if $oUser->getProfileBirthday()}
							{date_format date=$oUser->getProfileBirthday() format="j.m.Y" notz=true}
						{else}
							&mdash;
						{/if}
					</td>

					{*
						Дата регистрации и дата последнего входа
					*}
					<td class="cell-signup">
						<p title="{$aLang.plugin.admin.users.table_header.reg}">
							{date_format date=$oUser->getDateRegister() format="d.m.Y"},
							<span>{date_format date=$oUser->getDateRegister() format="H:i"}</span>
						</p>

						{if $oSession}
							<p title="{$aLang.plugin.admin.users.table_header.last_visit}">
								{date_format date=$oSession->getDateLast() format="d.m.Y"},
								<span>{date_format date=$oSession->getDateLast() format="H:i"}</span>
							</p>
						{/if}
					</td>

					{*
						IP
					*}
					<td class="cell-ip">
						<p title="{$aLang.plugin.admin.users.table_header.user_ip_register}">
							<a href="{router page='admin/users/list'}{request_filter
								name=array('ip_register')
								value=array($oUser->getIpRegister())
							}">{$oUser->getIpRegister()}</a>
						</p>
						{if $oSession}
							{* <p title="sess ip create">{$oSession->getIpCreate()}</p> *}
							<p title="{$aLang.plugin.admin.users.table_header.session_ip_last}">
								<a href="{router page='admin/users/list'}{request_filter
									name=array('session_ip_last')
									value=array($oSession->getIpLast())
								}" title="{$aLang.plugin.admin.users.profile.info.search_this_ip}">{$oSession->getIpLast()}</a>
							</p>
						{/if}
					</td>

					{*
						Рейтинг и сила
					*}
					<td class="cell-rating">
						<div class="dropdown-circle js-dropdown" data-dropdown-target="dropdown-user-menu-{$oUser->getId()}"></div>

						<ul class="dropdown-menu" id="dropdown-user-menu-{$oUser->getId()}">
							{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/user_actions.tpl"}
						</ul>

						<p class="user-rating {if $oUser->getRating() < 0}user-rating-negative{/if}" title="{$aLang.plugin.admin.users.table_header.user_rating}">
							{$oUser->getRating()}
						</p>
						<p class="user-skill" title="{$aLang.plugin.admin.users.table_header.user_skill}">
							{$oUser->getSkill()}
						</p>
					</td>
				</tr>
			{/foreach}
		</tbody>
	</table>

	{include file="{$aTemplatePathPlugin.admin}forms/elements_on_page.tpl"
		sFormActionPath="{router page='admin/users/ajax-on-page'}"
		iCurrentValue = $oConfig->Get('plugin.admin.user.per_page')
	}

	{include file="{$aTemplatePathPlugin.admin}pagination.tpl" aPaging=$aPaging}
{/block}