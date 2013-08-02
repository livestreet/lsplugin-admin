{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}
    <h2 class="title mb20">
		{$aLang.plugin.admin.users.title}
    </h2>

	<div class="UserSearch">
		<form action="{router page='admin'}users/list/" method="post" enctype="application/x-www-form-urlencoded">
			<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
			<input type="text" name="q" class="input-text width-200" value="{$sSearchQuery}" />
			<select name="field" class="width-150">
				{foreach from=$oConfig->GetValue('plugin.admin.user_search_allowed_types') item=sSearchIn}
					<option value="{$sSearchIn}" {if $sSearchIn==$sSearchField}selected="selected"{/if}>{$aLang.plugin.admin.users.search_allowed_in.$sSearchIn}</option>
				{/foreach}
			</select>
			<select name="type" class="width-150">
				{foreach from=array('exact', 'prefix', 'postfix', 'any') item=sType}
					<option value="{$sType}" {if $sType==$sSearchType}selected="selected"{/if}>{$aLang.plugin.admin.users.exact_search.$sType}</option>
				{/foreach}
			</select>
			<input type="submit" name="submit_search" value="{$aLang.plugin.admin.users.search}" class="button button-primary" />
		</form>
	</div>

	{assign var=sDirectionHtml value="<span class=\"current-way\">{if $sWay=='asc'}&uarr;{elseif $sWay=='desc'}&darr;{/if}</span>"}
    <table class="table table-users">
        <thead>
            <tr>
				<th class="checked">
					<input type="checkbox" name="checked[]" value="1" />
					<span class="checking-menu">
						&darr;
					</span>
				</th>
				<th class="avatar"></th>
				<th class="name {if $sOrder=='u.user_login'}active{/if}">
					<a href="?order=u.user_login&way={$sReverseOrder}">name</a>
					{$sDirectionHtml}
				</th>
				<th class="birth {if $sOrder=='u.user_profile_birthday'}active{/if}">
					<a href="?order=u.user_profile_birthday&way={$sReverseOrder}">birth</a>
					{$sDirectionHtml}
				</th>
				<th class="visitandreg {if $sOrder=='s.session_date_last'}active{/if}">
					<a href="?order=s.session_date_last&way={$sReverseOrder}">visit and reg</a>
					{$sDirectionHtml}
				</th>
				<th class="ips {if $sOrder=='s.session_ip_last'}active{/if}">
					<a href="?order=s.session_ip_last&way={$sReverseOrder}">IPs</a>
					{$sDirectionHtml}
				</th>
				<th class="rating {if $sOrder=='u.user_rating'}active{/if}">
					<a href="?order=u.user_rating&way={$sReverseOrder}">rating, skill</a>
					{$sDirectionHtml}
				</th>
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
						<a href="{$oUser->getUserWebPath()}"><img src="{$oUser->getProfileAvatarPath(48)}" alt="avatar" class="avatar" /></a>
						{if $oUser->isOnline()}
							<div class="user-is-online"></div>
						{/if}
					</td>
        			<td class="name">
        				<div class="name {if !$oUser->getProfileName()}no-realname{/if}">
        					<p class="username word-wrap">
								<a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a>
							</p>
        					{if $oUser->getProfileName()}
								<p class="realname">{$oUser->getProfileName()}</p>
							{/if}
							<p class="mail">
								{$oUser->getMail()}
							</p>
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
							<p title="sess ip create">{$oSession->getIpCreate()}</p>
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
						<p></p>
					</td>
        		</tr>
        	{/foreach}
        </tbody>
    </table>

	<div class="OnPageSelect">
		<form action="{router page='admin'}users/ajax-on-page/" method="post" enctype="application/x-www-form-urlencoded" id="admin_onpage">
			<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
			{$aLang.plugin.admin.users.on_page}
			<select name="onpage" class="width-50">
				{foreach from=range(5,100,5) item=iVal}
					<option value="{$iVal}" {if $iVal==$oConfig->GetValue('plugin.admin.user.per_page')}selected="selected"{/if}>{$iVal}</option>
				{/foreach}
			</select>
		</form>
	</div>

    {include file="{$aTemplatePathPlugin.admin}/pagination.tpl" aPaging=$aPaging}
    
{/block}