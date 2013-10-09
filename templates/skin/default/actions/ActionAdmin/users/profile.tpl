{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}
	{assign var="oSession" value=$oUser->getSession()}
	<div class="profile-info-wrapper">
		<div class="top-controls">
			<ul>
				<li><a class="icon-white icon-pencil" href="#"></a></li>
				<li><a href="{router page='talk/add'}?talk_users={$oUser->getLogin()}">{$aLang.plugin.admin.users.profile.top_bar.msg}</a></li>

				{* разрешить операция для всех пользователей, кроме самого первого в системе с id = 1 *}
				{if $oUser->getId()!=1}
					{if $oUser->isAdministrator()}
						<li><a class="question" href="{router page="admin/users/site_admins/delete/{$oUser->getId()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
									>{$aLang.plugin.admin.users.profile.top_bar.admin_delete}</a></li>
					{else}
						<li><a class="question" href="{router page="admin/users/site_admins/add/{$oUser->getId()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
									>{$aLang.plugin.admin.users.profile.top_bar.admin_add}</a></li>
					{/if}
					<li><a class="question" href="{router page="admin/users/deletecontent/{$oUser->getId()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
								>{$aLang.plugin.admin.users.profile.top_bar.content_delete}</a></li>
					<li><a class="question" href="{router page="admin/users/deleteuser/{$oUser->getId()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
								>{$aLang.plugin.admin.users.profile.top_bar.user_delete}</a></li>
					<li><a href="{router page='admin/users/bans/add'}?user_id={$oUser->getId()}">{$aLang.plugin.admin.users.profile.top_bar.ban}</a></li>
				{/if}

				<li class="fl-r"><a class="icon-white icon-chevron-right" href="#"></a></li>
				<li class="fl-r"><a class="icon-white icon-chevron-left" href="#"></a></li>
				<li class="fl-r"><a class="icon-white icon-backward" href="#"></a></li>
			</ul>
		</div>
		<div class="inner-data">
			<ul class="profile-links">
				<li><a class="profile" href="{$oUser->getUserWebPath()}">{$aLang.plugin.admin.users.profile.middle_bar.profile}</a></li>
				<li><a class="publications" href="{$oUser->getUserWebPath()}created/">{$aLang.plugin.admin.users.profile.middle_bar.publications}</a></li>
				<li><a class="activity" href="{$oUser->getUserWebPath()}stream/">{$aLang.plugin.admin.users.profile.middle_bar.activity}</a></li>
				<li><a class="friends" href="{$oUser->getUserWebPath()}friends/">{$aLang.plugin.admin.users.profile.middle_bar.friends}</a></li>
				{*<li><a class="claims" href="#">Жалобы</a></li>*}
				{*<li><a class="money" href="#">Счет</a></li>*}
				<li><a class="wall" href="{$oUser->getUserWebPath()}wall/">{$aLang.plugin.admin.users.profile.middle_bar.wall}</a></li>
				{*<li><a class="blogs" href="#">Блоги</a></li>*}
				<li><a class="favorite" href="{$oUser->getUserWebPath()}favourites/">{$aLang.plugin.admin.users.profile.middle_bar.fav}</a></li>
				{*<li><a class="talk" href="#">Почта</a></li>*}
				{*<li><a class="roles" href="#">Права</a></li>*}
			</ul>
			<div class="line"></div>
			<div class="base-info">
				<div class="left">
					<div class="avatar-wrapper">
						<a href="{$oUser->getUserWebPath()}"><img src="{$oUser->getProfileAvatarPath(100)}" alt="" class="avatar" /></a>
						{if $oUser->isOnline()}
							<div class="user-is-online" title="{if $oUser->isOnline()}{$aLang.user_status_online}{else}{$aLang.user_status_offline}{/if}"></div>
						{/if}
					</div>
					<div class="names {if !$oUser->getProfileName()}no-realname{/if}">
						<p class="username word-wrap">
							<a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a>
							{if $oUser->isAdministrator()}
								<i class="icon-user-admin" title="Admin"></i>
							{/if}
						</p>
						{if $oUser->getProfileName()}
							<p class="realname">{$oUser->getProfileName()}</p>
						{/if}
						<p class="mail">
							{$oUser->getMail()}
						</p>
					</div>
				</div>
				<div class="right">
					<form action="{router page='admin/users/ajax-edit-rating'}" method="post" enctype="application/x-www-form-urlencoded" id="admin_editrating">
						<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
						<input type="hidden" name="user_id" value="{$oUser->getId()}" />
						<div class="skill">
							{$aLang.plugin.admin.users.profile.skill}
							<input type="text" name="user-skill" class="input-text width-50" value="{$oUser->getSkill()}" />
						</div>
						<div class="rating">
							{$aLang.plugin.admin.users.profile.rating}
							<input type="text" name="user-rating" class="input-text width-50" value="{$oUser->getRating()}" />
						</div>
						<input type="submit" value="{$aLang.plugin.admin.users.profile.edit_user_rating}" name="submit_edit_rating" class="button button-primary" />
					</form>
					<div class="user-id">
						{$aLang.plugin.admin.users.profile.user_no} {$oUser->getId()}
					</div>
				</div>
			</div>
			<div class="more-info">
				<div class="right-data">
					<div class="photo-wrapper">
						<a href="{$oUser->getUserWebPath()}"><img src="{$oUser->getProfileFotoPath()}" alt="" class="photo" /></a>
					</div>
					<div class="your-note">
						{include file="blocks/block.userNote.tpl" oUserProfile=$oUser oUserNote=$oUser->getUserNote()}
					</div>
				</div>
				<div class="left-data">
					<h2 class="title mb-20">
						{$aLang.plugin.admin.users.profile.info.resume}
					</h2>
					<div class="resume">
						<dl>
							<dt>{$aLang.plugin.admin.users.profile.info.mail}</dt>
							<dd>
								<a href="{router page='admin/users/list'}{request_filter
								name=array('mail')
								value=array($oUser->getMail())
								}">{$oUser->getMail()}</a>
							</dd>
						</dl>
						{if $oUser->getProfileSex() != 'other'}
							<dl>
								<dt>{$aLang.plugin.admin.users.profile.info.sex}</dt>
								<dd>
									{if $oUser->getProfileSex() == 'man'}
										{$aLang.profile_sex_man}
									{else}
										{$aLang.profile_sex_woman}
									{/if}
								</dd>
							</dl>
						{/if}
						{if $oUser->getProfileBirthday()}
							<dl>
								<dt>{$aLang.plugin.admin.users.profile.info.birthday}</dt>
								<dd>{date_format date=$oUser->getProfileBirthday() format="j F Y" notz=true}</dd>
							</dl>
						{/if}

						{if $oGeoTarget}
							<dl>
								<dt>{$aLang.plugin.admin.users.profile.info.living}</dt>
								<dd>
									{if $oGeoTarget->getCountryId()}
										<a href="{router page='people/country'}{$oGeoTarget->getCountryId()}/">{$oUser->getProfileCountry()|escape:'html'}</a>{if $oGeoTarget->getCityId()},{/if}
									{/if}

									{if $oGeoTarget->getCityId()}
										<a href="{router page='people/city'}{$oGeoTarget->getCityId()}/">{$oUser->getProfileCity()|escape:'html'}</a>
									{/if}
								</dd>
							</dl>
						{/if}

						<dl class="mt-20">
							<dt>{$aLang.plugin.admin.users.profile.info.reg_date}</dt>
							<dd>{date_format date=$oUser->getDateRegister()}</dd>
						</dl>
						<dl>
							<dt>{$aLang.plugin.admin.users.profile.info.ip}</dt>
							<dd>
								<a href="{router page='admin/users/list'}{request_filter
								name=array('ip_register')
								value=array($oUser->getIpRegister())
								}">{$oUser->getIpRegister()}</a>
							</dd>
						</dl>

						{if $oSession}
							<dl class="mt-20">
								<dt>{$aLang.plugin.admin.users.profile.info.last_visit}</dt>
								<dd>{date_format date=$oSession->getDateLast()}</dd>
							</dl>
							<dl>
								<dt>{$aLang.plugin.admin.users.profile.info.ip}</dt>
								<dd>
									<a href="{router page='admin/users/list'}{request_filter
									name=array('session_ip_last')
									value=array($oSession->getIpLast())
									}">{$oSession->getIpLast()}</a>
									<br />
									<a href="{router page='admin/users/list'}{request_filter
									name=array('session_ip_last')
									value=array($oSession->getIpLast())
									}" class="button mt-10">{$aLang.plugin.admin.users.profile.info.search_this_ip}</a>
								</dd>
							</dl>
						{/if}


					</div>

					<div class="line-2"></div>

					<div class="stats">
						<h2 class="title mb-20">
							{$aLang.plugin.admin.users.profile.info.stats_title}
						</h2>

						<div class="stat-row">
							<div class="stat-header">{$aLang.plugin.admin.users.profile.info.created}</div>
							<ul>
								{* todo: fill hrefs in links or leave just a text? *}
								<li><a href="#">{$iCountTopicUser} {$aLang.plugin.admin.users.profile.info.topics}</a></li>
								<li><a href="#">{$iCountCommentUser} {$aLang.plugin.admin.users.profile.info.comments}</a></li>
								<li><a href="#">{$iCountBlogsUser} {$aLang.plugin.admin.users.profile.info.blogs}</a></li>
							</ul>
						</div>
						<div class="stat-row">
							<div class="stat-header">{$aLang.plugin.admin.users.profile.info.fav}</div>
							<ul>
								<li><a href="#">{$iCountTopicFavourite} {$aLang.plugin.admin.users.profile.info.topics}</a></li>
								<li><a href="#">{$iCountCommentFavourite} {$aLang.plugin.admin.users.profile.info.comments}</a></li>
							</ul>

						</div>
						<div class="stat-row">
							<div class="stat-header">{$aLang.plugin.admin.users.profile.info.reads}</div>
							<ul>
								<li><a href="#">{$iCountBlogReads} {$aLang.plugin.admin.users.profile.info.blogs}</a></li>
							</ul>

						</div>
						<div class="stat-row">
							<div class="stat-header">{$aLang.plugin.admin.users.profile.info.has}</div>
							<ul>
								<li><a href="#">{$iCountFriendsUser} {$aLang.plugin.admin.users.profile.info.friends}</a></li>
							</ul>

						</div>

					</div>

					<div class="line-2"></div>

					<div class="stats">
						<h2 class="title mb-20">
							{$aLang.plugin.admin.users.profile.info.votings_title}
						</h2>

						<div class="stat-row">
							<div class="stat-header"><a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]=topic"
										>{$aLang.plugin.admin.users.profile.info.for_topics}</a></div>
							<ul>
								<li><a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]=topic&filter[dir]=plus">{$aUserVotedStat.topic.plus} +</a></li>
								<li><a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]=topic&filter[dir]=minus">{$aUserVotedStat.topic.minus} -</a></li>
							</ul>
						</div>

						<div class="stat-row">
							<div class="stat-header"><a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]=comment"
										>{$aLang.plugin.admin.users.profile.info.for_comments}</a></div>
							<ul>
								<li><a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]=comment&filter[dir]=plus">{$aUserVotedStat.comment.plus} +</a></li>
								<li><a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]=comment&filter[dir]=minus">{$aUserVotedStat.comment.minus} -</a></li>
							</ul>
						</div>

						<div class="stat-row">
							<div class="stat-header"><a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]=blog"
										>{$aLang.plugin.admin.users.profile.info.for_blogs}</a></div>
							<ul>
								<li><a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]=blog&filter[dir]=plus">{$aUserVotedStat.blog.plus} +</a></li>
								<li><a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]=blog&filter[dir]=minus">{$aUserVotedStat.blog.minus} -</a></li>
							</ul>
						</div>

						<div class="stat-row">
							<div class="stat-header"><a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]=user"
										>{$aLang.plugin.admin.users.profile.info.for_users}</a></div>
							<ul>
								<li><a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]=user&filter[dir]=plus">{$aUserVotedStat.user.plus} +</a></li>
								<li><a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]=user&filter[dir]=minus">{$aUserVotedStat.user.minus} -</a></li>
							</ul>
						</div>


					</div>

					<div class="line-2"></div>

					<div class="user-fields">
						<div class="contacts">
							<h2 class="title mb-20">
								{$aLang.profile_contacts}
							</h2>

							{$aUserFieldContactValues = $oUser->getUserFieldValues(true,array('contact'))}

							{if $aUserFieldContactValues}
								<ul class="profile-contact-list">
									{foreach from=$aUserFieldContactValues item=oField}
										<li>
											<i class="icon-contact icon-contact-{$oField->getName()}" title="{$oField->getName()}"></i>
											{$oField->getValue(true,true)}
										</li>
									{/foreach}
								</ul>
							{/if}
						</div>

						<div class="social">
							<h2 class="title mb-20">
								{$aLang.profile_social}
							</h2>

							{$aUserFieldContactValues = $oUser->getUserFieldValues(true,array('social'))}

							{if $aUserFieldContactValues}
								<ul class="profile-contact-list">
									{foreach from=$aUserFieldContactValues item=oField}
										<li>
											<i class="icon-contact icon-contact-{$oField->getName()}" title="{$oField->getName()}"></i>
											{$oField->getValue(true,true)}
										</li>
									{/foreach}
								</ul>
							{/if}

						</div>
					</div>


				</div>

			</div>

		</div>
	</div>

{/block}