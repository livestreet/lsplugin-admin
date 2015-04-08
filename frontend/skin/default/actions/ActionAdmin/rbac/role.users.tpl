{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content_actionbar'}
	<a href="{router page="admin/users/rbac/role"}" class="button">&larr; Назад к списку</a>

	{include './menu.tpl'}
{/block}
{* todo: add lang *}
{block name='layout_page_title'}Список пользователей с ролью &laquo;{$oRole->getTitle()}&raquo;{/block}

{block name='layout_content'}

	<div>
		Логин: <input type="text" class="width-250 autocomplete-users" value="" data-role-id="{$oRole->getId()}" id="rbac-role-users-input" autocomplete="off">
		{* Кнопки *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.button.tpl"
				sFieldText  = 'Добавить пользователя'
				sFieldClasses = 'js-rbac-role-user-add'
				sFieldValue = '1'}
	</div>

	<br/>

	<ul class="js-rbac-role-user-area">
	{foreach $aUserItems as $oUser}
		{include './role.users.item.tpl' oUser=$oUser oRole=$oRole}
	{/foreach}
	</ul>

	<br/>

	{include file="{$aTemplatePathPlugin.admin}pagination.tpl" aPaging=$aPaging}

{/block}