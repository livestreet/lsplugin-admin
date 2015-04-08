{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content_actionbar'}
	<a href="{router page="admin/users/rbac/group"}" class="button">&larr; Назад к списку</a>

	{include './menu.tpl'}
{/block}

{block name='layout_page_title'}
	{if $oGroup}
		Редактирование группы
	{else}
		Создание новой группы
	{/if}
{/block}

{block name='layout_content'}
	<form method="post">
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.hidden.security_key.tpl"}

		{* Название *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
				 sFieldName  = 'group[title]'
				 sFieldValue = $_aRequest.group.title
				 sFieldLabel = 'Название'}

		{* Code *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
				 sFieldName  = 'group[code]'
				 sFieldValue = $_aRequest.group.code
				 sFieldLabel = 'Код'}

		<br/>
		{* Кнопки *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.button.tpl"
				 sFieldName  = 'group_submit'
				 sFieldText  = $aLang.plugin.admin.add
				 sFieldValue = '1'
				 sFieldStyle = 'primary'}

	</form>
{/block}