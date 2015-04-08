{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content_actionbar'}
	<a href="{router page="admin/users/rbac/group-create"}" class="button button-primary">{$aLang.plugin.admin.add}</a>

	{include './menu.tpl'}
{/block}
{* todo: add lang *}
{block name='layout_page_title'}Список групп{/block}

{block name='layout_content'}

	<div class="mb-20">
		Группы необходимы исключительно для логического/визуального разделения разрешений. Никакой функциональности группы в себе не несут.
	</div>

	{if $aGroupItems}
		<table class="table">
            <thead>
				<tr>
					<th>Название</th>
					<th>Код</th>
					<th>Разрешений</th>
					<th>Действие</th>
				</tr>
            </thead>
            <tbody>
				{foreach $aGroupItems as $oGroupItem}
					<tr data-id="{$oGroupItem->getId()}">
						<td>
							{$oGroupItem->getTitle()}
						</td>
						<td>{$oGroupItem->getCode()}</td>
						<td>
							{$iCount=count($oGroupItem->getPermissions())}
							{if $iCount}
								{$iCount}
							{else}
								&mdash;
							{/if}
						</td>
						<td class="ta-r">
							<a href="{$oGroupItem->getUrlAdminUpdate()}" class="icon-edit" title="{$aLang.plugin.admin.edit}"></a>
							<a href="{$oGroupItem->getUrlAdminRemove()}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
							   class="icon-remove js-question"
							   title="{$aLang.plugin.admin.delete}"
							   data-question-title="Действительно удалить?"></a>
						</td>
					</tr>
				{/foreach}
            </tbody>
		</table>
	{else}
		{include file="{$aTemplatePathPlugin.admin}alert.tpl" sAlertStyle='info' mAlerts='Нет групп. Вы можете добавить новую.'}
	{/if}
{/block}