<!doctype html>

{block 'layout_options'}{/block}

<!--[if lt IE 7]>
<html class="no-js ie6 oldie" lang="ru"> <![endif]-->
<!--[if IE 7]>
<html class="no-js ie7 oldie" lang="ru"> <![endif]-->
<!--[if IE 8]>
<html class="no-js ie8 oldie" lang="ru"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="ru"> <!--<![endif]-->

<head>
    {* {hook run='html_head_begin'} *}
    {block 'layout_head_begin'}{/block}

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta name="description" content="{block 'layout_description'}{$sHtmlDescription}{/block}">
    <meta name="keywords" content="{block 'layout_keywords'}{$sHtmlKeywords}{/block}">

    <title>{block 'layout_title'}{$sHtmlTitle}{/block}</title>

    {**
     * Стили
     * CSS файлы подключаются в конфиге шаблона (ваш_шаблон/settings/config.php)
     *}
    {$aHtmlHeadFiles.css}

    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,600,700,300&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link href="{$aAdminTemplateWebPathPlugin.admin}assets/images/favicon.ico" rel="shortcut icon" />
    <link rel="search" type="application/opensearchdescription+xml" href="{router page="search/opensearch"}" title="{Config::Get('view.name')}"/>

    {**
     * RSS
     *}
    {if $aHtmlRssAlternate}
        <link rel="alternate" type="application/rss+xml" href="{$aHtmlRssAlternate.url}" title="{$aHtmlRssAlternate.title}">
    {/if}

    {if $sHtmlCanonical}
        <link rel="canonical" href="{$sHtmlCanonical}"/>
    {/if}


    <script>
        var PATH_ROOT = '{Router::GetPath('/')}',
                PATH_SKIN = '{Config::Get("path.skin.web")}',
                PATH_FRAMEWORK_FRONTEND = '{Config::Get("path.framework.frontend.web")}',
                PATH_FRAMEWORK_LIBS_VENDOR = '{Config::Get("path.framework.libs_vendor.web")}',
                /**
                 * Для совместимости с прошлыми версиями. БУДУТ УДАЛЕНЫ
                 */
                DIR_WEB_ROOT = '{Config::Get("path.root.web")}',
                DIR_STATIC_SKIN = '{Config::Get("path.skin.web")}',
                DIR_STATIC_FRAMEWORK = '{Config::Get("path.framework.frontend.web")}',
                DIR_ENGINE_LIBS = '{Config::Get("path.framework.web")}/libs',

                LIVESTREET_SECURITY_KEY = '{$LIVESTREET_SECURITY_KEY}',
                SESSION_ID = '{$_sPhpSessionId}',
                SESSION_NAME = '{$_sPhpSessionName}',
                LANGUAGE = '{Config::Get('lang.current')}',
                WYSIWYG = {if Config::Get('view.wysiwyg')}true{else}false{/if};

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
        ls.lang.load({json var = $LS->Lang_GetLangJs()});
        ls.lang.load({lang_load name="blog"});
    </script>


    {block 'layout_head_end'}{/block}
    {* {hook run='html_head_end'} *}

</head>


<body class="{$sBodyClasses} {block 'layout_body_classes'}{/block} ls-admin">
{* {hook run='body_begin'} *}

{block 'layout_body'}

<div id="container" class="{* {hook run='container_class'} *} {if $bNoSidebar}no-sidebar{/if}">
    {**
     * Шапка сайта
     *}
    {component 'admin:p-userbar'}

    {* Вспомогательный контейнер-обертка *}
    <div id="wrapper" class="{* {hook run='wrapper_class'} *} ls-clearfix">
        {* Контент *}
        <div id="content" role="main">
            {* Временный хак для совместимости со старым кодом *}
            {capture actionbar}
                {block 'layout_content_actionbar'}{/block}
            {/capture}

            {* Экшнбар *}
            {component 'admin:p-actionbar' backUrl=$layoutBackUrl backText=$layoutBackText content=$smarty.capture.actionbar}

            {block 'layout_content_before'}{/block}

            <div class="content-padding">
                {block 'layout_page_title' hide}
                    <h2 class="page-header">{$smarty.block.child}</h2>
                {/block}

                {* Системные сообщения *}
                {if ! $bNoSystemMessages}
                    {if $aMsgError}
                        {component 'admin:alert' text=$aMsgError mods='error' dismissible=true}
                    {/if}

                    {if $aMsgNotice}
                        {component 'admin:alert' text=$aMsgNotice dismissible=true}
                    {/if}
                {/if}

                {block 'layout_content'}{/block}
            </div>
        </div>

        {* Сайдбар *}
        {component 'admin:p-menu' menu=$oMenuMain}
    </div> {* /wrapper *}

    {* Подвал *}
    <footer id="footer">
        {block 'layout_footer_begin'}{/block}

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

        {block 'layout_footer_end'}{/block}
    </footer>
</div> {* /container *}
{/block}

{* для вывода общей статистики *}
{hook run='admin_body_end'}

{$sLayoutAfter}

</body>
</html>
