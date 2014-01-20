{**
 * Главное меню
 *
 * @param object $oMenuMain       Основные пункты меню
 * @param object $oMenuAddition   Дополнительные пункты меню
 *
 * @styles assets/css/navs.css
 * @scripts assets/js/nav.main.js
 *}

<div class="m-nav-toggle dropdown-toggle js-nav-main-fold-mobile"><i class="icon-list"></i> Навигация</div>

<ul class="nav-main js-nav-main">
	{* Основные пункты меню *}
	{foreach $oMenuMain->GetSections() as $oMenuSection}
		<li class="nav-main-item nav-main-item-root {if $oMenuSection->HasItems()}js-nav-main-item-root{/if} {if $oMenuSection->GetActive()}active{/if}" data-item-id="{$oMenuSection@index}">
			<a {if ! $oMenuSection->HasItems()}href="{$oMenuSection->GetUrlFull()}"{else}href="#"{/if} 
			   {if $oMenuSection->HasItems()}class="js-dropdown-nav-main" data-dropdown-target="dropdown-menu-nav-main-{$oMenuSection@index}"{/if}>
				<i class="nav-main-item-icon nav-main-item-icon-{$oMenuSection->GetName()}" title="{$oMenuSection->GetCaption()|escape}"></i>
				<span>{$oMenuSection->GetCaption()|escape}</span>
			</a>

			{* Подменю *}
			{if $oMenuSection->HasItems()}
				<ul class="js-nav-main-submenu">
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

	<li class="nav-main-item-root nav-main-item-fold">
		<a href="#" class="js-nav-main-fold">
			<i class="nav-main-item-icon nav-main-item-icon-fold"></i>
			<span class="link-dotted">Свернуть меню</span>
		</a>
	</li>
</ul>
