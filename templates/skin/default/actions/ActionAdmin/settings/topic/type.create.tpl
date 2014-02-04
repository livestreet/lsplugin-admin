{**
 * Настройки
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}


{block name='layout_page_title'}
	{if $oTopicType}
    	Редактирование типа топика: {$oTopicType->getName()}
	{else}
		Создание нового типа топика
	{/if}
{/block}

{block name='layout_content_actionbar'}
	<a href="{router page="admin/settings/topic-type"}" class="button">&larr; Назад к списку типов</a>
{/block}

{block name='layout_content'}
	<form method="post">
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.hidden.security_key.tpl"}

		{* Название *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
			sFieldName  = 'type[name]'
			sFieldValue = $_aRequest.type.name
			sFieldLabel = 'Название'}

		{* Название во множественном числе *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
			sFieldName  = 'type[name_many]'
			sFieldValue = $_aRequest.type.name_many
			sFieldLabel = 'Название во множественном числе'}

		{* Код *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
			sFieldName  = 'type[code]'
			sFieldValue = $_aRequest.type.code
			sFieldLabel = 'Уникальный код/идентификатор'}

		{* Активность *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.checkbox.tpl"
			sFieldName  = 'type[active]'
			bFieldChecked = $_aRequest.type.active
			sFieldLabel = 'Активный'}

		<h5 class="h5">Дополнительные параметры:</h5>

		{* Возможность подключать опросы *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.checkbox.tpl"
			sFieldName  = 'params[allow_poll]'
			bFieldChecked = $_aRequest.params.allow_poll
			sFieldLabel = 'Разрешить добавлять опросы'}

		{* Кнопки *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.button.tpl"
			sFieldName  = 'type_submit'
			sFieldText  = $aLang.plugin.admin.add
			sFieldText  = {($oTopicType) ? $aLang.plugin.admin.edit : $aLang.plugin.admin.add }
			sFieldValue = '1'
			sFieldStyle = 'primary'}
	</form>
{/block}