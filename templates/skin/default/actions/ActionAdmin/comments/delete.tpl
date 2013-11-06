{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}


{block name='layout_page_title'}
	{*$aLang.plugin.admin.users.deleteuser.title*}GOTTA DELETE? #{$oComment->getId()} ({$oComment->getText()|truncate:10:'...'|escape:'html'}
{/block}


{block name='layout_content'}
	<form action="{router page='admin/comments/delete'}" method="post" enctype="application/x-www-form-urlencoded">
		{*
			Скрытые поля
		*}
		{include file="{$aTemplatePathPlugin.admin}/forms/fields/form.field.hidden.security_key.tpl"}
		{include file="{$aTemplatePathPlugin.admin}/forms/fields/form.field.hidden.tpl" sFieldName='id' sFieldValue=$oComment->getId()}

		{*todo: add description *}
{*		<div class="info mb-20">
			{$aLang.plugin.admin.users.deleteuser.delete_user_info}
		</div>*}

		{*
			Кнопки
		*}
		{include file="{$aTemplatePathPlugin.admin}/forms/fields/form.field.button.tpl" sFieldName='submit_comment_delete' sFieldStyle='primary question' sFieldText=$aLang.plugin.admin.delete}
	</form>
{/block}