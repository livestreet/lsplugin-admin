{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content_actionbar'}
	<a href="{router page="admin/users/rbac"}" class="button">&larr; Назад к списку</a>

	{include './menu.tpl'}
{/block}

{block name='layout_page_title'}
	{if $oRole}
		Редактирование роли
	{else}
		Создание новой роли
	{/if}
{/block}

{block name='layout_content'}
	<form method="post">
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.hidden.security_key.tpl"}

		{$aRolesList[] = [
			'value' => '',
			'text' => ''
		]}
		{foreach $aRoleItems as $aRole}
			{$aRolesList[] = [
				'text' => ''|str_pad:(2*$aRole.level):'-'|cat:$aRole['entity']->getTitle(),
				'value' => $aRole['entity']->getId()
			]}
		{/foreach}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.select.tpl"
			sFieldName          = 'role[pid]'
			sFieldLabel         = 'Наследовать от'
			sFieldClasses       = 'width-200'
			aFieldItems         = $aRolesList
			sFieldSelectedValue = $_aRequest.role.pid}

		{* Название *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
				 sFieldName  = 'role[title]'
				 sFieldValue = $_aRequest.role.title
				 sFieldLabel = 'Название'}

		{* Code *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
				 sFieldName  = 'role[code]'
				 sFieldValue = $_aRequest.role.code
				 sFieldLabel = 'Код'}

		{* Статус активности *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.checkbox.tpl"
				sFieldName    = 'role[state]'
				bFieldChecked = $_aRequest.role.state
				sFieldLabel   = 'Активна'}

		<br/>
		{* Кнопки *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.button.tpl"
				 sFieldName  = 'role_submit'
				 sFieldText  = $aLang.plugin.admin.add
				 sFieldValue = '1'
				 sFieldStyle = 'primary'}

	</form>
{/block}