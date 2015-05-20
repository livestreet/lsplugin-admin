{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content_actionbar'}
	<a href="{router page="admin/users/rbac/role-create"}" class="button button-primary">{$aLang.plugin.admin.add}</a>

	{include './menu.tpl'}
{/block}
{* todo: add lang *}
{block name='layout_page_title'}Список ролей{/block}

{block name='layout_content'}
	{if $aRoleItems}
		<table class="table">
            <thead>
				<tr>
					<th>Название</th>
					<th>Код</th>
					<th align="center">Пользователей</th>
					<th align="center">Разрешений</th>
					<th align="center">Статус</th>
					<th></th>
				</tr>
            </thead>
            <tbody>
				{foreach $aRoleItems as $aRoleItem}
					{$oRoleItem=$aRoleItem['entity']}
					{$iLevel=$aRoleItem['level']}
					<tr data-id="{$oRoleItem->getId()}">
						<td>
							<i class="ls-icon-file" style="margin-left: {$iLevel*20}px;"></i>
							{$oRoleItem->getTitle()}
						</td>
						<td>{$oRoleItem->getCode()}</td>
						<td align="center">
							{if $oRoleItem->getCode()==ModuleRbac::ROLE_CODE_GUEST}
								&mdash;
							{else}
								{strip}
								<a href="{$oRoleItem->getUrlAdminAction('users')}">
									{$iCount=$oRoleItem->getCountUsers()}
									{if $iCount}
										{$iCount}
									{else}
										&mdash;
									{/if}
								</a>
								{/strip}
							{/if}
						</td>
						<td align="center">
							{strip}
							<a href="{$oRoleItem->getUrlAdminAction('permissions')}">
								{$iCount=count($oRoleItem->getPermissions())}
								{if $iCount}
									{$iCount}
								{else}
									&mdash;
								{/if}
							</a>
							{/strip}
						</td>
						<td align="center">
							{if $oRoleItem->getState()==ModuleRbac::ROLE_STATE_ACTIVE}
								<span class="ls-icon-eye-open"></span>
							{else}
								<span class="ls-icon-eye-close"></span>
							{/if}
						</td>
						<td class="ta-r">
							<a href="{$oRoleItem->getUrlAdminAction('update')}" class="ls-icon-edit" title="{$aLang.plugin.admin.edit}"></a>
							<a href="{$oRoleItem->getUrlAdminAction('remove')}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
							   class="ls-icon-remove js-question"
							   title="{$aLang.plugin.admin.delete}"
							   data-question-title="Действительно удалить?"></a>
						</td>
					</tr>
				{/foreach}
            </tbody>
		</table>
	{else}
		{include file="{$aTemplatePathPlugin.admin}alert.tpl" sAlertStyle='info' mAlerts='Нет ролей. Вы можете добавить новую.'}
	{/if}
{/block}