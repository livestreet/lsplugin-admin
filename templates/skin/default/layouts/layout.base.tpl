<!doctype html>

{block name='layout_options'}{/block}

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="ru"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="ru"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="ru"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="ru"> <!--<![endif]-->

<head>
	{* {hook run='html_head_begin'} *}
	{block name='layout_head_begin'}{/block}

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<meta name="description" content="{block name='layout_description'}{$sHtmlDescription}{/block}">
	<meta name="keywords" content="{block name='layout_keywords'}{$sHtmlKeywords}{/block}">

	<title>{block name='layout_title'}{$sHtmlTitle}{/block}</title>

	{**
	 * Стили
	 * CSS файлы подключаются в конфиге шаблона (ваш_шаблон/settings/config.php)
	 *}
	{$aHtmlHeadFiles.css}

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	{*<link href="{Config::Get('path.static.skin')}/images/favicon.ico?v1" rel="shortcut icon" />*}
	<link rel="search" type="application/opensearchdescription+xml" href="{router page="search/opensearch"}" title="{Config::Get('view.name')}" />

	{**
	 * RSS
	 *}
	{if $aHtmlRssAlternate}
		<link rel="alternate" type="application/rss+xml" href="{$aHtmlRssAlternate.url}" title="{$aHtmlRssAlternate.title}">
	{/if}

	{if $sHtmlCanonical}
		<link rel="canonical" href="{$sHtmlCanonical}" />
	{/if}


	<script>
        var		PATH_ROOT 					= '{Router::GetPath('/')}',
                PATH_SKIN		 			= '{Config::Get("path.skin.web")}',
                PATH_FRAMEWORK_FRONTEND		= '{Config::Get("path.framework.frontend.web")}',
                PATH_FRAMEWORK_LIBS_VENDOR	= '{Config::Get("path.framework.libs_vendor.web")}',
                /**
                 * Для совместимости с прошлыми версиями. БУДУТ УДАЛЕНЫ
                 */
                DIR_WEB_ROOT 				= '{Config::Get("path.root.web")}',
                DIR_STATIC_SKIN 			= '{Config::Get("path.skin.web")}',
                DIR_STATIC_FRAMEWORK 		= '{Config::Get("path.framework.frontend.web")}',
                DIR_ENGINE_LIBS	 			= '{Config::Get("path.framework.web")}/libs',

                LIVESTREET_SECURITY_KEY = '{$LIVESTREET_SECURITY_KEY}',
                SESSION_ID				= '{$_sPhpSessionId}',
                SESSION_NAME			= '{$_sPhpSessionName}',
                LANGUAGE				= '{Config::Get('lang.current')}',
                WYSIWYG					= {if Config::Get('view.wysiwyg')}true{else}false{/if};

		var aRouter = [];
		{foreach $aRouter as $sPage => $sPath}
			aRouter['{$sPage}'] = '{$sPath}';
		{/foreach}
	</script>

	{**
	 * JavaScript файлы
	 * JS файлы подключаются в конфиге шаблона (ваш_шаблон/settings/config.php)
	 *}
	{$aHtmlHeadFiles.js}

	<script>
		ls.lang.load({json var = $aLangJs});
		ls.lang.load({lang_load name="blog"});
	</script>
	

	{block name='layout_head_end'}{/block}
	{* {hook run='html_head_end'} *}

</head>


<body class="{$sBodyClasses} {block name='layout_body_classes'}{/block} ls-admin">
	{* {hook run='body_begin'} *}

	{block name='layout_body'}
		<div id="container" class="{* {hook run='container_class'} *} {if $bNoSidebar}no-sidebar{/if}">
			{**
			 * Шапка сайта
			 *}
			<header id="header" class="clearfix" role="banner">
				<ul class="breadcrumbs">
					<li><a href="{Router::GetPath('/')}" class="link-dotted">Перейти на сайт</a></li>	{* todo: add lang *}
				</ul>

				<div class="site-info">
					<h1 class="site-name"><a href="{Router::GetPath('admin')}">{Config::Get("view.name")}</a></h1>
				</div>

				{* Юзербар *}
				<div class="userbar dropdown-toggle js-dropdown-userbar" data-dropdown-target="dropdown-menu-userbar">
					<img src="{$oUserCurrent->getProfileAvatarPath(48)}" alt="Avatar" class="userbar-avatar" />
					
					<div class="userbar-login">{$oUserCurrent->getLogin()}</div>
				</div>

				<ul class="nav nav--stacked nav--dropdown dropdown-menu" id="dropdown-menu-userbar">
					<li>
						<a href="{router page="admin/users/profile/{$oUserCurrent->getId()}"}">Мой профиль</a>	{* todo: add lang *}
					</li>
					<li>
						<a href="{router page='login/exit'}?security_ls_key={$LIVESTREET_SECURITY_KEY}">Выйти</a>
					</li>
				</ul>
			</header>


			{* Вспомогательный контейнер-обертка *}
			<div id="wrapper" class="{* {hook run='wrapper_class'} *} clearfix">
				{* Сайдбар *}
				{if ! $bNoSidebar}
					<aside id="sidebar" role="complementary">
						{include file="{$aTemplatePathPlugin.admin}blocks.tpl" group='right'}
					</aside>
				{/if}

				{* Контент *}
				<div id="content-wrapper">
					<div id="content" 
						 role="main"
						 {if $sMenuItemSelect == 'profile'}itemscope itemtype="http://data-vocabulary.org/Person"{/if}>

						{block name='layout_content_actionbar' hide}
							<div class="actionbar {block name='layout_content_actionbar_class'}{/block} clearfix">
								{$smarty.block.child}
							</div>
						{/block}

						{block name='layout_content_before'}{/block}
						
						<div class="content-padding">
							{* {hook run='content_begin'} *}

							{block name='layout_content_begin'}{/block}

							{block name='layout_page_title' hide}
								<h2 class="page-header">{$smarty.block.child}</h2>
							{/block}

							{* Навигация *}
							{if $sNav or $sNavContent}
								<div class="nav-group">
									{if $sNav}
										{if in_array($sNav, $aMenuContainers)}
											{$aMenuFetch.$sNav}
										{else}
											{include file="navs/nav.$sNav.tpl"}
										{/if}
									{else}
										{include file="navs/nav.$sNavContent.content.tpl"}
									{/if}
								</div>
							{/if}

							{* Системные сообщения *}
								{if ! $bNoSystemMessages}
									{if $aMsgError}
										{include 'components/alert/alert.tpl' sMods='error' mAlerts=$aMsgError bClose=true}
									{/if}

									{if $aMsgNotice}
										{include 'components/alert/alert.tpl' mAlerts=$aMsgNotice bClose=true}
									{/if}
								{/if}

							{block name='layout_content'}{/block}

							{block name='layout_content_end'}{/block}
							{* {hook run='content_end'} *}
						</div>
					</div>


					{* Подвал *}
					<footer id="footer">
						{block name='layout_footer_begin'}{/block}

						<ul>
							<li>&copy; 2008-{date("Y")} LiveStreet CMS</li>
						</ul>

						<ul>
							<li><a href="https://catalog.livestreetcms.com/" class="link-border" target="_blank"><span>Каталог расширений</a></span></li>{* todo: add lang *}
							<li><a href="http://livestreet.ru/" class="link-border" target="_blank"><span>Сообщество</a></span></li>
							<li><a href="http://job.livestreetcms.com/" class="link-border" target="_blank"><span>Работа</a></span></li>
						</ul>

						<ul class="footer-right">
							<li><a href="{Router::GetPath('/')}" class="link-border"><span>Перейти на сайт</a></span></li>
						</ul>

						{block name='layout_footer_end'}{/block}
					</footer>
				</div>
			</div> {* /wrapper *}
		</div> {* /container *}
	{/block}


	{* {hook run='body_end'} *}

	{* для вывода общей статистики *}
	{hook run='admin_body_end'}
</body>
</html>