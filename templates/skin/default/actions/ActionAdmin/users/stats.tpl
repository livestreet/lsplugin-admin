{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}


{block name='layout_content_toolbar'}
	<a class="button {if $sCurrentGraphPeriod=='yesterday'}active{/if}" href="{router page='admin/users/stats'}{request_filter
		name=array('graph_period')
		value=array('yesterday')
	}">Вчера</a>
	<a class="button {if $sCurrentGraphPeriod=='today'}active{/if}" href="{router page='admin/users/stats'}{request_filter
		name=array('graph_period')
		value=array('today')
	}">Сегодня</a>
	<a class="button {if $sCurrentGraphPeriod=='week'}active{/if}" href="{router page='admin/users/stats'}{request_filter
		name=array('graph_period')
		value=array('week')
	}">Неделя</a>
	<a class="button {if $sCurrentGraphPeriod=='month'}active{/if}" href="{router page='admin/users/stats'}{request_filter
		name=array('graph_period')
		value=array('month')
	}">Месяц</a>

{/block}


{block name='layout_page_title'}
	<div class="fl-r users-stats-headline">
		<div class="count">
			{number_format($aStats.count_all, 0, '.', ' ')}
		</div>
		пользователей
	</div>
	Статистика
{/block}


{block name='layout_content'}
	<div class="users-stats">
		<h3>Регистрации</h3>
		<div class="graph">
			<div id="admin_users_graph_container"></div>
			<script>
				jQuery(document).ready(function($) {
					// docs: api.highcharts.com/highcharts
					Highcharts.setOptions({
						lang: {
							resetZoom: 'Сбросить зум',
							resetZoomTitle: 'Показать 1 к 1'
						}
					});
					$('#admin_users_graph_container').highcharts({
						chart: {
							type: 'areaspline',
							height: 200,
							//margin: 0,			// hides axis
							spacingBottom: 0,
							spacingLeft: 0,
							spacingRight: 0,
							spacingTop: 10,
							zoomType: 'x'
						},
						title: {
							text: ''
						},
						yAxis: {
							title: {
								text: ''
							},
							gridLineColor: '#f1f1f1',
							gridLineWidth: 1,
							allowDecimals: false
						},
						tooltip: {
							animation: false,
							shadow: false,
							borderWidth: 0,
							// .highcharts-tooltip
							shared: true,
							valueSuffix: ' пользователей'
						},
						credits: {
							enabled: false
						},
						legend: {
							enabled: false
						},
						plotOptions: {
							areaspline: {
								fillOpacity: 0.5
							}
						},
						xAxis: {
							categories: [
								{foreach from=$aUserRegistrationStats item=aUserRegData}
									'{$aUserRegData['registration_date']}'{if !$aUserRegData.last},{/if}
								{/foreach}
							]
						},
						series: [{
							name: 'Регистрации',
							color: '#8FCFEA',
							data: [
								{foreach from=$aUserRegistrationStats item=aUserRegData name=UsersRegCycle}
									[{$smarty.foreach.UsersRegCycle.index}, {$aUserRegData['count']}]{if !$aUserRegData.last},{/if}
								{/foreach}
							]
						}]
					});
				});
			</script>
		</div>
		<div class="value-in-table">
			<a href="#" id="admin_users_show_graph_stats_in_table">значения таблицей</a>
			<div id="admin_users_graph_table_stats_data">
				<table>
					<thead>
						<tr>
							<th>#</th>
							<th>Дата</th>
							<th>Количество</th>
						</tr>
					</thead>
					<tbody>
						{foreach from=$aUserRegistrationStats item=aUserRegData name=UsersRegCycle}
							<tr>
								<td>
									{$smarty.foreach.UsersRegCycle.iteration}
								</td>
								<td>
									{$aUserRegData['registration_date']}
								</td>
								<td>
									{$aUserRegData['count']}
								</td>
							</tr>
						{/foreach}
					</tbody>
				</table>
			</div>
		</div>
		<div class="stat-line">
			<div class="w50p first-block">
				<h3>Гендерное распределение</h3>
				{*
					значения для каждого пола в процентах
				*}
				{assign var="iUsersSexOtherPerc" value=number_format(($aStats.count_sex_other*100/$aStats.count_all), 1, '.', '')}
				{assign var="iUsersSexManPerc" value=number_format(($aStats.count_sex_man*100/$aStats.count_all), 1, '.', '')}
				{assign var="iUsersSexWomanPerc" value=number_format(($aStats.count_sex_woman*100/$aStats.count_all), 1, '.', '')}

				<div class="users-sex-pie-stats">
					<div id="admin_users_sex_pie_graph"></div>
					<script>
						{*
							график гендерного распределения пользователей
						*}
						jQuery(document).ready(function($) {
							$('#admin_users_sex_pie_graph').highcharts({
								chart: {
									plotBackgroundColor: null,
									plotBorderWidth: null,
									plotShadow: false,
									height: 150,
									width: 150,
									//margin: 0,			// hides axis
									spacingBottom: 0,
									spacingLeft: 0,
									spacingRight: 0,
									spacingTop: 0
								},
								title: {
									text: ''
								},
								tooltip: {
									animation: false,
									shadow: false,
									borderWidth: 0
									// .highcharts-tooltip
								},
								credits: {
									enabled: false
								},
								plotOptions: {
									pie: {
										allowPointSelect: true,
										cursor: 'pointer',
										dataLabels: {
											enabled: false
										}
									}
								},
								series: [{
									type: 'pie',
									name: '% от всех',
									data: [
										{
											name: 'Пол не указан',
											y: {$iUsersSexOtherPerc},
											color: '#F5F1FF'
										},
										{
											name: 'Мужчины',
											y: {$iUsersSexManPerc},
											color: '#94E3E6'
										},
										{
											name: 'Женщины',
											y: {$iUsersSexWomanPerc},
											color: '#FACBFF'
										}
									]
								}]
							});
						});
					</script>
				</div>
				<div class="users-sex-table-stats">
					<table>
						<thead></thead>
						<tbody>
						<tr>
							<td>
								<span class="users-sex-indicator other"></span>
								Пол не указан
							</td>
							<td class="text-right">
								{$aStats.count_sex_other}
							</td>
							<td class="text-right">
								{$iUsersSexOtherPerc} %
							</td>
						</tr>
						<tr>
							<td>
								<span class="users-sex-indicator man"></span>
								Мужчины
							</td>
							<td class="text-right">
								{$aStats.count_sex_man}
							</td>
							<td class="text-right">
								{$iUsersSexManPerc} %
							</td>
						</tr>
						<tr>
							<td>
								<span class="users-sex-indicator woman"></span>
								Женщины
							</td>
							<td class="text-right">
								{$aStats.count_sex_woman}
							</td>
							<td class="text-right">
								{$iUsersSexWomanPerc} %
							</td>
						</tr>
						<tr>
							<td>
								<hr>		{* просто временный разделитель *}
							</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>
								Всего
							</td>
							<td class="text-right">
								{$aStats.count_all}
							</td>
							<td>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="w50p second-block">
				<h3>Активность</h3>
				<table>
					<thead></thead>
					<tbody>
						<tr>
							<td>
								Активные
							</td>
							<td class="text-right">
								{$aStats.count_active}
							</td>
							<td class="text-right">
								{number_format(($aStats.count_active*100/$aStats.count_all), 1, '.', '')} %
							</td>
						</tr>
						<tr>
							<td>
								Заблудившиеся
							</td>
							<td class="text-right">
								{$aStats.count_inactive}
							</td>
							<td class="text-right">
								{number_format(($aStats.count_inactive*100/$aStats.count_all), 1, '.', '')} %
							</td>
						</tr>
					</tbody>
				</table>

			</div>
		</div>
		{if $aBirthdaysStats and $aBirthdaysStats.collection and count($aBirthdaysStats.collection)>0}
			<div class="users-age">
				<h3>Возрастное распределение</h3>
				{if count($aBirthdaysStats.collection)<100}
					<div class="mb-20">
						У вас очень мало пользователей либо сайт ещё слишком молод чтобы показать красивый график.
					</div>
				{/if}
				<ul class="age-stats">
					{foreach from=$aBirthdaysStats.collection item=aAgeRecord name=AgeCycle}
						{*
							высота столбика в процентах
						*}
						{assign var=iHeight value=$aAgeRecord.count*100/$aBirthdaysStats.max_one_age_users_count}
						{*
							смещение каждого столбика и подписи в пикселях относительно соседа на 15px
						*}
						{assign var=iOffset value=$smarty.foreach.AgeCycle.index*15}
						<li class="holder">
							{*
								задать высоту и смещение каждого столбика относительно соседа
							*}
							<div class="age-item" style="height: {$iHeight}%; left: {$iOffset}px;" title="{$aAgeRecord.count} пользователей"></div>
							{*
								сделать подпись к столбику и смещение каждой подписи относительно соседа,
								каждая вторая запись будет немного светлее чтобы цифры не сливались в кашу
							*}
							<div class="years {if $smarty.foreach.AgeCycle.iteration % 2 == 0}second{/if}"
								 style="left: {$iOffset}px;" title="{$aAgeRecord.count} пользователей">
								{$aAgeRecord.years_old}
							</div>
						</li>
					{/foreach}
				</ul>
			</div>
		{/if}

		{if $aLivingStats and $aLivingStats.collection and count($aLivingStats.collection)>0}
			<div class="countries-n-cities">
				<div class="fl-r">
					<a href="{router page='admin/users/stats'}{request_filter
					name=array('living_sorting')
					value=array('alphabetic')
					}" class="button {if $sCurrentLivingSorting=='alphabetic'}active{/if}">A-z &darr;</a>

					<a href="{router page='admin/users/stats'}{request_filter
					name=array('living_sorting')
					value=array(null)
					}" class="button {if $sCurrentLivingSorting=='top'}active{/if}">3-2-1 &darr;</a>
				</div>
				<h3>
					{if $sCurrentLivingSection=='countries'}
						Страны и
						<a href="{router page='admin/users/stats'}{request_filter
						name=array('living_section')
						value=array('cities')
						}">города</a>
					{elseif $sCurrentLivingSection=='cities'}
						<a href="{router page='admin/users/stats'}{request_filter
						name=array('living_section')
						value=array(null)
						}">Страны</a>
						и города
					{/if}
				</h3>

				{if count($aLivingStats.collection)<100}
					<div class="mb-20">
						У вас очень мало пользователей либо сайт ещё слишком молод чтобы показать красивый график.
					</div>
				{/if}
				<table class="items">
					<thead></thead>
					<tbody>
						{foreach from=$aLivingStats.collection item=aItemRecord name=ItemsCycle}
							{*
								длина столбика в процентах
							*}
							{assign var=iPercentage value=number_format($aItemRecord.count*100/$aStats.count_all, 2, '.', '')}
							<tr {if $smarty.foreach.ItemsCycle.iteration % 2 == 0}class="second"{/if}>
								<td class="item">
									{$aItemRecord.item}
								</td>
								<td class="count">
									{$aItemRecord.count}
								</td>
								<td class="percentage">
									{$iPercentage} %
								</td>
								<td class="diagram">
									{*
										задать ширину каждого столбика
									*}
									<div class="view-item-wrapper">
										<div class="view-item" style="width: {$iPercentage}%;" title="{$aItemRecord.count} пользователей"></div>
									</div>
								</td>
							</tr>
						{/foreach}
					</tbody>
				</table>
			</div>
		{/if}

	</div>

{/block}