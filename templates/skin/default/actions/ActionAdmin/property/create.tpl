{**
 * Добавление дополнительного поля
 *
 * @param array $aPropertyType Список типов полей
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content_actionbar'}
	<a href="{router page="admin/properties/{$sPropertyTargetType}"}" class="button">&larr; Назад к списку полей</a>
{/block}

{block name='layout_page_title'}Добавление поля для типа &laquo;{$aPropertyTargetParams.name}&raquo;{/block}

{block name='layout_content'}
	<form method="post">
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.hidden.security_key.tpl"}

		{* Тип поля *}
		{$aPropertyType = [
			[ 'value' => 'int',        'text' => 'Целое число' ],
			[ 'value' => 'float',      'text' => 'Дробное число' ],
			[ 'value' => 'varchar',    'text' => 'Строка' ],
			[ 'value' => 'text',       'text' => 'Текст' ],
			[ 'value' => 'checkbox',   'text' => 'Чекбокс' ],
			[ 'value' => 'date',       'text' => 'Дата' ],
			[ 'value' => 'select',     'text' => 'Выпадающий список' ],
			[ 'value' => 'tags',       'text' => 'Теги' ],
			[ 'value' => 'video_link', 'text' => 'Ссылка на видео' ]
		]}

		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.select.tpl"
				 sFieldName          = 'property[type]'
				 sFieldLabel         = 'Тип поля'
				 sFieldClasses       = 'width-200'
				 aFieldItems         = $aPropertyType
				 sFieldSelectedValue = $_aRequest.property.type}

		{* Название *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
				 sFieldName  = 'property[title]'
				 sFieldValue = $_aRequest.property.title
				 sFieldLabel = 'Название'}

		{* Код *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
				 sFieldName  = 'property[code]'
				 sFieldValue = $_aRequest.property.code
				 sFieldLabel = 'Код'}

		{* Кнопки *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.button.tpl"
				 sFieldName  = 'property_create_submit'
				 sFieldText  = $aLang.plugin.admin.add
				 sFieldValue = '1'
				 sFieldStyle = 'primary'}
	</form>
{/block}