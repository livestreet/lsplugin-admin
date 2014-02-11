{**
 * Вывод одного плагина в списке
 *}

<tr class="plugin-list-item {if $oPlugin->getActive()}active{/if}">
	{* Аватар *}
	<td>
		<img src="{$oPlugin->getLogo()}" alt="{$oPlugin->getName()|escape:'html'}" width="180" height="180" />
	</td>

	<td>
		{* Заголовок *}
		<h4 class="plugin-list-item-title mb-15">
			{* Редактировать настройки можно только активированного плагина *}
			{if $oPlugin->getActive() and $oPlugin->getOwnSettingsPageUrl()}
				<a href="{$oPlugin->getOwnSettingsPageUrl()}" title="{$aLang.plugin.admin.plugins.list.settings_tip}">{$oPlugin->getName()}</a>
			{else}
				{$oPlugin->getName()}
			{/if}
		</h4>

		{* Вывод информации об обновлении *}
		{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/plugins/plugin.info.update.tpl"}

		{* Информация *}
		<ul class="mb-15">
			<li><i class="icon-folder-open"></i> /plugins/{$oPlugin->getCode()}/</li>
			<li><i class="icon-user"></i> {$oPlugin->getAuthor()}</li>
			{if $oPlugin->getHomepage()}
				<li><i class="icon-home"></i> {$oPlugin->getHomepage()}</li>
			{/if}
		</ul>

		{* Описание *}
		<p>{$oPlugin->getDescription()|strip_tags|escape}</p>
	</td>

	{* Версия *}
	<td>
		<h4 class="plugin-list-item-title">{$oPlugin->getVersion()}</h4>
	</td>

	{* Управление *}
	<td class="ta-r">
		{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/plugins/plugin.actions.tpl"}

		{* TODO: проработать юзабилити
		{if $oPlugin->getOwnSettingsPageUrl() and $oPlugin->getActive()}
			<br />
			<a href="{$oPlugin->getOwnSettingsPageUrl()}" class="button">{$aLang.plugin.admin.plugins.list.settings}</a>
		{/if}
		*}

		{* управление конфигом плагина *}
		{if $oPlugin->getActive()}
            <br />
            <a href="{$oPlugin->getConfigSettingsPageUrl()}" class="button width-150" title="{$aLang.plugin.admin.plugins.list.config_tip}">{$aLang.plugin.admin.plugins.list.config}</a>
		{/if}
	</td>
</tr>