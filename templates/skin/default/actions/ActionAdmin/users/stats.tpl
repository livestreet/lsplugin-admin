{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}


{block name='layout_content_toolbar'}
	<a class="button" href="#">Вчера</a>
	<a class="button" href="#">Сегодня</a>
	<a class="button" href="#">Неделя</a>
	<a class="button" href="#">Месяц</a>

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
								<hr>
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
		<div class="yearsold">
			<h3>Возрастное распределение</h3>
			график 2
		</div>
		<div class="countries-n-cities">
			<h3>Страны и города</h3>
			вывод стран
		</div>

	</div>

{/block}