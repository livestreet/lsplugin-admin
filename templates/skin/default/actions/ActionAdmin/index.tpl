{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content'}

	<div class="dashboard">
		<ul class="top-base-stat-line">
			<li class="users">
				<div>{$aStats.count_all}</div>
				{$aLang.plugin.admin.index.users}
			</li>
			<li class="registrations">
				<div>
					{abs($aUserGrowth.now_items)}
					{if $aUserGrowth.growth>0}
						<span class="green" title="{$aLang.plugin.admin.index.new_users_for_week}: {$aUserGrowth.growth}">&uarr;</span>
					{elseif $aUserGrowth.growth<0}
						<span class="red" title="{$aLang.plugin.admin.index.less_users_for_week}: {abs($aUserGrowth.growth)}">&darr;</span>
					{/if}
				</div>
				{$aLang.plugin.admin.index.registrations}
			</li>
			<li class="topics">
				<div>{$iTotalTopicsCount}</div>
				{$aLang.plugin.admin.index.topics}
			</li>
			<li class="blogs">
				<div>{$iTotalBlogsCount}</div>
				{$aLang.plugin.admin.index.blogs}
			</li>
			<li class="comments">
				<div>{$iTotalCommentsCount}</div>
				{$aLang.plugin.admin.index.comments}
			</li>
		</ul>


		<h3>{$aLang.plugin.admin.index.title}</h3>
		{include file="{$aTemplatePathPlugin.admin}graph.tpl"
			sValueSuffix=$aLang.plugin.admin.users_stats.graph_suffix.$sCurrentGraphType
			aStats=$aDataStats
			sName=$aLang.plugin.admin.users_stats.graph_labels.$sCurrentGraphType
			sUrl={router page='admin'}
			bShowGraphTypeSelect=true
			bShowCustomPeriodFields=true
		}


		<div class="middle-stat-line">
			<div class="plugins">
				<div class="title">Плагины</div>
				<div class="need-update">Есть 2 обновления</div>
			</div>
			<div class="users">
				<div class="title">Пользователи</div>
			</div>
			<div class="feedback">
				<div class="title">Обратная связь</div>
			</div>
		</div>
		<div class="footer-stat-info">
			<div class="w50p">
				<div class="activity">
					{*
						настройка отображения ленты активности
					*}
					<div class="stream-controls fl-r">
						<div class="dropdown-circle js-dropdown" data-dropdown-target="dropdown-user-stats-stream-menu"></div>

						<ul class="dropdown-menu" id="dropdown-user-stats-stream-menu">
							<form action="{router page='admin/ajax-get-index-activity'}" method="post" enctype="application/x-www-form-urlencoded" id="admin_index_activity_form">
								<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />

								<div class="mb-15">
									{$aLang.plugin.admin.index.with_all_checkboxes}:
									<input type="checkbox" class="js-check-all" data-checkboxes-class="js-index-activity-filter" checked="checked" />
								</div>

								{foreach from=array_keys($aEventTypes) item=sEventType}
									<label>
										<input type="checkbox" name="filter[{$sEventType}]" checked="checked" value="1" class="js-index-activity-filter" />
										{$aLang.plugin.admin.index.activity_type.$sEventType}
									</label>
								{/foreach}

								<button type="submit" name="submit_change_activity_settings" class="button">{$aLang.plugin.admin.save}</button>
							</form>
						</ul>
					</div>

					<div class="label-header">
						<h3>{$aLang.plugin.admin.index.activity}</h3>
					</div>

					<div class="content-data">
						<script>
							/*
							 	хак для использования файла активности. в конце там приварено присваивание в жс активности, но он нам не нужен
							 */
							ls = ls || {};
							ls.stream = ls.stream || {};
						</script>
						{*
							всегда сначала загружается вся лента
						*}
						{include file='actions/ActionStream/event_list.tpl' sActivityType='all'}
					</div>
				</div>
			</div>
			<div class="w50p fl-r">
				<div class="new-events">
					<div class="label-header">
						<h3>{$aLang.plugin.admin.index.new_items}</h3>
						<form action="" method="get" enctype="application/x-www-form-urlencoded" id="admin_index_growth_block_form">
							<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
							<select name="filter[newly_added_items_period]" class="width-150" id="admin_index_growth_period_select">
								<option value="{PluginAdmin_ModuleStats::TIME_INTERVAL_TODAY}"
										{if $_aRequest.filter.newly_added_items_period==PluginAdmin_ModuleStats::TIME_INTERVAL_TODAY}selected="selected"{/if}>{$aLang.plugin.admin.index.period_bar.today}</option>
								<option value="{PluginAdmin_ModuleStats::TIME_INTERVAL_YESTERDAY}"
										{if $_aRequest.filter.newly_added_items_period==PluginAdmin_ModuleStats::TIME_INTERVAL_YESTERDAY}selected="selected"{/if}>{$aLang.plugin.admin.index.period_bar.yesterday}</option>
								<option value="{PluginAdmin_ModuleStats::TIME_INTERVAL_WEEK}"
										{if $_aRequest.filter.newly_added_items_period==PluginAdmin_ModuleStats::TIME_INTERVAL_WEEK}selected="selected"{/if}>{$aLang.plugin.admin.index.period_bar.week}</option>
								<option value="{PluginAdmin_ModuleStats::TIME_INTERVAL_MONTH}"
										{if $_aRequest.filter.newly_added_items_period==PluginAdmin_ModuleStats::TIME_INTERVAL_MONTH}selected="selected"{/if}>{$aLang.plugin.admin.index.period_bar.month}</option>
							</select>
						</form>
					</div>
					<div class="content-data" id="admin_index_new_items_block">
						{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/index/new_items_table.tpl"}
					</div>
				</div>
			</div>
		</div>
		<div class="info">
			{*
				данные о последнем входе пользователя в админку
			*}
			{if $aLastVisitData.date}
				Последний раз заходили в админку {date_format date=$aLastVisitData.date format="j F Y в H:i"}.
				{if !$aLastVisitData.same_ip}
					Предыдущий вход был выполнен из другого ip - <b>{$aLastVisitData.ip}</b>, текущий ip - <b>{func_getIp()}</b>.
				{/if}
			{else}
				Это ваше первое знакомство с админкой для LiveStreet CMS. Будем надеятся что она вам понравится и работа с ней будет удобной.
			{/if}
		</div>
	</div>

{/block}