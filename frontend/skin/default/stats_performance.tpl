
{**
 * Информация о производительности движка
 *
 * @styles css/admin.css
 *}

<div class="ls-alert ls-alert--info">
	{hook run='statistics_performance_begin'}

	<table class="ls-table">
		<tbody>
			<tr>
				<td>
					<h4>MySql</h4>
					query: <strong>{$aStatsPerformance.sql.count}</strong><br />
					time: <strong>{$aStatsPerformance.sql.time}</strong>
				</td>
				<td>
					<h4>Cache</h4>
					query: <strong>{$aStatsPerformance.cache.count}</strong><br />
					&mdash; set: <strong>{$aStatsPerformance.cache.count_set}</strong><br />
					&mdash; get: <strong>{$aStatsPerformance.cache.count_get}</strong><br />
					time: <strong>{$aStatsPerformance.cache.time}</strong>
				</td>
				<td>
					<h4>PHP</h4>
					time load modules: <strong>{$aStatsPerformance.engine.time_load_module}</strong><br />
					full time: <strong>{$iTimeFullPerformance}</strong>
				</td>
				<td>
					<h4>Memory</h4>
					memory usage: <strong>{memory_get_usage(true) / 1024 / 1024} Mb</strong><br />
					memory peak usage: <strong>{memory_get_peak_usage(true) / 1024 / 1024} Mb</strong>
				</td>

				{hook run='statistics_performance_item'}
			</tr>
		</tbody>
	</table>

	{hook run='statistics_performance_end'}
</div>
