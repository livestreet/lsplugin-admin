{extends file='layouts/layout.base.tpl'}

{block name='layout_content'}

	Статья: <b>{$oArticle->getTitle()}</b>
	<br/>
	<br/>

	Дополнительные свойства:<br/>
	{$aProperties=$oArticle->getPropertyList()}
	{foreach $aProperties as $oProperty}
		<b>{$oProperty->getTitle()}</b>: {$oProperty->getValue()->getValueForDisplay()}<br/>
	{/foreach}

	<br/>
	<br/>
	Свойство "Стоимость":
	{if $oProperty=$oArticle->getProperty('price')}
		{$oProperty->getValue()->getValueForDisplay()}
	{else}
		значение не определено
	{/if}

{/block}