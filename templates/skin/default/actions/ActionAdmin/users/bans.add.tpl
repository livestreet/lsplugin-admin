{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}
	<h2 class="title mb20">
		{$aLang.plugin.admin.bans.add}
	</h2>

	<div class="top-controls mb-20">
		<a class="" href="{router page='admin/users/bans'}">{$aLang.plugin.admin.bans.back_to_list}</a>
	</div>

	<div class="ban-page">
		<form action="{router page='admin/users/bans/add'}" method="post" enctype="application/x-www-form-urlencoded">
			<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />

			<div class="ban-part-wrapper">
				<h3>Идентификация пользователя</h3>
				<div class="usersign mb-20">
					<div class="mb-10">
						Введите id (1091), логин (userlogin), почту (user@mail.com),
						ip-адрес (192.168.0.10) или диапазон ip-адресов (192.168.0.10 - 192.168.0.100) пользователя:
					</div>
					<input type="text" name="user_sign" class="input-text width-250" />		{* todo: on blur - check correct and if user exists *}
				</div>
			</div>

			<div class="ban-part-wrapper">
				<h3>Строк действия</h3>
				<div class="block-period mb-20">
					<div class="mb-10">
						Время бана:
					</div>

					<div class="one-param">
						<div class="right-info">
							Пользователь с указанными данными не сможет войти на сайт никогда.
							Следует применять данный метод в случае если указанный пользователь - бот и рассылает спам.
							Примечание: у некоторых пользователей айпи адрес не статичен.
						</div>
						<label>
							<input type="radio" name="bantype[]" value="unlimited" />
							Пожизненно
						</label>
					</div>

					<div class="one-param">
						<div class="right-info">
							Пользователь не сможет получить доступ к сайту на период времени
							<br />
							с <input type="text" name="period_from" value="" class="input-text width-100 date-picker" />
							&nbsp;&nbsp;&nbsp;
							по <input type="text" name="period_to" value="" class="input-text width-100 date-picker" />
							<br />
							По проишествии указанного времени пользователь автоматически сможет получить доступ к сайту.
						</div>
						<label>
							<input type="radio" name="bantype[]" value="period" />
							На период времени
						</label>
					</div>

					<div class="one-param">
						<div class="right-info">
							Пользователь не сможет получить доступ к сайту на указанное количество дней начиная с текущего
							<br />
							<input type="text" name="days_count" value="" class="input-text width-100" /> дней
							<br />
							По проишествии указанного времени пользователь автоматически сможет получить доступ к сайту.
						</div>
						<label>
							<input type="radio" name="bantype[]" value="days" />
							На количество дней
						</label>
					</div>
				</div>
			</div>

			<div class="ban-part-wrapper">
				<h3>Комментарии</h3>
				<div class="blocking-reason mb-20">
					<div class="mb-10">
						Укажите причину блокировки, которая будет видна пользователю (если нужно):
						<br />
						<input type="text" name="reason_for_user" value="" class="input-text width-400" />
					</div>
					<div class="mb-10">
						Укажите заметку для себя (видна только администраторам на странице списка банов):
						<br />
						<input type="text" name="reason_comment" value="" class="input-text width-400" />
					</div>
				</div>
			</div>

			<input type="submit" value="Ok" class="button button-primary" name="submit_add_ban" />
		</form>
	</div>
		
{/block}