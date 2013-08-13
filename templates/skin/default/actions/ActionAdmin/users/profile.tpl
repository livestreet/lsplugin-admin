{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}
	{assign var="oSession" value=$oUser->getSession()}
	<div class="profile-info-wrapper">
		<div class="top-controls">
			<ul>
				<li><a class="icon-white icon-pencil" href="#"></a></li>
				<li><a href="{router page='talk/add'}?talk_users={$oUser->getLogin()}">Сообщение</a></li>
				<li><a href="#">В администраторы</a></li>
				<li><a href="#">Удалить контент</a></li>
				<li><a href="#">Блокировать</a></li>

				<li class="fl-r"><a class="icon-white icon-chevron-right" href="#"></a></li>
				<li class="fl-r"><a class="icon-white icon-chevron-left" href="#"></a></li>
				<li class="fl-r"><a class="icon-white icon-backward" href="#"></a></li>
			</ul>
		</div>
		<div class="inner-data">
			<ul class="profile-links">
				<li><a class="profile" href="{$oUser->getUserWebPath()}">Профиль</a></li>
				<li><a class="publications" href="{$oUser->getUserWebPath()}created/">Публикации</a></li>
				<li><a class="activity" href="{$oUser->getUserWebPath()}stream/">Активность</a></li>
				<li><a class="friends" href="{$oUser->getUserWebPath()}friends/">Друзья</a></li>
				{*<li><a class="claims" href="#">Жалобы</a></li>*}
				{*<li><a class="money" href="#">Счет</a></li>*}
				<li><a class="wall" href="{$oUser->getUserWebPath()}wall/">Стена</a></li>
				{*<li><a class="blogs" href="#">Блоги</a></li>*}
				<li><a class="favorite" href="{$oUser->getUserWebPath()}favourites/">Избранное</a></li>
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
					<div class="skill">
						S:
						<input type="text" name="user-skill" class="input-text width-50" value="{$oUser->getSkill()}" />
					</div>
					<div class="rating">
						R:
						<input type="text" name="user-rating" class="input-text width-50" value="{$oUser->getRating()}" />
					</div>
					<div class="user-id">
						№ {$oUser->getId()}
					</div>
				</div>
			</div>
			<div class="more-info">
				<div class="right-data">
					<div class="photo-wrapper">
						<a href="{$oUser->getUserWebPath()}"><img src="{$oUser->getProfileFotoPath()}" alt="" class="photo" /></a>
					</div>
					<div class="your-note">
						<a href="#">Добавить заметку</a>
					</div>
				</div>
				<div class="left-data">
					<h2 class="title mb20">
						Досье
					</h2>
					<div class="resume">
						<dl>
							<dt>Почта</dt>
							<dd>
								<a href="{router page='admin/users/list'}{request_filter
								name=array('q', 'field')
								value=array($oUser->getMail(), 'mail')
								}">{$oUser->getMail()}</a>
							</dd>
						</dl>
						{if $oUser->getProfileSex() != 'other'}
							<dl>
								<dt>Пол</dt>
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
								<dt>Родился</dt>
								<dd>{date_format date=$oUser->getProfileBirthday() format="j F Y" notz=true}</dd>
							</dl>
						{/if}

						{if $oGeoTarget}
							<dl>
								<dt>Откуда</dt>
								<dd>
									{if $oGeoTarget->getCountryId()}
										<a href="{router page='people'}country/{$oGeoTarget->getCountryId()}/">{$oUser->getProfileCountry()|escape:'html'}</a>{if $oGeoTarget->getCityId()},{/if}
									{/if}

									{if $oGeoTarget->getCityId()}
										<a href="{router page='people'}city/{$oGeoTarget->getCityId()}/">{$oUser->getProfileCity()|escape:'html'}</a>
									{/if}
								</dd>
							</dl>
						{/if}

						<dl class="mt-20">
							<dt>Зарегистрирован</dt>
							<dd>{date_format date=$oUser->getDateRegister()}</dd>
						</dl>
						<dl>
							<dt>IP</dt>
							<dd>
								<a href="{router page='admin/users/list'}{request_filter
								name=array('q', 'field')
								value=array($oUser->getIpRegister(), 'ip_register')
								}">{$oUser->getIpRegister()}</a>
							</dd>
						</dl>

						{if $oSession}
							<dl class="mt-20">
								<dt>Последний визит</dt>
								<dd>{date_format date=$oSession->getDateLast()}</dd>
							</dl>
							<dl>
								<dt>IP</dt>
								<dd>
									<a href="{router page='admin/users/list'}{request_filter
									name=array('q', 'field')
									value=array($oSession->getIpLast(), 'session_ip_last')
									}">{$oSession->getIpLast()}</a>

									<br />
									<a href="{router page='admin/users/list'}{request_filter
									name=array('q', 'field')
									value=array($oSession->getIpLast(), 'session_ip_last')
									}" class="button mt-10">Искать с этим IP</a>
								</dd>
							</dl>
						{/if}


					</div>

					<div class="line-2"></div>

					<div class="stats">
						<h2 class="title mb20">
							Статистика
						</h2>

						<div class="stat-row">
							<div class="stat-header">Создал</div>
							<ul>
								<li><a href="#">{$iCountTopicUser} топиков</a></li>
								<li><a href="#">{$iCountCommentUser} комментариев</a></li>
								<li><a href="#">{$iCountBlogsUser} блогов</a></li>
							</ul>
						</div>
						<div class="stat-row">
							<div class="stat-header">В избранном</div>
							<ul>
								<li><a href="#">{$iCountTopicFavourite} топиков</a></li>
								<li><a href="#">{$iCountCommentFavourite} комментариев</a></li>
							</ul>

						</div>
						<div class="stat-row">
							<div class="stat-header">Читает</div>
							<ul>
								<li><a href="#">{$iCountBlogReads} блогов</a></li>
							</ul>

						</div>
						<div class="stat-row">
							<div class="stat-header">Имеет</div>
							<ul>
								<li><a href="#">{$iCountFriendsUser} друзей</a></li>
							</ul>

						</div>

					</div>

					<div class="line-2"></div>

					<div class="stats">
						<h2 class="title mb20">
							Как голосовал
						</h2>

						<div class="stat-row">
							<div class="stat-header"><a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]=topic">За топики</a></div>
							<ul>
								<li><a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]=topic&filter[dir]=plus">{$aUserVotedStat.topic.plus} +</a></li>
								<li><a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]=topic&filter[dir]=minus">{$aUserVotedStat.topic.minus} -</a></li>
							</ul>
						</div>

						<div class="stat-row">
							<div class="stat-header"><a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]=comment">За комментарии</a></div>
							<ul>
								<li><a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]=comment&filter[dir]=plus">{$aUserVotedStat.comment.plus} +</a></li>
								<li><a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]=comment&filter[dir]=minus">{$aUserVotedStat.comment.minus} -</a></li>
							</ul>
						</div>

						<div class="stat-row">
							<div class="stat-header"><a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]=blog">За блоги</a></div>
							<ul>
								<li><a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]=blog&filter[dir]=plus">{$aUserVotedStat.blog.plus} +</a></li>
								<li><a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]=blog&filter[dir]=minus">{$aUserVotedStat.blog.minus} -</a></li>
							</ul>
						</div>

						<div class="stat-row">
							<div class="stat-header"><a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]=user">За юзеров</a></div>
							<ul>
								<li><a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]=user&filter[dir]=plus">{$aUserVotedStat.user.plus} +</a></li>
								<li><a href="{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]=user&filter[dir]=minus">{$aUserVotedStat.user.minus} -</a></li>
							</ul>
						</div>


					</div>

					<div class="line-2"></div>

					<div class="user-fields">
						<div class="contacts">
							<h2 class="title mb20">
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
							<h2 class="title mb20">
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