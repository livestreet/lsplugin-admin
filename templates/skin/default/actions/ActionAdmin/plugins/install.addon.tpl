{**
 * Вывод информации об одном дополнении из каталога
 *}

{* todo: export langs *}

<div class="addon-full addon-code-{$oAddon->getCode()} {if $oAddon->getAlreadyInstalled()}addon-installed{/if}">
	{* Изображение *}
	<a href="{$oAddon->getUrl()}" class="addon-image">
		<img src="{$oAddon->getAvatar()}" alt="{$oAddon->getTitle()|escape}" title="{$oAddon->getTitle()|escape}">
	</a>

	{* Заголовок *}
	<h3 class="addon-title"><a href="{$oAddon->getUrl()}">{$oAddon->getTitle()}</a></h3>{* todo: add category label *}

	{* Автор *}
	{$aUserData = $oAddon->getUser()}
	<div class="addon-author">
		от <a href="{$aUserData.profile}" target="_blank">{$aUserData.login}</a>
	</div>

	{* Рейтинг *}
	<div class="addon-rating">
    	{include file="{$aTemplatePathPlugin.admin}misc/rating.stars.tpl" iRating=$oAddon->getMarkPercent()}

		{if $oAddon->getCountMark()}
    		<span>{$oAddon->getCountMark()} {$oAddon->getCountMark()|declension:$aLang.plugin.admin.plugins.install.reviews_declension:'russian'}</span>
		{/if}
	</div>

	{* Действия *}
	<div class="addon-actions">
		{if $oAddon->getAlreadyInstalled()}
			{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts="Уже установлен"}
		{else}
			{if $oAddon->getCost()}
				<a href="{$oAddon->getUrlUse()}" class="button button-primary addon-price">Купить за {$oAddon->getCost()|round} {$aLang.plugin.admin.plugins.install.rubles}</a>
			{else}
				<a href="{$oAddon->getUrlUse()}" class="button button-primary">Установить</a>
			{/if}
		{/if}
	</div>

	{* Общая информация *}
	<div class="addon-full-info">
		{if !$oAddon->getCompatibleWithCurrentSitesLSVersion()}
			{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts="Не совместим с установленной версией движка" sAlertStyle='info'}
		{/if}

		Версия {$oAddon->getVersion()} | 

		<span {if !$oAddon->getCompatibleWithCurrentSitesLSVersion()}class="addon-not-compatible" title="Не совместим с установленной версией движка"{/if}>
			Совместимость: {$oAddon->getCompatibleLSVersionsString()}
		</span>
		<br />

		Добавлен: {date_format date=$oAddon->getDateAdd() format="j F Y"}
		{if $oAddon->getDateUpdate()}
			| Обновлен: {date_format date=$oAddon->getDateUpdate() format="j F Y"}
		{/if}
		<br />
		{* Количество установок (выводить только если есть) *}
		{if $oAddon->getCountUse()}
			{if $oAddon->getCost()}
				Установлен {$oAddon->getCountUse()} раз 							{* TODO: DECLENSION *}
			{else}
				Скачан {$oAddon->getCountUse()} раз
			{/if}
		{/if}
	</div>

	{* Описание *}
	<div class="text pt-20">
		{$oAddon->getDescriptionShort()}
	</div>
</div>
