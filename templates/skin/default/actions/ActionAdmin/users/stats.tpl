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
		<div class="graph">
			график
		</div>
		<div class="value-in-table">
			значения таблицей
		</div>
		<div class="stat-line">
			<div class="w50p">
				<h3>Гендерное распределение</h3>
				<table>
					<thead></thead>
					<tbody>
						<tr>
							<td>
								Пол не указан
							</td>
							<td>
								{$aStats.count_sex_other}
							</td>
							<td>
								{number_format(($aStats.count_sex_other*100/$aStats.count_all), 1, '.', '')} %
							</td>
						</tr>
						<tr>
							<td>
								Мужчины
							</td>
							<td>
								{$aStats.count_sex_man}
							</td>
							<td>
								{number_format(($aStats.count_sex_man*100/$aStats.count_all), 1, '.', '')} %
							</td>
						</tr>
						<tr>
							<td>
								Женщины
							</td>
							<td>
								{$aStats.count_sex_woman}
							</td>
							<td>
								{number_format(($aStats.count_sex_woman*100/$aStats.count_all), 1, '.', '')} %
							</td>
						</tr>
						<tr>
							<td>
								<hr>		{* просто временный разделитель *}
							</td>
							<td>
							</td>
							<td>
							</td>
						</tr>
						<tr>
							<td>
								Всего
							</td>
							<td>
								{$aStats.count_all}
							</td>
							<td>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="w50p">
				<h3>Активность</h3>
				<table>
					<thead></thead>
					<tbody>
						<tr>
							<td>
								Активные
							</td>
							<td>
								{$aStats.count_active}
							</td>
							<td>
								{number_format(($aStats.count_active*100/$aStats.count_all), 1, '.', '')} %
							</td>
						</tr>
						<tr>
							<td>
								Заблудившиеся
							</td>
							<td>
								{$aStats.count_inactive}
							</td>
							<td>
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