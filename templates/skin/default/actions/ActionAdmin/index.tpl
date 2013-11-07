{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}


{block name='layout_content_actionbar'}
	{include file="{$aTemplatePathPlugin.admin}stats.brief.tpl"}
{/block}


{block name='layout_content'}
	<h3 class="page-sub-header">{$aLang.plugin.admin.index.title}</h3>

	{**
	 * График
	 *}
	{include file="{$aTemplatePathPlugin.admin}charts/graph.tpl"
		sValueSuffix=$aLang.plugin.admin.users_stats.graph_suffix.$sCurrentGraphType
		aStats=$aDataStats
		sName=$aLang.plugin.admin.users_stats.graph_labels.$sCurrentGraphType
		sUrl="{router page='admin'}"
		bShowGraphTypeSelect=true
		bShowCustomPeriodFields=true
	}


	{**
	 * Уведомления
	 *}
	<ul class="stats-notifications">
		<li class="stats-notifications-item-plugins">
			<figure class="stats-notifications-image"></figure>
			<h3><a href="#" class="link-border"><span>Плагины</span></a></h3>
			<p><a href="#" class="link-border"><span>Есть 2 обновления</span></a></p>
		</li>
		<li class="stats-notifications-item-users">
			<figure class="stats-notifications-image"></figure>
			<h3><a href="#" class="link-border"><span>Пользователи</span></a></h3>
			<p><a href="#" class="link-border"><span>Есть 2 обновления</span></a></p>
		</li>
		<li class="stats-notifications-item-support">
			<figure class="stats-notifications-image"></figure>
			<h3><a href="#" class="link-border"><span>Обратная связь</span></a></h3>
			<p><a href="#" class="link-border"><span>Есть 2 обновления</span></a></p>
		</li>
	</ul>


	{**
	 * Блоки
	 *}
	<div class="home-blocks clearfix">
		{include file="{$aTemplatePathPlugin.admin}blocks/block.home.activity.tpl"}
		{include file="{$aTemplatePathPlugin.admin}blocks/block.home.stats.tpl"}
	</div>


	{**
	 * Данные о последнем входе пользователя в админку
	 *}
	{if $aLastVisitData.date}
		{$sAlertMsg = "Последний раз заходили в админку {date_format date=$aLastVisitData.date format="j F Y в H:i"}."}
		{if ! $aLastVisitData.same_ip}
			{$sAlertMsg = $sAlertMsg|cat:"<br>Предыдущий вход был выполнен из другого ip - <b>{$aLastVisitData.ip}</b>, текущий ip - <b>{func_getIp()}</b>."}
		{/if}

		{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts=$sAlertMsg}
	{else}
		{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts="Это ваше первое знакомство с админкой для LiveStreet CMS. Будем надеятся что она вам понравится и работа с ней будет удобной." sAlertStyle='info' bAlertClose=true}
	{/if}
{/block}