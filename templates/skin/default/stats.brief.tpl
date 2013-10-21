{**
 * Блок статистики отображающий кол-во юзеров, блогов и т.д.
 *
 * @styles stats.css
 *}

<ul class="stats-brief">
	<li>
		<h3>{number_format($aStats.count_all, 0, '.', ' ')}</h3>
		<p>{$aLang.plugin.admin.index.users}</p>
	</li>

	{*
		прирост пользователей за неделю
	*}
	{if $aUserGrowth}
		<li>
			<h3>
				{abs($aUserGrowth.now_items)}

				{if $aUserGrowth.growth > 0}
					<i class="icon-stats-up" title="{$aLang.plugin.admin.index.new_users_for_week}: {$aUserGrowth.growth}"></i>
				{elseif $aUserGrowth.growth < 0}
					<i class="icon-stats-down" title="{$aLang.plugin.admin.index.less_users_for_week}: {abs($aUserGrowth.growth)}"></i>
				{/if}
			</h3>
			<p>{$aLang.plugin.admin.index.registrations}</p>
		</li>
	{/if}

	{if $iTotalTopicsCount}
		<li>
			<h3>{$iTotalTopicsCount}</h3>
			<p>{$aLang.plugin.admin.index.topics}</p>
		</li>
	{/if}

	{if $iTotalBlogsCount}
		<li>
			<h3>{$iTotalBlogsCount}</h3>
			<p>{$aLang.plugin.admin.index.blogs}</p>
		</li>
	{/if}

	{if $iTotalCommentsCount}
		<li>
			<h3>{$iTotalCommentsCount}</h3>
			<p>{$aLang.plugin.admin.index.comments}</p>
		</li>
	{/if}
</ul>
