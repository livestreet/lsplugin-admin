{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}

	<div class="dashboard">
		<ul class="top-base-stat-line">
			<li class="users">
				<div>323</div>
				пользователей
			</li>
			<li class="topics">
				<div>43</div>
				топиков
			</li>
			<li class="blogs">
				<div>32</div>
				блогов
			</li>
		</ul>
		<div class="graph">
			<h3>
				Статистика <span id="admin_dashboard_graph_type_select">Регистрации</span>
			</h3>
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