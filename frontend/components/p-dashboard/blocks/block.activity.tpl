{**
 * Активность
 *}

{component_define_params params=[ 'events', 'count' ]}

{*block name='block_header_end'}
	<button class="button button-icon js-dropdown" data-dropdown-target="dropdown-admin-index-stream-menu" id="dropdown-admin-index-stream-menu-trigger">
		<i class="icon-settings-14"></i>
	</button>

	<div class="dropdown-menu p15" id="dropdown-admin-index-stream-menu">
		<form action="{router page='admin/ajax-get-index-activity'}" method="post" enctype="application/x-www-form-urlencoded" id="admin_index_activity_form">
			<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />

			<div class="mb-15">
				{$aLang.plugin.admin.index.with_all_checkboxes}:
				<input type="checkbox" class="js-check-all" data-checkboxes-class="js-index-activity-filter" checked="checked" />
			</div>

			{foreach from=$aEventTypes item=sEventType}
				<label>
					<input type="checkbox" name="filter[{$sEventType}]" checked="checked" value="1" class="js-index-activity-filter" />
					{$aLang.plugin.admin.index.activity_type.$sEventType}
				</label>
			{/foreach}

			<button type="submit" name="submit_change_activity_settings" class="button button-primary mt-20">{$aLang.plugin.admin.save}</button>
		</form>
	</div>
{/block*}

{component 'admin:block'
	title=$aLang.plugin.admin.users_stats.activity
	content={component 'activity' events=$events count=$count classes='p-dashboard-activity js-dashboard-activity'}}