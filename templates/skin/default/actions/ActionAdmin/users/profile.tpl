{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}
	{assign var="oSession" value=$oUser->getSession()}
	<h2 class="title mb20">
		{$aLang.plugin.admin.users.title}
	</h2>

	<div class="profile-info-wrapper">
		<div class="top-controls">
			wr, msg

		</div>
		<div class="inner-data">
			<ul class="profile-links">
				<li><a href="#">Профиль</a></li>
				<li><a href="#">Публикации</a></li>
				<li><a href="#">Активность</a></li>
				<li><a href="#">Друзья</a></li>
				<li><a href="#">Жалобы</a></li>
				<li><a href="#">Счет</a></li>
				<li><a href="#">Стена</a></li>
				<li><a href="#">Блоги</a></li>
				<li><a href="#">Избранное</a></li>
				<li><a href="#">Почта</a></li>
				<li><a href="#">Права</a></li>
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
							<a href="{router page='admin/users/profile'}{$oUser->getId()}">{$oUser->getLogin()}</a>
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
						Добавить заметку
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
								name=array('q', 'field[]')
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
								name=array('q', 'field[]')
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
									name=array('q', 'field[]')
									value=array($oSession->getIpLast(), 'session_ip_last')
									}">{$oSession->getIpLast()}</a>

									<br />
									<a href="{router page='admin/users/list'}{request_filter
									name=array('q', 'field[]')
									value=array($oSession->getIpLast(), 'session_ip_last')
									}" class="button mt-10">Искать с этим IP</a>
								</dd>
							</dl>
						{/if}


					</div>

					<div class="line-2"></div>

					<div class="stats">
						stats

					</div>
					<div class="contacts">
						contacts
					</div>
				</div>

			</div>

		</div>
	</div>

{/block}