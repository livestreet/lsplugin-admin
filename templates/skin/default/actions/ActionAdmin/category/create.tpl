{**
 * Добавление категории
 *
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content_actionbar'}
	<a href="{router page="admin/categories/{$oCategoryType->getTargetType()}"}" class="button">&larr; Назад к списку категорий</a>
{/block}

{block name='layout_page_title'}Добавление поля для типа &laquo;{$oCategoryType->getTitle()|escape:'html'}&raquo;{/block}

{block name='layout_content'}
	<form method="post">
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.hidden.security_key.tpl"}

		{$aCategoriesList[] = [
			'value' => '',
			'text' => ''
		]}
		{foreach $aCategoryItems as $aCategory}
			{$aCategoriesList[] = [
				'text' => ''|str_pad:(2*$aCategory.level):'-'|cat:$aCategory['entity']->getTitle(),
				'value' => $aCategory['entity']->getId()
			]}
		{/foreach}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.select.tpl"
				 sFieldName          = 'category[pid]'
				 sFieldLabel         = 'Вложить в'
				 sFieldClasses       = 'width-200'
				 aFieldItems         = $aCategoriesList
				 sFieldSelectedValue = $_aRequest.category.pid}

		{* Название *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
				 sFieldName  = 'category[title]'
				 sFieldValue = $_aRequest.category.title
				 sFieldLabel = 'Название'}

		{* URL *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
				 sFieldName  = 'category[url]'
				 sFieldValue = $_aRequest.category.url
				 sFieldLabel = 'Url'}

		{* Сортировка *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
				sFieldName  = 'category[order]'
				sFieldValue = $_aRequest.category.order
				sFieldLabel = 'Сортировка'}

		{* Кнопки *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.button.tpl"
				 sFieldName  = 'category_submit'
				 sFieldText  = $aLang.plugin.admin.add
				 sFieldValue = '1'
				 sFieldStyle = 'primary'}

	</form>
{/block}