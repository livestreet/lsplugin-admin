{**
 * Список дополнительных полей
 *
 * @param array $aPropertyItems Список полей
 *
 * TODO: Вывод имени плагина
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content_actionbar'}
	<a href="{router page="admin/properties/{$sPropertyTargetType}/create"}" class="button button-primary">{$aLang.plugin.admin.add}</a>
{/block}

{block name='layout_page_title'}Список полей типа &laquo;{$aPropertyTargetParams.name}&raquo;{/block}

{block name='layout_content'}
	{if $aPropertyItems}
		<script type="text/javascript">
			jQuery(function($){
				ls.admin_property.initTableProperty();
			});
		</script>
		<table class="table" id="property-list">
            <thead>
            <tr>
                <th>Название</th>
                <th>Идентификатор</th>
                <th>Тип</th>
                <th>Действие</th>
            </tr>
            </thead>
            <tbody>
			{foreach $aPropertyItems as $oPropertyItem}
				<tr data-id="{$oPropertyItem->getId()}">
					<td>{$oPropertyItem->getTitle()}</td>
					<td>{$oPropertyItem->getCode()}</td>
					<td>{$oPropertyItem->getType()}</td>
					<td class="ta-r">
						<a href="{$oPropertyItem->getUrlAdminUpdate()}" class="icon-edit" title="{$aLang.plugin.admin.edit}"></a>
						<a href="{$oPropertyItem->getUrlAdminRemove()}?security_ls_key={$LIVESTREET_SECURITY_KEY}" class="icon-remove" title="{$aLang.plugin.admin.delete}"></a>
					</td>
				</tr>
			{/foreach}
            </tbody>
		</table>
	{else}
		{include file="{$aTemplatePathPlugin.admin}alert.tpl" sAlertStyle='info' mAlerts='Нет дополнительных полей'}
	{/if}
{/block}