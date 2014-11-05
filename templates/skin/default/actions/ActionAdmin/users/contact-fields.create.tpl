{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content_actionbar'}
	<a href="{router page="admin/users/contact-fields"}" class="button">&larr; Назад к списку</a>
{/block}

{block name='layout_page_title'}
	{if $oField}
		Редактирование контакта
	{else}
		Создание нового контакта
	{/if}
{/block}

{block name='layout_content'}
	<form method="post">
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.hidden.security_key.tpl"}

        {* Тип *}
        {$aTypes[] = [
            'value' => '',
            'text' => ''
        ]}
        {foreach $aUserFieldTypes as $sType}
            {$aTypes[] = [
                'text' => $sType,
                'value' => $sType
            ]}
        {/foreach}
        {include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.select.tpl"
                sFieldName          = 'type'
                sFieldLabel         = 'Тип'
                sFieldClasses       = 'width-200'
                aFieldItems         = $aTypes
                sFieldSelectedValue = $_aRequest.type}

		{* Название *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
				 sFieldName  = 'title'
				 sFieldValue = $_aRequest.title
				 sFieldLabel = 'Заголовок'}

		{* Имя *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
				 sFieldName  = 'name'
				 sFieldValue = $_aRequest.name
				 sFieldLabel = 'Имя'}

        {* Паттерн *}
        {include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
                sFieldName  = 'pattern'
                sFieldValue = $_aRequest.pattern
                sFieldLabel = 'Шаблон'}

		<br/>
		{* Кнопки *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.button.tpl"
				 sFieldName  = 'submit'
				 sFieldText  = $aLang.plugin.admin.add
				 sFieldValue = '1'
				 sFieldStyle = 'primary'}

	</form>
{/block}