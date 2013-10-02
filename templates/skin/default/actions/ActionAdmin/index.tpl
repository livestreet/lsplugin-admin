{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}

	<div class="dashboard">
		<ul class="top-base-stat-line">
			<li class="users">
				<div>{$aStats.count_all}</div>
				пользователей
			</li>
			<li class="registrations">
				<div title="новых пользователей по сравнению с прошлой неделей">
					{abs($iUserGrowth)}
					{if $iUserGrowth>0}<span class="green">&uarr;</span>{elseif $iUserGrowth<0}<span class="red">&darr;</span>{/if}
				</div>
				регистраций
			</li>
			<li class="topics">
				<div>{$iTotalTopicsCount}</div>
				топиков
			</li>
			<li class="blogs">
				<div>{$iTotalBlogsCount}</div>
				блогов
			</li>
		</ul>
		<div class="graph">
			{*
				попап меню с выбором периода и типа графика
			*}
			<div class="popup-params-select fl-r">
				<form action="{router page='admin'}" enctype="application/x-www-form-urlencoded" method="get">
					Отображать:
					<select name="filter[graph_type]" class="width-150">
						<option value="{PluginAdmin_ModuleStats::DATA_TYPE_REGISTRATIONS}"
								{if $sCurrentGraphType==PluginAdmin_ModuleStats::DATA_TYPE_REGISTRATIONS}selected="selected"{/if}>Регистрации</option>
						<option value="{PluginAdmin_ModuleStats::DATA_TYPE_TOPICS}"
								{if $sCurrentGraphType==PluginAdmin_ModuleStats::DATA_TYPE_TOPICS}selected="selected"{/if}>Новые топики</option>
						<option value="{PluginAdmin_ModuleStats::DATA_TYPE_COMMENTS}"
								{if $sCurrentGraphType==PluginAdmin_ModuleStats::DATA_TYPE_COMMENTS}selected="selected"{/if}>Комментарии</option>
						<option value="{PluginAdmin_ModuleStats::DATA_TYPE_VOTINGS}"
								{if $sCurrentGraphType==PluginAdmin_ModuleStats::DATA_TYPE_VOTINGS}selected="selected"{/if}>Голосования</option>
					</select>
					Период:
					<select name="filter[graph_period]" class="width-150">
						<option value="{PluginAdmin_ModuleStats::TIME_INTERVAL_TODAY}"
								{if $sCurrentGraphPeriod==PluginAdmin_ModuleStats::TIME_INTERVAL_TODAY}selected="selected"{/if}>Сегодня</option>
						<option value="{PluginAdmin_ModuleStats::TIME_INTERVAL_YESTERDAY}"
								{if $sCurrentGraphPeriod==PluginAdmin_ModuleStats::TIME_INTERVAL_YESTERDAY}selected="selected"{/if}>Вчера</option>
						<option value="{PluginAdmin_ModuleStats::TIME_INTERVAL_WEEK}"
								{if $sCurrentGraphPeriod==PluginAdmin_ModuleStats::TIME_INTERVAL_WEEK}selected="selected"{/if}>Неделя</option>
						<option value="{PluginAdmin_ModuleStats::TIME_INTERVAL_MONTH}"
								{if $sCurrentGraphPeriod==PluginAdmin_ModuleStats::TIME_INTERVAL_MONTH}selected="selected"{/if}>Месяц</option>
					</select>

					<input type="submit" value="Показать" class="button" />
				</form>
			</div>

			<h3>Статистика</h3>
			<div class="graph_wrapper">
				{include file="{$aTemplatePathPlugin.admin}/graph.tpl"
					sValueSuffix=$aLang.plugin.admin.users_stats.graph_suffix.$sCurrentGraphType
					aStats=$aDataStats
					sName=$aLang.plugin.admin.users_stats.graph_labels.$sCurrentGraphType
				}
			</div>
		</div>
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
					<div class="label-header">
						<h3>Активность</h3>
					</div>

					<div class="content-data">
						{include file='actions/ActionStream/event_list.tpl' sActivityType='all'}
					</div>
				</div>
			</div>
			<div class="w50p fl-r">
				<div class="new-events">
					<div class="label-header">
						<h3>Добавилось</h3>
						<form action="" method="get" enctype="application/x-www-form-urlencoded">
							<select name="filter[newly_added_items_period]" class="width-150" id="admin_index_growth_period_select">
								<option value="{PluginAdmin_ModuleStats::TIME_INTERVAL_TODAY}"
										{if $_aRequest.filter.newly_added_items_period==PluginAdmin_ModuleStats::TIME_INTERVAL_TODAY}selected="selected"{/if}>Сегодня</option>
								<option value="{PluginAdmin_ModuleStats::TIME_INTERVAL_YESTERDAY}"
										{if $_aRequest.filter.newly_added_items_period==PluginAdmin_ModuleStats::TIME_INTERVAL_YESTERDAY}selected="selected"{/if}>Вчера</option>
								<option value="{PluginAdmin_ModuleStats::TIME_INTERVAL_WEEK}"
										{if $_aRequest.filter.newly_added_items_period==PluginAdmin_ModuleStats::TIME_INTERVAL_WEEK}selected="selected"{/if}>Неделя</option>
								<option value="{PluginAdmin_ModuleStats::TIME_INTERVAL_MONTH}"
										{if $_aRequest.filter.newly_added_items_period==PluginAdmin_ModuleStats::TIME_INTERVAL_MONTH}selected="selected"{/if}>Месяц</option>
							</select>
						</form>
					</div>
					<div class="content-data">
						<table class="items-added">
							<thead></thead>
							<tbody>
								<tr title="новых топиков по сравнению с прошлым аналогичным периодом">
									<td class="name">
										Топиков
									</td>
									<td class="growth">
										{abs($aDataGrowth.topics.count)}
										{if $aDataGrowth.topics.count>0}
											<span class="green">&uarr;</span>
										{elseif $aDataGrowth.topics.count<0}
											<span class="red">&darr;</span>
										{/if}
									</td>
									<td class="voting-line">
										{* todo *}

										p: {$aDataGrowth.topics.votings.plus},
										m: {$aDataGrowth.topics.votings.minus},
										a: {$aDataGrowth.topics.votings.abstained},
										t: {$aDataGrowth.topics.votings.total_votes}
									</td>
								</tr>
								<tr title="новых комментариев по сравнению с прошлым аналогичным периодом">
									<td class="name">
										Комментариев
									</td>
									<td class="growth">
										{abs($aDataGrowth.comments.count)}
										{if $aDataGrowth.comments.count>0}
											<span class="green">&uarr;</span>
										{elseif $aDataGrowth.comments.count<0}
											<span class="red">&darr;</span>
										{/if}
									</td>
									<td class="voting-line">
										{include file="{$aTemplatePathPlugin.admin}/actions/ActionAdmin/index/new_items_voting_stats.tpl" sDataType='comments'}
									</td>
								</tr>
								<tr title="новых блогов по сравнению с прошлым аналогичным периодом">
									<td class="name">
										Блогов
									</td>
									<td class="growth">
										{abs($aDataGrowth.blogs.count)}
										{if $aDataGrowth.blogs.count>0}
											<span class="green">&uarr;</span>
										{elseif $aDataGrowth.blogs.count<0}
											<span class="red">&darr;</span>
										{/if}
									</td>
									<td class="voting-line">
										{* todo *}

										p: {$aDataGrowth.blogs.votings.plus},
										m: {$aDataGrowth.blogs.votings.minus},
										a: {$aDataGrowth.blogs.votings.abstained},
										t: {$aDataGrowth.blogs.votings.total_votes}
									</td>
								</tr>
								<tr title="новых пользователей по сравнению с прошлым аналогичным периодом">
									<td class="name">
										Регистраций
									</td>
									<td class="growth">
										{abs($aDataGrowth.registrations.count)}
										{if $aDataGrowth.registrations.count>0}
											<span class="green">&uarr;</span>
										{elseif $aDataGrowth.registrations.count<0}
											<span class="red">&darr;</span>
										{/if}
									</td>
									<td class="voting-line">
										{* todo *}

										p: {$aDataGrowth.registrations.votings.plus},
										m: {$aDataGrowth.registrations.votings.minus},
										a: {$aDataGrowth.registrations.votings.abstained},
										t: {$aDataGrowth.registrations.votings.total_votes}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="info">
			{* данные о последнем входе пользователя в админку *}
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