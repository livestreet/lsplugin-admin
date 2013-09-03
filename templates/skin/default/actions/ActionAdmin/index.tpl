{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}

	Последний раз заходили {date_format date=$sLastVisit format="j F Y в H:i"}

{/block}