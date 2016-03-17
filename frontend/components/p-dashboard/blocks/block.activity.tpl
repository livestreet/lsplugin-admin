{**
 * Активность
 *}

{component_define_params params=[ 'events', 'count' ]}

{component 'admin:block'
	title=$aLang.plugin.admin.users_stats.activity
	content={component 'activity' events=$events count=$count classes='p-dashboard-activity js-dashboard-activity'}}