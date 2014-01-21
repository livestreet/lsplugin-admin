{*
	Страница добавления жалобы
*}

{extends file='layouts/layout.base.tpl'}

{block name='layout_page_title'}
	{$aLang.plugin.admin.tickets.claims.add.title} "<span>{$oUser->getDisplayName()}</span>"
{/block}

{block name='layout_content'}
	<form action="{router page='tickets/claim/add'}{$oUser->getId()}" method="post" enctype="application/x-www-form-urlencoded">
		{* Скрытые поля *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.hidden.security_key.tpl"}
		{*include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.hidden.tpl" sFieldName='user_id' sFieldValue=$oUser->getId()*}

		<div class="mb-20">
			{*
				тип жалобы
			*}
			<select name="type" class="width-300 mb-20">
				{foreach $oConfig->Get('plugin.admin.tickets.claims.types') as $sType}
					<option value="{$sType}">{$aLang.plugin.admin.tickets.claims.add.types.$sType}</option>
				{/foreach}
			</select>
			{*
				todo: удалить, если форма селекта не будет переделана
			*}
{*			{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.select.tpl"
				sFieldName='type'
				sFieldClasses='width-300 mb-20'
				aFieldItems=array_combine($oConfig->Get('plugin.admin.tickets.claims.types'), $aLang.plugin.admin.tickets.claims.add.types)
			}*}
			<br />
			{*
				текст жалобы
			*}
			{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.textarea.tpl"
				sFieldName='text'
				sFieldClasses='width-300 mb-20'
				iFieldRows=5
				sFieldPlaceholder=$aLang.plugin.admin.tickets.claims.add.text_ph
			}

			{*
				нужно ли отображать каптчу
			*}
			{if $oConfig->Get('plugin.admin.tickets.claims.use_captcha')}
				{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.captcha.tpl" sFieldName='captcha'}
			{/if}
		</div>

		{* Кнопки *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.button.tpl"
			sFieldName='submit_claim'
			sFieldStyle='primary'
			sFieldText=$aLang.plugin.admin.tickets.claims.add.buttons.add
		}
		<a href="{router page='index'}" class="button">{$aLang.plugin.admin.tickets.claims.add.buttons.cancel}</a>
	</form>
{/block}