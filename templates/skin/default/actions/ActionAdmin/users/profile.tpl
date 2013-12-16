{**
 * Страница пользователя
 *
 * @styles user.css
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}


{* Actionbar *}
{block name='layout_content_actionbar_class'}actionbar-user{/block}
{block name='layout_content_actionbar'}
	<ul>
		<li><a href="#"><i class="icon-white icon-pencil"></i></a></li>

		{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/user_operations.tpl"}

		<li class="fl-r"><a href="#"><i class="icon-white icon-chevron-right"></i></a></li>
		<li class="fl-r"><a href="#"><i class="icon-white icon-chevron-left"></i></a></li>
	</ul>
{/block}


{* Основная информация *}
{block name='layout_content_before'}
	<header class="user-header">
		<div class="user-brief clearfix">
			<div class="user-brief-body">
				<a href="{$oUser->getUserWebPath()}" class="user-avatar {if $oUser->isOnline()}user-is-online{/if}">
					<img src="{$oUser->getProfileAvatarPath(100)}" 
						 alt="avatar" 
						 title="{if $oUser->isOnline()}{$aLang.user_status_online}{else}{$aLang.user_status_offline}{/if}" />
				</a>

				<h3 class="user-login">
					{* Инлайн редактирование поля *}
					<span class="js-profile-inline-edit-input highlight-profile-inline-edit" data-item-type="login" data-item-id="{$oUser->getId()}">{$oUser->getLogin()}</span>

					{if $oUser->isAdministrator()}
						<i class="icon-user-admin" title="{$aLang.plugin.admin.users.admin}"></i>
					{/if}
				</h3>

				<p class="user-name">
					{* Инлайн редактирование поля *}
					<span class="js-profile-inline-edit-input highlight-profile-inline-edit" data-item-type="profile_name" data-item-id="{$oUser->getId()}"
							>{if $oUser->getProfileName()}{$oUser->getProfileName()}{else}{$aLang.plugin.admin.users.profile_edit.no_profile_name}{/if}</span>
				</p>

				<p class="user-mail">
					{* Инлайн редактирование поля *}
					<span class="js-profile-inline-edit-input highlight-profile-inline-edit" data-item-type="mail" data-item-id="{$oUser->getId()}">{$oUser->getMail()}</span>
					<a href="mailto:{$oUser->getMail()}" class="link-border" target="_blank"><i class="icon-envelope"></i></a>
				</p>

				<p class="user-id">{$aLang.plugin.admin.users.profile.user_no}{$oUser->getId()}</p>
			</div>

			{* Редактирование доп. данных *}
			<div class="user-brief-aside">
				<div class="edit-rating mb-10">
					<i class="icon-rating" title="{$aLang.plugin.admin.users.profile_edit.rating}"></i>
					{* Инлайн редактирование поля *}
					<span class="link-dotted js-profile-inline-edit-input highlight-profile-inline-edit" data-item-type="rating" data-item-id="{$oUser->getId()}">{$oUser->getRating()}</span>
				</div>

				<div class="edit-skill">
					<i class="icon-rating" title="{$aLang.plugin.admin.users.profile_edit.skill}"></i>
					{* Инлайн редактирование поля *}
					<span class="link-dotted js-profile-inline-edit-input highlight-profile-inline-edit" data-item-type="skill" data-item-id="{$oUser->getId()}">{$oUser->getSkill()}</span>
				</div>

				<div class="get-user-baneed">
					{* Для вывода информации бана *}
					{hook run='admin_user_profile_brief_aside' oUserProfile=$oUser}        {* todo: review: hook names *}
				</div>
			</div>
		</div>
	</header>
{/block}


{block name='layout_content'}
	{$oSession = $oUser->getSession()}

	<aside class="user-info-aside">
		<div class="block block-user-photo">
			<a href="{$oUser->getUserWebPath()}"><img src="{$oUser->getProfileFotoPath()}" alt="" class="photo" /></a>
		</div>

		{include file="blocks/block.userNote.tpl" oUserProfile=$oUser oUserNote=$oUser->getUserNote()}

		<div class="block block-user-menu">
			<ul class="user-menu">
				<li class="user-menu-item"><a href="{$oUser->getUserWebPath()}" class="link-border"><span>{$aLang.plugin.admin.users.profile.middle_bar.profile}</span></a></li>
				<li class="user-menu-item"><a href="{$oUser->getUserWebPath()}created/" class="link-border"><span>{$aLang.plugin.admin.users.profile.middle_bar.publications}</span></a></li>
				<li class="user-menu-item"><a href="{$oUser->getUserWebPath()}stream/" class="link-border"><span>{$aLang.plugin.admin.users.profile.middle_bar.activity}</span></a></li>
				<li class="user-menu-item"><a href="{$oUser->getUserWebPath()}friends/" class="link-border"><span>{$aLang.plugin.admin.users.profile.middle_bar.friends}</span></a></li>
				{*<li class="user-menu-item"><a href="#" class="link-border"><span>Жалобы</span></a></li>*}
				{*<li class="user-menu-item"><a href="#" class="link-border"><span>Счет</span></a></li>*}
				<li class="user-menu-item"><a href="{$oUser->getUserWebPath()}wall/" class="link-border"><span>{$aLang.plugin.admin.users.profile.middle_bar.wall}</span></a></li>
				{*<li class="user-menu-item"><a href="#" class="link-border"><span>Блоги</span></a></li>*}
				<li class="user-menu-item"><a href="{$oUser->getUserWebPath()}favourites/" class="link-border"><span>{$aLang.plugin.admin.users.profile.middle_bar.fav}</span></a></li>
				{*<li class="user-menu-item"><a href="#" class="link-border"><span>Почта</span></a></li>*}
				{*<li class="user-menu-item"><a href="#" class="link-border"><span>Права</span></a></li>*}
			</ul>
		</div>
	</aside>


	<div class="user-info-body">
		{* Базовая информация *}
		<div class="user-info-block user-info-block-resume">
			<h2 class="user-info-heading">{$aLang.plugin.admin.users.profile.info.resume}</h2>

			<dl class="dotted-list-item">
				<dt class="dotted-list-item-label">{$aLang.plugin.admin.users.profile.info.mail}</dt>
				<dd class="dotted-list-item-value">
					{* Инлайн редактирование поля *}
					<span class="js-profile-inline-edit-input highlight-profile-inline-edit" data-item-type="mail" data-item-id="{$oUser->getId()}">{$oUser->getMail()}</span>

					<a href="{router page='admin/users/list'}{request_filter
						name=array('mail')
						value=array($oUser->getMail())
					}"><i class="icon-search" title="{$aLang.plugin.admin.search}"></i></a>
				</dd>
			</dl>

			<dl class="dotted-list-item">
				<dt class="dotted-list-item-label">{$aLang.plugin.admin.users.profile.info.sex}</dt>
				<dd class="dotted-list-item-value">
					{* Инлайн редактирование поля *}
					<span class="js-profile-inline-edit-select highlight-profile-inline-edit" data-item-type="sex" data-item-id="{$oUser->getId()}"
							>{$aLang.plugin.admin.users.sex[$oUser->getProfileSex()]}</span>
				</dd>
			</dl>

			<dl class="dotted-list-item">
				<dt class="dotted-list-item-label">{$aLang.plugin.admin.users.profile.info.birthday}</dt>
				<dd class="dotted-list-item-value">
					{if $oUser->getProfileBirthday()}
						{*date_format date=$oUser->getProfileBirthday() format="j F Y" notz=true*}
						{* Инлайн редактирование поля даты рождения - день *}
						<span class="js-profile-inline-edit-select highlight-profile-inline-edit" data-item-type="birthday_day" data-item-id="{$oUser->getId()}"
								>{date_format date=$oUser->getProfileBirthday() format="j" notz=true}</span>
						{* Инлайн редактирование поля даты рождения - месяц *}
						<span class="js-profile-inline-edit-select highlight-profile-inline-edit" data-item-type="birthday_month" data-item-id="{$oUser->getId()}"
								>{date_format date=$oUser->getProfileBirthday() format="F" notz=true}</span>
						{* Инлайн редактирование поля даты рождения - год *}
						<span class="js-profile-inline-edit-select highlight-profile-inline-edit" data-item-type="birthday_year" data-item-id="{$oUser->getId()}"
								>{date_format date=$oUser->getProfileBirthday() format="Y" notz=true}</span>
					{else}
						<i class="icon-question-sign" title="{$aLang.plugin.admin.users.profile_edit.no_bidthday_set}"></i>
						{* Инлайн редактирование поля даты рождения - день *}
						<span class="js-profile-inline-edit-select highlight-profile-inline-edit" data-item-type="birthday_day" data-item-id="{$oUser->getId()}"
								>{$aLang.plugin.admin.users.profile_edit.bidthday_parts.day}</span>
						{* Инлайн редактирование поля даты рождения - месяц *}
						<span class="js-profile-inline-edit-select highlight-profile-inline-edit" data-item-type="birthday_month" data-item-id="{$oUser->getId()}"
								>{$aLang.plugin.admin.users.profile_edit.bidthday_parts.month}</span>
						{* Инлайн редактирование поля даты рождения - год *}
						<span class="js-profile-inline-edit-select highlight-profile-inline-edit" data-item-type="birthday_year" data-item-id="{$oUser->getId()}"
								>{$aLang.plugin.admin.users.profile_edit.bidthday_parts.year}</span>
					{/if}
				</dd>
			</dl>

			<dl class="dotted-list-item">
				<dt class="dotted-list-item-label">{$aLang.plugin.admin.users.profile.info.living}</dt>
				<dd class="dotted-list-item-value">
					{* Если город не указан, значит не все гео-данные заполнены и можно вывести подсказку *}
					{if !$oGeoTarget or !$oGeoTarget->getCityId()}
						<i class="icon-question-sign" title="{$aLang.plugin.admin.users.profile_edit.no_living_set}"></i>
					{/if}

					{if $oGeoTarget and $oGeoTarget->getCountryId()}
						{* Инлайн редактирование поля страны (задано) *}
						<span class="js-profile-inline-edit-select highlight-profile-inline-edit" data-item-type="living_country" data-item-id="{$oUser->getId()}"
								>{$oUser->getProfileCountry()|escape:'html'}</span>

						<a href="{router page='people/country'}{$oGeoTarget->getCountryId()}/"><i class="icon-search" title="{$aLang.plugin.admin.search}"></i></a>
					{else}
						{* Инлайн редактирование поля страны *}
						<span class="js-profile-inline-edit-select highlight-profile-inline-edit" data-item-type="living_country" data-item-id="{$oUser->getId()}"
								>{$aLang.plugin.admin.users.profile_edit.living_parts.country}</span>
					{/if}
					<br />

					{if $oGeoTarget and $oGeoTarget->getRegionId()}
						{* Инлайн редактирование поля региона (задано) *}
						<span class="js-profile-inline-edit-select highlight-profile-inline-edit" data-item-type="living_region" data-item-id="{$oUser->getId()}"
								>{$oUser->getProfileRegion()|escape:'html'}</span>
					{else}
						{* Инлайн редактирование поля региона *}
						<span class="js-profile-inline-edit-select highlight-profile-inline-edit" data-item-type="living_region" data-item-id="{$oUser->getId()}"
								>{$aLang.plugin.admin.users.profile_edit.living_parts.region}</span>
					{/if}
					<br />

					{if $oGeoTarget and $oGeoTarget->getCityId()}
						{* Инлайн редактирование поля города (задано) *}
						<span class="js-profile-inline-edit-select highlight-profile-inline-edit" data-item-type="living_city" data-item-id="{$oUser->getId()}"
								>{$oUser->getProfileCity()|escape:'html'}</span>

						<a href="{router page='people/city'}{$oGeoTarget->getCityId()}/"><i class="icon-search" title="{$aLang.plugin.admin.search}"></i></a>
					{else}
						{* Инлайн редактирование поля города *}
						<span class="js-profile-inline-edit-select highlight-profile-inline-edit" data-item-type="living_city" data-item-id="{$oUser->getId()}"
								>{$aLang.plugin.admin.users.profile_edit.living_parts.city}</span>
					{/if}
				</dd>
			</dl>

			<dl class="dotted-list-item">
				<dt class="dotted-list-item-label">{$aLang.plugin.admin.users.profile_edit.password}</dt>
				<dd class="dotted-list-item-value">
					{* Инлайн редактирование поля *}
					<span class="link-dotted js-profile-inline-edit-input highlight-profile-inline-edit" data-item-type="password" data-item-id="{$oUser->getId()}">*******</span>
				</dd>
			</dl>

			<dl class="dotted-list-item">
				<dt class="dotted-list-item-label">{$aLang.plugin.admin.users.profile_edit.about_user}</dt>
				<dd class="dotted-list-item-value">
					{* Инлайн редактирование поля *}
					<span class="link-dotted js-profile-inline-edit-input highlight-profile-inline-edit" data-item-type="about" data-item-id="{$oUser->getId()}"
							>{$oUser->getProfileAbout()}</span>
				</dd>
			</dl>

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
					}">{$oUser->getIpRegister()}</a>
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
			<h2 class="user-info-heading">{$aLang.plugin.admin.users.profile.info.stats_title}</h2>

			<div class="user-info-block-stats-row">
				<div class="user-info-block-stats-header">{$aLang.plugin.admin.users.profile.info.created}</div>
				<ul>
					{* todo: fill hrefs in links or leave just a text? *}
					<li><a href="#" class="link-border"><span>{$iCountTopicUser} {$aLang.plugin.admin.users.profile.info.topics}</span></a></li>
					<li><a href="#" class="link-border"><span>{$iCountCommentUser} {$aLang.plugin.admin.users.profile.info.comments}</span></a></li>
					<li><a href="#" class="link-border"><span>{$iCountBlogsUser} {$aLang.plugin.admin.users.profile.info.blogs}</span></a></li>
				</ul>
			</div>

			<div class="user-info-block-stats-row">
				<div class="user-info-block-stats-header">{$aLang.plugin.admin.users.profile.info.fav}</div>
				<ul>
					<li><a href="#" class="link-border"><span>{$iCountTopicFavourite} {$aLang.plugin.admin.users.profile.info.topics}</span></a></li>
					<li><a href="#" class="link-border"><span>{$iCountCommentFavourite} {$aLang.plugin.admin.users.profile.info.comments}</span></a></li>
				</ul>
			</div>

			<div class="user-info-block-stats-row">
				<div class="user-info-block-stats-header">{$aLang.plugin.admin.users.profile.info.reads}</div>
				<ul>
					<li><a href="#" class="link-border"><span>{$iCountBlogReads} {$aLang.plugin.admin.users.profile.info.blogs}</span></a></li>
				</ul>
			</div>

			<div class="user-info-block-stats-row">
				<div class="user-info-block-stats-header">{$aLang.plugin.admin.users.profile.info.has}</div>
				<ul>
					<li><a href="#" class="link-border"><span>{$iCountFriendsUser} {$aLang.plugin.admin.users.profile.info.friends}</span></a></li>
				</ul>
			</div>
		</div>

		{*
			Как голосовал пользователь
		*}
		<div class="user-info-block user-info-block-stats">
			<h2 class="user-info-heading">{$aLang.plugin.admin.users.profile.info.votings_title}</h2>

			{foreach from=array('topic', 'comment', 'blog', 'user') item=sType}
				<div class="user-info-block-stats-row">
					<div class="user-info-block-stats-header">
						<a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]={$sType}">{$aLang.plugin.admin.users.profile.info.votings[$sType]}</a>
					</div>
					<ul>
						{foreach from=array('plus', 'minus', 'abstain') item=sVoteDir}
							{if $aUserVotedStat[$sType][$sVoteDir]}
								<li>
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
				<h2 class="user-info-heading">{$aLang.profile_contacts}</h2>
				
				<div class="clearfix">
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