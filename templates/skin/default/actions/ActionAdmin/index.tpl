{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}

	<div class="dashboard">
		<ul class="top-base-stat-line">
			<li class="users">
				<div>{$aStats.count_all}</div>
				пользователей
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
						<option value="regs" {if $sCurrentGraphType==PluginAdmin_ModuleStats::GRAPH_TYPE_REGS}selected="selected"{/if}>Регистрации</option>
						<option value="topics" {if $sCurrentGraphType==PluginAdmin_ModuleStats::GRAPH_TYPE_TOPICS}selected="selected"{/if}>Новые топики</option>
						<option value="comments" {if $sCurrentGraphType==PluginAdmin_ModuleStats::GRAPH_TYPE_COMMENTS}selected="selected"{/if}>Комментарии</option>
						<option value="votings" {if $sCurrentGraphType==PluginAdmin_ModuleStats::GRAPH_TYPE_VOTINGS}selected="selected"{/if}>Голосования</option>
					</select>
					Период:
					<select name="filter[graph_period]" class="width-150">
						<option value="yesterday" {if $sCurrentGraphPeriod==PluginAdmin_ModuleStats::GRAPH_TIME_YESTERDAY}selected="selected"{/if}>Вчера</option>
						<option value="today" {if $sCurrentGraphPeriod==PluginAdmin_ModuleStats::GRAPH_TIME_TODAY}selected="selected"{/if}>Сегодня</option>
						<option value="week" {if $sCurrentGraphPeriod==PluginAdmin_ModuleStats::GRAPH_TIME_WEEK}selected="selected"{/if}>Неделя</option>
						<option value="month" {if $sCurrentGraphPeriod==PluginAdmin_ModuleStats::GRAPH_TIME_MONTH}selected="selected"{/if}>Месяц</option>
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
					<h3>Активность</h3>
					<div class="content-data">
						{include file='actions/ActionStream/event_list.tpl' sActivityType='all'}
					</div>
				</div>
			</div>
			<div class="w50p fl-r">
				<div class="new-events">
					<h3>Добавилось</h3>
					<div class="content-data">
						список
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