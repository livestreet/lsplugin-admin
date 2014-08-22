{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content_actionbar'}
	<a href="{router page="admin/users/rbac/role"}" class="button">&larr; Назад к списку</a>

	{include './menu.tpl'}
{/block}
{* todo: add lang *}
{block name='layout_page_title'}Список разрешений для роли &laquo;{$oRole->getTitle()}&raquo;{/block}

{block name='layout_content'}

	<div>

		<select id="rbac-role-permissions-select" class="width-500" data-role-id="{$oRole->getId()}">
			{foreach $aPermissionGroupItems as $aPermissionItemsGroup}
				{$oGroup=$aGroupItems[$aPermissionItems@key]}
				{if $oGroup}
					{$sTitleGroup=$oGroup->getTitle()}
				{else}
					{$sTitleGroup='Без группы'}
				{/if}
				<optgroup label="{$sTitleGroup}">
					{foreach $aPermissionItemsGroup as $oPermissionItemGroup}
						<option value="{$oPermissionItemGroup->getId()}">{$oPermissionItemGroup->getTitle()} ({$oPermissionItemGroup->getCode()})</option>
					{/foreach}
				</optgroup>
			{/foreach}
		</select>

		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.button.tpl"
				sFieldText  = 'Добавить разрешение'
				sFieldClasses = 'js-rbac-role-permission-add'
				sFieldValue = '1'}
	</div>

	<br/>

	<ul class="js-rbac-role-permissions-area">
	{foreach $aPermissionItems as $oPermission}
		{include './role.permissions.item.tpl' oRole=$oRole oPermission=$oPermission}
	{/foreach}
	</ul>

{/block}