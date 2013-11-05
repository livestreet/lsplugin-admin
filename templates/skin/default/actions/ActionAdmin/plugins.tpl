{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_page_title'}
	Список плагинов
{/block}

{block name='layout_content'}
	{if $aPluginsInfo and count($aPluginsInfo) > 0}
		<table class="table table-plugins">
			<tbody>
				{foreach from=$aPluginsInfo item=oPlugin}
					<tr class="plugin-list-item {if $oPlugin.is_active}active{/if}">
						<td>
							<h4 class="plugin-list-item-title">
								<a href="{router page='admin/settings/plugin'}{$oPlugin.code}/">{$oPlugin.property->name->data}</a>
							</h4>

							<p>{$oPlugin.property->description->data|strip_tags|escape:'html'}</p>
							

						</td>

						<td><h4 class="plugin-list-item-title">{$oPlugin.property->version}</h4></td>

						<td>
							Folder: /plugins/{$oPlugin.code}/
							<br />
							Author: {$oPlugin.property->author->data}
							<br />
							{$oPlugin.property->homepage}
						</td>

						<td class="ta-r">
							{strip}
								{if $oPlugin.is_active}
									<a href="{router page='admin/plugin/toggle'}?plugin={$oPlugin.code}&action=deactivate&security_ls_key={$LIVESTREET_SECURITY_KEY}" 
									   title="{$aLang.plugins_plugin_deactivate}"
									   class="button">Deactivate</a>
								{else}
									<a href="{router page='admin/plugin/toggle'}?plugin={$oPlugin.code}&action=activate&security_ls_key={$LIVESTREET_SECURITY_KEY}" 
									   title="{$aLang.plugins_plugin_activate}"
									   class="button button-primary">Activate</a>
								{/if}

								{if ! empty($oPlugin.property->settings) and $oPlugin.is_active}
									<br>
									<a href="{$oPlugin.property->settings}" class="button" target="_blank">Настройки</a>
								{/if}
							{/strip}
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	{else}
		{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts="No plugins" sAlertStyle='empty'}
	{/if}
{/block}