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
					<input type="text" name="filter[date_start]" value="{$_aRequest.filter.date_start}" class="input-text width-100 date-picker-php" placeholder="{date('Y-m-d')}" />
					&nbsp;&ndash;&nbsp;
					<input type="text" name="filter[date_finish]" value="{$_aRequest.filter.date_finish}" class="input-text width-100 date-picker-php" placeholder="{date('Y-m-d')}" />
					{if $_aRequest.filter.date_start}
						<a href="{router page='admin'}{request_filter
						name=array('date_start', 'date_finish')
						value=array(null, null)
						}" class="remove-custom-period-selection"><i class="icon-remove"></i></a>
					{/if}

					<select id="admin_dashboard_graph_type_select" class="width-150">
						<option value="registrations">Регистрации</option>
						<option value="topics">Новые топики</option>
						<option value="comments">Комментарии</option>
						<option value="votings">Голосования</option>
					</select>

					<input type="submit" value="Показать" class="button" />
				</form>
			</div>

			<h3>Статистика</h3>
			<div class="graph_wrapper">

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