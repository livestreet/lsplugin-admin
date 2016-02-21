{**
 * Настройки
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_page_title'}
	{if $oTopicType}
    	Редактирование типа топика: {$oTopicType->getName()}
	{else}
		Создание нового типа топика
	{/if}
{/block}

{block 'layout_options' append}
	{$layoutBackUrl = {router page="admin/settings/topic-type"}}
{/block}

{block 'layout_content'}
	<form method="post">
		{component 'admin:field' template='hidden.security-key'}

		{* Название *}
		{component 'admin:field' template='text' name='type[name]' label='Название'}

		{* Название во множественном числе *}
		{component 'admin:field' template='text' name='type[name_many]' label='Название во множественном числе'}

		{* Код *}
		{component 'admin:field' template='text' name='type[code]' label='Уникальный код/идентификатор'}

		{* Активность *}
		{component 'admin:field' template='checkbox' name='type[active]' label='Активный'}

		<h5 class="h5">Дополнительные параметры:</h5>

		{* Возможность подключать опросы *}
		{component 'admin:field' template='checkbox' name='params[allow_poll]' label='Разрешить добавлять опросы'}

		{* Возможность отключить текст топика *}
		{component 'admin:field' template='checkbox' name='params[allow_text]' label='Разрешить стандартное поле с текстом'}

		{* Возможность отключить теги *}
		{component 'admin:field' template='checkbox' name='params[allow_tags]' label='Разрешить стандартное поле с тегами'}

		{* Возможность подключать выбор превью *}
		{component 'admin:field' template='checkbox' name='params[allow_preview]' label='Разрешить добавлять превью изображение'}

		{* Кнопки *}
		{component 'admin:button' name='type_submit' text="{($oTopicType) ? $aLang.plugin.admin.save : $aLang.plugin.admin.add }" value=1 mods='primary'}
	</form>
{/block}