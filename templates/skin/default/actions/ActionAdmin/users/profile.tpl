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
		{* todo: delete if not needed *}
		<li><a href="#"><i class="icon-white icon-pencil"></i></a></li>

		{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/user_actions.tpl"}

		{* todo: delete if not needed *}
		<li class="fl-r"><a href="#"><i class="icon-white icon-chevron-right"></i></a></li>
		<li class="fl-r"><a href="#"><i class="icon-white icon-chevron-left"></i></a></li>
	</ul>
{/block}


{*
	Основная информация
*}
{block name='layout_content_before'}
	<header class="user-header">
		<div class="user-brief clearfix">
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
					{$oUser->getMail()}
					<a href="mailto:{$oUser->getMail()}" target="_blank"><i class="icon-envelope"></i></a>
				</p>

				<p class="user-id">{$aLang.plugin.admin.users.profile.user_no}{$oUser->getId()}</p>
			</div>

			{* Редактирование дополнительных данных *}
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
			</div>
		</div>
	</header>
{/block}


{block name='layout_content'}
	{$oSession = $oUser->getSession()}

	<aside class="user-info-aside">
		<div class="block block-user-photo">
			<a href="{$oUser->getUserWebPath()}"><img src="{$oUser->getProfileFotoPath()}" alt="photo" class="photo" /></a>
		</div>

		{include file="blocks/block.userNote.tpl" oUserProfile=$oUser oUserNote=$oUser->getUserNote()}

		<div class="block block-user-menu">
			<ul class="user-menu">
				<li class="user-menu-item"><a href="{$oUser->getUserWebPath()}" class="link-border"><span>{$aLang.plugin.admin.users.profile.middle_bar.profile}</span></a></li>
				<li class="user-menu-item"><a href="{$oUser->getUserWebPath()}created/" class="link-border"><span>{$aLang.plugin.admin.users.profile.middle_bar.publications}</span></a></li>
				<li class="user-menu-item"><a href="{$oUser->getUserWebPath()}stream/" class="link-border"><span>{$aLang.plugin.admin.users.profile.middle_bar.activity}</span></a></li>
				<li class="user-menu-item"><a href="{$oUser->getUserWebPath()}friends/" class="link-border"><span>{$aLang.plugin.admin.users.profile.middle_bar.friends}</span></a></li>
				{*<li class="user-menu-item"><a href="#" class="link-border"><span>Жалобы</span></a></li>*}
				<li class="user-menu-item"><a href="{$oUser->getUserWebPath()}wall/" class="link-border"><span>{$aLang.plugin.admin.users.profile.middle_bar.wall}</span></a></li>
				{*<li class="user-menu-item"><a href="#" class="link-border"><span>Блоги</span></a></li>*}
				<li class="user-menu-item"><a href="{$oUser->getUserWebPath()}favourites/" class="link-border"><span>{$aLang.plugin.admin.users.profile.middle_bar.fav}</span></a></li>
				{*<li class="user-menu-item"><a href="#" class="link-border"><span>Почта</span></a></li>*}
				{*<li class="user-menu-item"><a href="#" class="link-border"><span>Права</span></a></li>*}
			</ul>
		</div>
	</aside>


	<div class="user-info-body">
		{* Для вывода информации бана *}
		{hook run='admin_user_profile_center_info' oUserProfile=$oUser}

		{*
			Базовая информация
		*}
		<div class="user-info-block user-info-block-resume">
			{*
				для редактирования профиля пользователя
			*}
			<form action="{router page='admin/users/profile'}{$oUser->getId()}" method="post" enctype="application/x-www-form-urlencoded">
				{* Скрытые поля *}
				{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.hidden.security_key.tpl"}

				<h2 class="user-info-heading">{$aLang.plugin.admin.users.profile.info.resume}</h2>

				{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
					sFieldName   = 'login'
					sFieldValue  = $oUser->getLogin()|escape
					sFieldLabel  = $aLang.plugin.admin.users.profile.info.login
				}

				{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
					sFieldName   = 'profile_name'
					sFieldValue  = $oUser->getProfileName()|escape
					sFieldLabel  = $aLang.plugin.admin.users.profile.info.profile_name
				}

				{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
					sFieldName='mail'
					sFieldValue=$oUser->getMail()
					sFieldLabel  = $aLang.plugin.admin.users.profile.info.mail
				}

				{$aSex = [
					[ 'value' => 'man',   'text' => $aLang.plugin.admin.users.sex.man ],
					[ 'value' => 'woman', 'text' => $aLang.plugin.admin.users.sex.woman ],
					[ 'value' => 'other', 'text' => $aLang.plugin.admin.users.sex.other ]
				]}
				{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.select.tpl"
					sFieldName          = 'profile_sex'
					aFieldItems         = $aSex
					sFieldSelectedValue = $oUser->getProfileSex()
					sFieldLabel  = $aLang.plugin.admin.users.profile.info.sex
				}

				{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.select.date.tpl"
					sFieldNamePrefix    = 'profile_birthday'
					aFieldItems         = $oUser->getProfileBirthday()
					sFieldLabel  = $aLang.plugin.admin.users.profile.info.birthday
				}

				{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.select.geo.tpl"
					sFieldNamePrefix    = 'geo'
					oFieldGeoTarget     = $oGeoTarget
					sFieldLabel  = $aLang.plugin.admin.users.profile.info.living
				}
				<script>
					jQuery(document).ready(function ($) {
						ls.lang.load({lang_load name="geo_select_city, geo_select_region"});
						ls.geo.initSelect();
					});
				</script>

				{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
					sFieldName='password'
					sFieldValue=''
					sFieldPlaceholder='*******'
					sFieldLabel  = $aLang.plugin.admin.users.profile_edit.password
				}

				{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.textarea.tpl"
					sFieldName   = 'profile_about'
					iFieldRows   = 4
					sFieldValue  = $oUser->getProfileAbout()|strip_tags|escape
					sFieldLabel  = $aLang.plugin.admin.users.profile_edit.about_user
				}

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

				{* Кнопки *}
				<div class="mt-15">
					{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.button.tpl"
						sFieldName='submit_edit'
						sFieldStyle='primary'
						sFieldText=$aLang.settings_profile_submit
					}
				</div>
			</form>
		</div>

		{*
			Статистика
		*}
		<div class="user-info-block user-info-block-stats">
			<h2 class="user-info-heading">{$aLang.plugin.admin.users.profile.info.stats_title}</h2>

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
			<h2 class="user-info-heading">{$aLang.plugin.admin.users.profile.info.votings_title}</h2>

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