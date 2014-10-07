{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content_actionbar'}
	<a href="{router page="admin/users/rbac/permission-create"}" class="button button-primary">{$aLang.plugin.admin.add}</a>

	{include './menu.tpl'}
{/block}
{* todo: add lang *}
{block name='layout_page_title'}Список разрешений{/block}

{block name='layout_content'}

	{if $aPermissionGroupItems}
		<table class="table">
            <thead>
				<tr>
					<th>Название</th>
					<th>Код</th>
					<th>Плагин</th>
					<th align="center">Статус</th>
					<th></th>
				</tr>
            </thead>
            <tbody>
				{foreach $aPermissionGroupItems as $aPermissionItems}
					{$oGroup=$aGroupItems[$aPermissionItems@key]}
					<tr>
						<td colspan="5">
							<b>
							{if $oGroup}
								{$oGroup->getTitle()}
							{else}
								Без группы
							{/if}
							</b>
						</td>
					</tr>
					{foreach $aPermissionItems as $oPermissionItem}
						<tr data-id="{$oPermissionItem->getId()}">
							<td style="padding-left: 30px;">
								{$oPermissionItem->getTitleLang()}
							</td>
							<td>{$oPermissionItem->getCode()}</td>
							<td>{$oPermissionItem->getPlugin()}</td>
							<td align="center">
								{if $oPermissionItem->getState()==ModuleRbac::PERMISSION_STATE_ACTIVE}
									<span class="icon-eye-open"></span>
								{else}
									<span class="icon-eye-close"></span>
								{/if}
							</td>
							<td class="ta-r">
								<a href="{$oPermissionItem->getUrlAdminUpdate()}" class="icon-edit" title="{$aLang.plugin.admin.edit}"></a>
								<a href="{$oPermissionItem->getUrlAdminRemove()}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
								   class="icon-remove js-question"
								   title="{$aLang.plugin.admin.delete}"
								   data-question-title="Действительно удалить?"></a>
							</td>
						</tr>
					{/foreach}
				{/foreach}
            </tbody>
		</table>
	{else}
		{include file="{$aTemplatePathPlugin.admin}alert.tpl" sAlertStyle='info' mAlerts='Нет разрешений. Вы можете добавить новые.'}
	{/if}
{/block}