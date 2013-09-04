{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}

	{if $sLastVisit}
		Последний раз заходили в админку {date_format date=$sLastVisit format="j F Y в H:i"}
	{else}
		Это ваше первое знакомство с админкой для LiveStreet CMS. Будем надеятся что она вам понравится и работа с ней будет удобной.
	{/if}


{/block}