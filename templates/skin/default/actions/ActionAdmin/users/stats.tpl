{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}


{block name='layout_content_toolbar'}
	<a class="button" href="#">Вчера</a>
	<a class="button" href="#">Сегодня</a>
	<a class="button" href="#">Неделя</a>
	<a class="button" href="#">Месяц</a>

{/block}


{block name='layout_page_title'}
	Статистика
{/block}


{block name='layout_content'}
	stats

{/block}