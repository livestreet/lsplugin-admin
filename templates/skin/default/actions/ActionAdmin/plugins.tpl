{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_page_title'}
	{$aLang.plugin.admin.plugins.title}
{/block}

{block name='layout_content'}
	{if $aPluginsInfo and count($aPluginsInfo) > 0}
		<table class="table table-plugins">
			<tbody>
				{foreach from=$aPluginsInfo item=oPlugin}
					<tr class="plugin-list-item {if $oPlugin.is_active}active{/if}">
						{*
							заголовок
						*}
						<td>
							<h4 class="plugin-list-item-title">
								{*
									редактировать настройки можно только активированного плагина
								*}
								{if $oPlugin.is_active}
									<a href="{router page='admin/settings/plugin'}{$oPlugin.code}/">{$oPlugin.property->name->data}</a>
								{else}
									{$oPlugin.property->name->data}
								{/if}
							</h4>

							<p>{$oPlugin.property->description->data|strip_tags|escape:'html'}</p>
						</td>

						{*
							версия
						*}
						<td><h4 class="plugin-list-item-title">{$oPlugin.property->version}</h4></td>

						{*
							информация
						*}
						<td>
							<i class="icon-folder-open"></i> /plugins/{$oPlugin.code}/
							<br />
							<i class="icon-user"></i> {$oPlugin.property->author->data}
							{if !empty($oPlugin.property->homepage)}
								<br />
								<i class="icon-home"></i> {$oPlugin.property->homepage}
							{/if}
						</td>

						{*
							управление
						*}
						<td class="ta-r">
							{if $oPlugin.is_active}
								<a href="{router page='admin/plugins/toggle'}?plugin={$oPlugin.code}&action=deactivate&security_ls_key={$LIVESTREET_SECURITY_KEY}"
								   title="{$aLang.plugins_plugin_deactivate}"
								   class="button">{$aLang.plugins_plugin_deactivate}</a>
							{else}
								<a href="{router page='admin/plugins/toggle'}?plugin={$oPlugin.code}&action=activate&security_ls_key={$LIVESTREET_SECURITY_KEY}"
								   title="{$aLang.plugins_plugin_activate}"
								   class="button button-primary">{$aLang.plugins_plugin_activate}</a>
							{/if}

							{if ! empty($oPlugin.property->settings) and $oPlugin.is_active}
								<br />
								<a href="{$oPlugin.property->settings}" class="button" target="_blank">{$aLang.plugin.admin.plugins.settings}</a>
							{/if}
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	{else}
		{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts=$aLang.plugin.admin.plugins.no_plugins sAlertStyle='empty'}
	{/if}
{/block}