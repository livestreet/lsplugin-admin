{**
 * Главное меню
 *
 * @param object $oMenuMain       Основные пункты меню
 * @param object $oMenuAddition   Дополнительные пункты меню
 *
 * @styles assets/css/navs.css
 * @scripts assets/js/init.js
 *}

<ul class="nav-main">
	{* Основные пункты меню *}
	{foreach $oMenuMain->GetSections() as $oMenuSection}
		<li class="nav-main-item-root js-nav-main-item-root {if $oMenuSection->GetActive()}active{/if}" data-item-id="{$oMenuSection@index}">
			<i class="icon-nav-main-home"></i>

			<a {if ! $oMenuSection->HasItems()}href="{$oMenuSection->GetUrlFull()}"{else}href="#"{/if}>
				<span>{$oMenuSection->GetCaption()|escape}</span>
			</a>

			{* Подменю *}
			{if $oMenuSection->HasItems()}
				<ul>
					{foreach $oMenuSection->GetItems() as $oMenuItem}
						<li {if $oMenuItem->GetActive()}class="active"{/if}>
							<a href="{$oMenuItem->GetUrlFull()}"><span>{$oMenuItem->GetCaption()|escape}</span></a>
						</li>
					{/foreach}
				</ul>
			{/if}
		</li>
	{/foreach}

	{* Дополнительные пункты меню *}
	{if $oMenuAddition->GetSections()}
		<li {if $oMenuSection->GetActive()}class="active"{/if}>
			<a href="#">{$oMenuAddition->GetCaption()|escape:'html'}</a>

			{foreach from=$oMenuAddition->GetSections() item=oMenuSection key=section_index}
				<a {if ! $oMenuSection->HasItems()}href="{$oMenuSection->GetUrlFull()}"{else}href="#"{/if}>
					<span>{$oMenuSection->GetCaption()|escape:'html'}</span>
				</a>

				{* Подменю *}
				{if $oMenuSection->HasItems()}
					<ul>
						{foreach $oMenuSection->GetItems() as $oMenuItem}
							<li {if $oMenuItem->GetActive()}class="active"{/if}>
								<a href="{$oMenuItem->GetUrlFull()}"><span>{$oMenuItem->GetCaption()|escape}</span></a>
							</li>
						{/foreach}
					</ul>
				{/if}
			{/foreach}
		</li>
	{/if}
</ul>



{*
 
 
<div class="sb-sep">Дополнительно</div>

<a href="#" class="sb-item sb-root sb-item-5" id="sb-root-4"><span>Страницы</span></a>
<ul>
	<li><a href="page_list.html">Список страниц</a></li>

	<li><a href="page_add.html">Добавить страницу</a></li>
</ul>

---

<a href="{router page='admin'}" class="sb-item sb-item-1"><span>Главная</span></a>

<a href="#" class="sb-item sb-root sb-item-2" id="sb-root-1"><span>Настройки</span></a>
<ul>
	<li><a href="{router page='admin/settings/generic'}">Основные</a></li>
	<li class="active"><a href="{router page='admin/settings/system'}">Системные</a></li>
	<li><a href="{router page='admin/settings/cache'}">Кеширование</a></li>
	<li><a href="{router page='admin/settings/mail'}">Почта</a></li>
	<li><a href="{router page='admin/settings/acl'}">Доступ</a></li>
	<li><a href="{router page='admin/settings/content'}">Контент</a></li>
	<li><a href="{router page='admin/settings/patterns'}">Паттерны</a></li>
</ul>


<a href="#" class="sb-item sb-root sb-item-8" id="sb-root-5"><span>Пользователи</span></a>
<ul>
	<li><a href="user_list.html">Список пользователей</a></li>
	<li><a href="user_add.html">Добавить пользователя</a></li>
</ul>


<a href="#" class="sb-item sb-root sb-item-3" id="sb-root-2"><span>Инвайты</span></a>
<ul>

	<li><a href="user_invite_list.html">Список инвайтов</a></li>
	<li><a href="user_invite_send.html">Выдать инвайт</a></li>
	<li><a href="user_invite_add.html">Добавить инвайты</a></li>
	<li><a href="user_invite_stat.html">Статистика</a></li>
</ul>


<a href="#" class="sb-item sb-root sb-item-4" id="sb-root-3"><span>Внешний вид</span></a>

<ul>
	<li><a href="app_themes.html">Шаблоны</a></li>
	<li><a href="app_blocks.html">Блоки</a></li>
	<li><a href="app_lang.html">Языковой файл</a></li>
</ul>


<a href="#" class="sb-item sb-item-6"><span>Написать</span></a>
<a href="blog_list.html" class="sb-item sb-item-7 active"><span>Блоги</span></a>

<a href="plugin_list.html" class="sb-item sb-item-9"><span>Плагины</span></a>
<a href="stat.html" class="sb-item sb-item-10"><span>Статистика</span></a>

*}