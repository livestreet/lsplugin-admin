{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content_actionbar'}
	<a href="{router page="admin/users/rbac/permission"}" class="button">&larr; Назад к списку</a>

	{include './menu.tpl'}
{/block}

{block name='layout_page_title'}
	{if $oPermission}
		Редактирование разрешения
	{else}
		Создание нового разрешения
	{/if}
{/block}

{block name='layout_content'}
	<form method="post">
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.hidden.security_key.tpl"}

		{$aGroups[] = [
			'value' => '',
			'text' => ''
		]}
		{foreach $aGroupItems as $oGroup}
			{$aGroups[] = [
				'text' => $oGroup->getTitle(),
				'value' => $oGroup->getId()
			]}
		{/foreach}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.select.tpl"
				sFieldName          = 'permission[group_id]'
				sFieldLabel         = 'Группа'
				sFieldClasses       = 'width-200'
				aFieldItems         = $aGroups
				sFieldSelectedValue = $_aRequest.permission.group_id}

		{* Название *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
				 sFieldName  = 'permission[title]'
				 sFieldValue = $_aRequest.permission.title
				 sFieldLabel = 'Название'}

		{* Code *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
				 sFieldName  = 'permission[code]'
				 sFieldValue = $_aRequest.permission.code
				 sFieldLabel = 'Код'}

		{* Сообщение об ошибке *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
				sFieldName  = 'permission[msg_error]'
				sFieldValue = $_aRequest.permission.msg_error
				sFieldLabel = 'Сообщение об ошибке'}

		{* Статус активности *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.checkbox.tpl"
				sFieldName    = 'permission[state]'
				bFieldChecked = $_aRequest.permission.state
				sFieldLabel   = 'Активно'}

		<br/>
		{* Кнопки *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.button.tpl"
				 sFieldName  = 'permission_submit'
				 sFieldText  = $aLang.plugin.admin.add
				 sFieldValue = '1'
				 sFieldStyle = 'primary'}

	</form>
{/block}