{**
 * Страница пользователя
 *
 * @styles user.css
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_content_before'}
	<header class="user-header">
		<div class="user-brief ls-clearfix">
			<div class="user-brief-body">
				<a href="{$oUser->getUserWebPath()}" class="user-avatar {if $oUser->isOnline()}user-is-online{/if}">
					<img src="{$oUser->getProfileAvatarPath(100)}" alt="avatar" title="{if $oUser->isOnline()}{$aLang.user_status_online}{else}{$aLang.user_status_offline}{/if}" />
				</a>

				<h3 class="user-login">
					{$oUser->getLogin()}

					{if $oUser->isAdministrator()}
						<i class="icon-user-admin" title="{$aLang.plugin.admin.users.admin}"></i>
					{/if}
				</h3>

				<p class="user-name">
					{if $oUser->getProfileName()}{$oUser->getProfileName()}{else}{$aLang.plugin.admin.users.profile_edit.no_profile_name}{/if}
				</p>

				<p class="user-mail">
					<a href="mailto:{$oUser->getMail()}" target="_blank" class="link-border"><span>{$oUser->getMail()}</span></a>
				</p>

				<p class="user-id">{$aLang.plugin.admin.users.profile.user_no}{$oUser->getId()}</p>
			</div>

			{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/user_actions.tpl" text="Действия"}
		</div>
	</header>
{/block}

{block 'layout_content'}
	{$oSession = $oUser->getSession()}

	<aside class="user-info-aside">
		<div class="block block-user-photo">
			<a href="{$oUser->getUserWebPath()}"><img src="{$oUser->getProfileFotoPath()}" alt="photo" class="photo" /></a>
		</div>

        {*
		{include file="blocks/block.userNote.tpl" oUserProfile=$oUser oUserNote=$oUser->getUserNote()}
        *}
		<div class="block block-user-menu">
			<ul class="user-menu">
				<li class="user-menu-item"><a href="{$oUser->getUserWebPath()}" class="link-border"><span>{$aLang.plugin.admin.users.profile.middle_bar.profile}</span></a></li>
				<li class="user-menu-item"><a href="{$oUser->getUserWebPath()}created/" class="link-border"><span>{$aLang.plugin.admin.users.profile.middle_bar.publications}</span></a></li>
				<li class="user-menu-item"><a href="{$oUser->getUserWebPath()}stream/" class="link-border"><span>{$aLang.plugin.admin.users.profile.middle_bar.activity}</span></a></li>
				<li class="user-menu-item"><a href="{$oUser->getUserWebPath()}friends/" class="link-border"><span>{$aLang.plugin.admin.users.profile.middle_bar.friends}</span></a></li>
				<li class="user-menu-item"><a href="{$oUser->getUserWebPath()}wall/" class="link-border"><span>{$aLang.plugin.admin.users.profile.middle_bar.wall}</span></a></li>
				<li class="user-menu-item"><a href="{$oUser->getUserWebPath()}favourites/" class="link-border"><span>{$aLang.plugin.admin.users.profile.middle_bar.fav}</span></a></li>
			</ul>
		</div>
	</aside>


	<div class="user-info-body">
		{* Для вывода информации бана *}
		{hook run='admin_user_profile_center_info' oUserProfile=$oUser}


		<div class="user-info-block user-info-block-resume">
    		<h2 class="user-info-block-title">{$aLang.plugin.admin.users.profile.info.resume}</h2>

			{component 'admin:p-user.form' user=$oUser}
		</div>

		<div class="user-info-block user-info-block-auth">
			<h2 class="user-info-block-title">Авторизация</h2>

			<dl class="dotted-list-item mt-20">
				<dt class="dotted-list-item-label">{$aLang.plugin.admin.users.profile.info.reg_date}</dt>
				<dd class="dotted-list-item-value">{date_format date=$oUser->getDateRegister()}</dd>
			</dl>

			<dl class="dotted-list-item">
				<dt class="dotted-list-item-label">{$aLang.plugin.admin.users.profile.info.ip}</dt>
				<dd class="dotted-list-item-value">
					<a href="{router page='admin/users/list'}{request_filter
						name=array('ip_register')
						value=array($oUser->getIpRegister())
					}" title="{$aLang.plugin.admin.users.profile.info.search_this_ip}">{$oUser->getIpRegister()}</a>
				</dd>
			</dl>

			{if $oSession}
				<dl class="dotted-list-item mt-20">
					<dt class="dotted-list-item-label">{$aLang.plugin.admin.users.profile.info.last_visit}</dt>
					<dd class="dotted-list-item-value">{date_format date=$oSession->getDateLast()}</dd>
				</dl>

				<dl class="dotted-list-item">
					<dt class="dotted-list-item-label">{$aLang.plugin.admin.users.profile.info.ip}</dt>
					<dd class="dotted-list-item-value">
						<a href="{router page='admin/users/list'}{request_filter
							name=array('session_ip_last')
							value=array($oSession->getIpLast())
						}" title="{$aLang.plugin.admin.users.profile.info.search_this_ip}">{$oSession->getIpLast()}</a>
					</dd>
				</dl>
			{/if}
		</div>

		{*
			Статистика
		*}
		<div class="user-info-block user-info-block-stats">
			<h2 class="user-info-block-title">{$aLang.plugin.admin.users.profile.info.stats_title}</h2>

			<div class="user-info-block-stats-row">
				<div class="user-info-block-stats-header">{$aLang.plugin.admin.users.profile.info.created}</div>
				<ul>
					<li><a href="{$oUser->getUserWebPath()}created/topics/" class="link-border"><span>{$iCountTopicUser} {$aLang.plugin.admin.users.profile.info.topics}</span></a></li>
					<li><a href="{$oUser->getUserWebPath()}created/comments/" class="link-border"><span>{$iCountCommentUser} {$aLang.plugin.admin.users.profile.info.comments}</span></a></li>
					<li><span>{$iCountBlogsUser} {$aLang.plugin.admin.users.profile.info.blogs}</span></li>
				</ul>
			</div>

			<div class="user-info-block-stats-row">
				<div class="user-info-block-stats-header">{$aLang.plugin.admin.users.profile.info.fav}</div>
				<ul>
					<li><a href="{$oUser->getUserWebPath()}favourites/topics/" class="link-border"><span>{$iCountTopicFavourite} {$aLang.plugin.admin.users.profile.info.topics}</span></a></li>
					<li><a href="{$oUser->getUserWebPath()}favourites/comments/" class="link-border"><span>{$iCountCommentFavourite} {$aLang.plugin.admin.users.profile.info.comments}</span></a></li>
				</ul>
			</div>

			<div class="user-info-block-stats-row">
				<div class="user-info-block-stats-header">{$aLang.plugin.admin.users.profile.info.reads}</div>
				<ul>
					<li><span>{$iCountBlogReads} {$aLang.plugin.admin.users.profile.info.blogs}</span></li>
				</ul>
			</div>

			<div class="user-info-block-stats-row">
				<div class="user-info-block-stats-header">{$aLang.plugin.admin.users.profile.info.has}</div>
				<ul>
					<li><a href="{$oUser->getUserWebPath()}friends/" class="link-border"><span>{$iCountFriendsUser} {$aLang.plugin.admin.users.profile.info.friends}</span></a></li>
				</ul>
			</div>
		</div>

		{*
			Как голосовал пользователь
		*}
		<div class="user-info-block user-info-block-stats">
			<h2 class="user-info-block-title">{$aLang.plugin.admin.users.profile.info.votings_title}</h2>

			{foreach from=array('topic', 'comment', 'blog', 'user') item=sType}
				<div class="user-info-block-stats-row">
					<div class="user-info-block-stats-header">
						<a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]={$sType}">{$aLang.plugin.admin.users.profile.info.votings[$sType]}</a>
					</div>
					<ul>
						{foreach from=array('plus', 'minus', 'abstain') item=sVoteDir}
							{if $aUserVotedStat[$sType][$sVoteDir]}
								<li title="{$sVoteDir}">
									<a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]={$sType}&filter[dir]={$sVoteDir}">{$aUserVotedStat[$sType][$sVoteDir]}</a>
									{$aLang.plugin.admin.users.profile.info.votings_direction[$sVoteDir]}
								</li>
							{/if}
						{/foreach}
					</ul>
				</div>
			{/foreach}

		</div>

		{*
			Контакты
		*}
		{$aUserFieldContactValues = $oUser->getUserFieldValues(true,array('contact'))}
		{$aUserFieldSocialValues = $oUser->getUserFieldValues(true,array('social'))}

		{if $aUserFieldContactValues || $aUserFieldSocialValues}
			<div class="user-info-block user-info-block-contacts">
				<h2 class="user-info-block-title">Контакты</h2>

				<div class="ls-clearfix">
					{if $aUserFieldContactValues}
						<ul class="user-contact-list">
							{foreach $aUserFieldContactValues as $oField}
								<li>
									<i class="icon-contact icon-contact-{$oField->getName()}" title="{$oField->getName()}"></i>
									{$oField->getValue(true,true)}
								</li>
							{/foreach}
						</ul>
					{/if}

					{if $aUserFieldSocialValues}
						<ul class="user-contact-list">
							{foreach $aUserFieldSocialValues as $oField}
								<li>
									<i class="icon-contact icon-contact-{$oField->getName()}" title="{$oField->getName()}"></i>
									{$oField->getValue(true,true)}
								</li>
							{/foreach}
						</ul>
					{/if}
				</div>
			</div>
		{/if}
	</div>
{/block}