{**
 * Редактирование дополнительного поля
 *
 * @param array  $aPropertyType Список типов полей
 * @param object $oProperty     Поле
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content_actionbar'}
	<a href="{router page="admin/properties/{$sPropertyTargetType}"}" class="button">&larr; Назад к списку полей</a>
{/block}

{block name='layout_page_title'}Редактирование поля для типа &laquo;{$aPropertyTargetParams.name}&raquo;{/block}

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
			[ 'value' => 'select',     'text' => 'Выпадающий список' ],
			[ 'value' => 'tags',       'text' => 'Теги' ],
			[ 'value' => 'video_link', 'text' => 'Ссылка на видео' ]
		]}

		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.select.tpl"
				 sFieldName          = 'property[type]'
				 sFieldLabel         = 'Тип поля'
				 sFieldClasses       = 'width-200'
				 aFieldItems         = $aPropertyType
				 bFieldIsDisabled    = true
				 sFieldSelectedValue = $oProperty->getTypeTitle()}

		{* Название *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
				 sFieldName  = 'property[title]'
				 sFieldValue = $oProperty->getTitle()
				 sFieldLabel = 'Название'}

		{* Название *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
			sFieldName  = 'property[description]'
			sFieldValue = $oProperty->getDescription()
			sFieldLabel = 'Краткое описание'}

		{* Код *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
				 sFieldName  = 'property[code]'
				 sFieldValue = $oProperty->getCode()
				 sFieldLabel = 'Код'}
		
		{* Правила валидации *}
		<h3 class="page-sub-header mt-30">Правила валидации</h3>

		{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/property/types/type.{$oProperty->getType()}.tpl" 
				 oPropertyValidateRules = $oProperty->getValidateRules()
				 oPropertyParams        = $oProperty->getParams()}

		{* Кнопки *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.button.tpl"
				 sFieldName  = 'property_update_submit'
				 sFieldText  = $aLang.plugin.admin.save
				 sFieldValue = '1'
				 sFieldStyle = 'primary'}
	</form>
{/block}