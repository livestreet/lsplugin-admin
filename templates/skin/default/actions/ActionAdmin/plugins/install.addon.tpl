
{*
	Вывод информации об одном дополнении из каталога
*}

<div class="catalog-one-addon code-{$oAddon->getCode()}">
	<div class="avatar">
		<img src="{$oAddon->getAvatar()}" alt="{$oAddon->getTitle()|escape}" title="{$oAddon->getTitle()|escape}" />
	</div>
	<div class="more-info">
		{*
			todo: lang
		*}

		{*
			заголовок и тип аддона (платный, бесплатный)
		*}
		<div class="title">
			{$oAddon->getTitle()} <span class="type-label fl-r">{$aLang.plugin.admin.plugins.install.filter.type[$oAddon->getType()]}</span>
			{*
				установлен ли уже этот плагин
			*}
			{if $oAddon->getAlreadyInstalled()}
				<span class="installed type-label">уже установлен</span>
			{/if}
		</div>
		{*
			автор
		*}
		{$aUserData = $oAddon->getUser()}
		<div class="author">
			от <a href="{$aUserData.profile}" target="_blank">{$aUserData.login}</a>
		</div>
		{*
			оценка и количество оценок
		*}
		<div class="mark">
			средняя оценка: {$oAddon->getMark()}, всего оценок: {$oAddon->getCountMark()}
		</div>
		{*
			стоимость (если платный)
		*}
		{if $oAddon->getCost()}
			<div class="costs">
				стоимость: {$oAddon->getCost()}
			</div>
		{/if}
		{*
			дополнительная информация
		*}
		<div class="misc-info">
			{*
				todo: check for current version
			*}
			версия: {$oAddon->getVersion()}, совместимость: {implode(',', $oAddon->getCompatibilities())}
			<br />
			добавлен: {$oAddon->getDateAdd()}, обновлен: {$oAddon->getDateUpdate()}
		</div>
		{*
			короткое описание
		*}
		<div class="mt-20 description-short">
			{$oAddon->getDescriptionShort()}
		</div>

	</div>
</div>
