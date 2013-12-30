{**
 * Вывод информации об одном дополнении из каталога
 *}

<div class="addon-full addon-code-{$oAddon->getCode()} {if $oAddon->getAlreadyInstalled()}addon-installed{/if}">
	{* Image *}
	<a href="#" class="addon-image">
		<img src="{$oAddon->getAvatar()}" alt="{$oAddon->getTitle()|escape}" title="{$oAddon->getTitle()|escape}">
	</a>

	{* Title *}
	<h3 class="addon-title"><a href="#">{$oAddon->getTitle()}</a></h3>

	{* Author *}
	{$aUserData = $oAddon->getUser()}
	<div class="addon-author">
		от <a href="{$aUserData.profile}" target="_blank">{$aUserData.login}</a>
	</div>

	{* Rating *}
	<div class="addon-rating">
    	{include file="{$aTemplatePathPlugin.admin}rating.stars.tpl" iRating=$oAddon->getMark() * 20}

		{if $oAddon->getCountMark()}
    		<span>{$oAddon->getCountMark()} {$oAddon->getCountMark()|declension:$aLang.plugin.admin.plugins.reviews_declension:'russian'}</span>
		{/if}
	</div>

	{* Actions *}
	<div class="addon-actions">
		{if ! $oAddon->getAlreadyInstalled()}
			{if $oAddon->getCost()}
				<a href="#" class="button button-primary addon-price">Купить за {$oAddon->getCost()|round} {$aLang.price_rubles}</a>
			{else}
				<a href="#" class="button button-primary addon-price">Установить</a>
			{/if}
		{else}
			{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts="Уже установлен"}
		{/if}
	</div>

	{* Info *}
	<div class="addon-full-info">
		Версия {$oAddon->getVersion()} | 

		<span {*if ! $oAddon->checkCompatibilityLastVersion()}class="addon-not-compatible"{/if*}>
			Совместимость: {implode(',', $oAddon->getCompatibilities())}
		</span>
		<br>

		Добавлен: {date_format date=$oAddon->getDateAdd() format="j F Y"}
		{if $oAddon->getDateUpdate()}
			| Обновлен: {date_format date=$oAddon->getDateUpdate() format="j F Y"}
		{/if}
		<br>
	</div>

	{* Description *}
	<div class="text pt-20">
		{$oAddon->getDescriptionShort()}
	</div>
</div>