{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}

	{* данные о последнем входе пользователя в админку *}
	{if $aLastVisitData.date}
		Последний раз заходили в админку {date_format date=$aLastVisitData.date format="j F Y в H:i"}.
		{if !$aLastVisitData.same_ip}
			Предыдущий вход был выполнен из другого ip - <b>{$aLastVisitData.ip}</b>, текущий ip - <b>{func_getIp()}</b>.
		{/if}
	{else}
		Это ваше первое знакомство с админкой для LiveStreet CMS. Будем надеятся что она вам понравится и работа с ней будет удобной.
	{/if}


{/block}