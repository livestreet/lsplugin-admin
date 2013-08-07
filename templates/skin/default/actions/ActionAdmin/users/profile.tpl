{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}
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
							<a href="{router page='admin'}users/profile/{$oUser->getId()}">{$oUser->getLogin()}</a>
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
						<input type="text" name="user-skill" class="input-text width-50">
					</div>
					<div class="rating">
						R:
						<input type="text" name="user-rating" class="input-text width-50">
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
					<div class="resume">
						resume

					</div>
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