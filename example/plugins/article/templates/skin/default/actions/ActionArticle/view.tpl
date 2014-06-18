{**
 * Отображение статьи
 *}

{extends file='layouts/layout.base.tpl'}

{block name='layout_options'}
	{$bNoSidebar = true}
{/block}

{block name='layout_page_title'}
	{$oArticle->getTitle()}
{/block}

{block name='layout_content'}
	<h4 class="h4">Дополнительные свойства</h4>

	{$aProperties = $oArticle->property->getPropertyList()}

	{include 'property/render.list.tpl' aPropertyItems=$aProperties}

	<br/>
	<br/>

	<h4 class="h4">Свойство "Стоимость"</h4>

	{if $oProperty = $oArticle->property->getProperty('price')}
		{$oProperty->getValue()->getValueForDisplay()}
	{else}
		Значение не определено
	{/if}
{/block}