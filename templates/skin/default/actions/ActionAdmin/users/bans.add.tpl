{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}
	<h2 class="title mb-20">
		{$aLang.plugin.admin.bans.add.title}
	</h2>

	<div class="top-controls mb-20">
		<a href="{router page='admin/users/bans'}">{$aLang.plugin.admin.bans.back_to_list}</a>
	</div>

	<div class="ban-page">
		<form action="{router page='admin/users/bans/add'}" method="post" enctype="application/x-www-form-urlencoded">
			<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
			<input type="hidden" name="ban_id" value="{$_aRequest.id}" />

			<div class="ban-part-wrapper">
				<h3>{$aLang.plugin.admin.bans.add.user_sign}</h3>
				<div class="usersign mb-20">
					<div class="mb-10">
						{$aLang.plugin.admin.bans.add.user_sign_info}:
					</div>
					<input type="text" name="user_sign" class="input-text width-250" placeholder="spamuser" value="{$_aRequest.user_sign}" required="" id="admin_bans_user_sign" />
					<span id="admin_bans_checking_msg"></span>
				</div>
			</div>

			<div class="ban-part-wrapper">
				<h3 class="mb-30">{$aLang.plugin.admin.bans.add.ban_time_title}</h3>
				<div class="block-period mb-20">
					<div class="one-param">
						<label>
							<input type="radio" name="bantype[]" value="unlimited"
								   {if in_array('unlimited', (array) $_aRequest.bantype) or is_null($_aRequest.bantype)}checked="checked"{/if} />
							{$aLang.plugin.admin.bans.add.ban_timing.unlimited}
						</label>
						<div class="right-info">
							{$aLang.plugin.admin.bans.add.ban_timing.unlimited_info}
						</div>
					</div>

					<div class="one-param">
						<label>
							<input type="radio" name="bantype[]" value="period"
								   {if in_array('period', (array) $_aRequest.bantype)}checked="checked"{/if} />
							{$aLang.plugin.admin.bans.add.ban_timing.period}
						</label>
						<div class="right-info">
							{$aLang.plugin.admin.bans.add.ban_timing.period_info}
							<br />
							{$aLang.plugin.admin.from}
							<input type="text" name="date_start" value="{$_aRequest.date_start}" class="input-text width-150 date-picker-php" placeholder="{date('Y-m-d')}" />
							&nbsp;&nbsp;&nbsp;
							{$aLang.plugin.admin.to}
							<input type="text" name="date_finish" value="{$_aRequest.date_finish}" class="input-text width-150 date-picker-php" placeholder="2030-01-01" />
							<br />
							{$aLang.plugin.admin.bans.add.ban_timing.period_info2}
						</div>
					</div>

					<div class="one-param">
						<label>
							<input type="radio" name="bantype[]" value="days"
								   {if in_array('days', (array) $_aRequest.bantype)}checked="checked"{/if} />
							{$aLang.plugin.admin.bans.add.ban_timing.days}
						</label>
						<div class="right-info">
							{$aLang.plugin.admin.bans.add.ban_timing.days_info}
							<br />
							<input type="text" name="days_count" value="{$_aRequest.days_count}" class="input-text width-100" placeholder="31" />
							{$aLang.plugin.admin.bans.add.ban_timing.days_left}
							<br />
							{$aLang.plugin.admin.bans.add.ban_timing.period_info2}
						</div>
					</div>
				</div>
			</div>

			<div class="ban-part-wrapper">
				<h3>{$aLang.plugin.admin.bans.add.comments}</h3>
				<div class="blocking-reason mb-20">
					<div class="mb-10">
						{$aLang.plugin.admin.bans.add.reason}:
						<br />
						<input type="text" name="reason_for_user" value="{$_aRequest.reason_for_user}" class="input-text width-400" placeholder="Slow down, cowboy, spam elsewhere" />
					</div>
					<div class="mb-10">
						{$aLang.plugin.admin.bans.add.comment_for_yourself}:
						<br />
						<input type="text" name="comment" value="{$_aRequest.comment}" class="input-text width-400" placeholder="spammer" />
					</div>
				</div>
			</div>

			<input type="submit" value="Ok" class="button button-primary" name="submit_add_ban" />
		</form>
	</div>
		
{/block}