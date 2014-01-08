{**
 * Вывод информации об одном дополнении из каталога
 *}

{* todo: export langs *}

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
    		<span>{$oAddon->getCountMark()} {$oAddon->getCountMark()|declension:$aLang.plugin.admin.plugins.install.reviews_declension:'russian'}</span>
		{/if}
	</div>

	{* Actions *}
	<div class="addon-actions">
		{if $oAddon->getAlreadyInstalled()}
			{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts="Уже установлен"}
		{else}
			{if $oAddon->getCost()}
				<a href="#" class="button button-primary addon-price">Купить за {$oAddon->getCost()|round} {$aLang.plugin.admin.plugins.install.rubles}</a>
			{else}
				<a href="#" class="button button-primary">Установить</a>
			{/if}
		{/if}
	</div>

	{* Info *}
	<div class="addon-full-info">
		Версия {$oAddon->getVersion()} | 

		<span {if !$oAddon->getCompatibleWithCurrentSitesLSVersion()}class="addon-not-compatible" title="Не совместим с установленной версией движка"{/if}>
			Совместимость: {$oAddon->getCompatibleLSVersionsString()}
		</span>
		<br />

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