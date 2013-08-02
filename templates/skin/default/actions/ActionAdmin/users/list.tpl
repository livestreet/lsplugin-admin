{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}
    <h2 class="title mb20">
		{$aLang.plugin.admin.users.title}
    </h2>

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
				<th class="visitandreg">
					visit and reg
					{$sDirectionHtml}
				</th>
				<th class="ips">
					IPs
					{$sDirectionHtml}
				</th>
				<th class="rating">
					rating and skill
					{$sDirectionHtml}
				</th>
				<th class="controls"></th>
				
				{*
                <th class="name tab">
                    <div class="tab-inner {if $sUsersOrder=='user_login'}active{/if}"><a href="{$sUsersRootPage}?order=user_login&order_way={if $sUsersOrder=='user_login'}{$sUsersOrderWayNext}{else}{$sUsersOrderWay}{/if}" {if $sUsersOrder=='user_login'}class="{$sUsersOrderWay}"{/if}><span>{$aLang.user}</span></a></div>
                </th>
                <th class="skill tab">
                    <div class="tab-inner {if $sUsersOrder=='user_skill'}active{/if}"><a href="{$sUsersRootPage}?order=user_skill&order_way={if $sUsersOrder=='user_skill'}{$sUsersOrderWayNext}{else}{$sUsersOrderWay}{/if}" {if $sUsersOrder=='user_skill'}class="{$sUsersOrderWay}"{/if}><span>{$aLang.user_skill}</span></a></div>
                </th>
                <th class="rating tab">
                    <div class="tab-inner {if $sUsersOrder=='user_rating'}active{/if}"><a href="{$sUsersRootPage}?order=user_rating&order_way={if $sUsersOrder=='user_rating'}{$sUsersOrderWayNext}{else}{$sUsersOrderWay}{/if}" {if $sUsersOrder=='user_rating'}class="{$sUsersOrderWay}"{/if}><span>{$aLang.user_rating}</span></a></div>
                </th>
				*}
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

    {include file="{$aTemplatePathPlugin.admin}/pagination.tpl" aPaging=$aPaging}
    
{/block}