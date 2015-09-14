{**
 * Шаблон
 *}

<div class="skin-list-item {if $oSkin@iteration % 2 == 0}even{/if}">
	<img src="{$oSkin->getPreviewImage()}" class="skin-list-item-image" alt="{$oSkin->getViewName()|escape:'html'}" />

	<div class="skin-list-item-content">
		<h4 class="skin-list-item-title">{$oSkin->getViewName()|escape:'html'}</h4>

		<div class="mb-15">
			{* Если это не текущий включенный шаблон (независимо от предпросмотра) *}
			{if !$oSkin->getIsCurrent()}
				<a href="{$oSkin->getChangeSkinUrl()}" class="button button-primary">{$aLang.plugin.admin.skin.use_skin}</a>

				{* Чтобы можно было назад "отжать" кнопку *}
				{if $oSkin->getInPreview()}
					<a href="{$oSkin->getTurnOffPreviewUrl()}" class="button button-primary active">{$aLang.plugin.admin.skin.preview_skin}</a>
				{else}
					<a href="{$oSkin->getTurnOnPreviewUrl()}" class="button button-primary">{$aLang.plugin.admin.skin.preview_skin}</a>
				{/if}
			{/if}
		</div>

		{* Все методы ниже используют xml файл *}
		{if $oSkin->getXml()}
			<div class="skin-list-item-info">
				<dl>
					<dt>{$aLang.plugin.admin.skin.author}:</dt>
					<dd>{$oSkin->getAuthor()}</dd>
				</dl>
				<dl>
					<dt>{$aLang.plugin.admin.skin.homepage}:</dt>
					<dd>{$oSkin->getHomepage()}</dd>
				</dl>
				<dl>
					<dt>{$aLang.plugin.admin.skin.version}:</dt>
					<dd>{$oSkin->getVersion()}</dd>
				</dl>
				<dl>
					<dt>{$aLang.plugin.admin.skin.description}:</dt>
					<dd>{$oSkin->getDescription()}</dd>
				</dl>

				{if $oSkin->getThemes() and count($oSkin->getThemes()) > 0}
					<dl>
						<dt>{$aLang.plugin.admin.skin.themes}:</dt>
						<dd>
							{if $oSkin->getIsCurrent()}
								{* Для текущего шаблона можно менять список тем *}
								<form action="{router page="admin/skins/changetheme/{$oSkin->getName()}"}" enctype="application/x-www-form-urlencoded" method="post">
									<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />

									<select name="theme" class="width-150">
										{foreach from=$oSkin->getThemes() item=aTheme}
											<option value="{$aTheme.value}" {if Config::Get('view.theme')==$aTheme.value}selected="selected"{/if}>
												{$aTheme.description}
											</option>
										{/foreach}
									</select>

									<button type="submit" class="button">{$aLang.plugin.admin.skin.change_theme}</button>
								</form>
							{else}
								{* Для неактивного шаблона нужно только вывести список тем, т.к. включить их для неактивного шаблона нельзя *}
								{foreach from=$oSkin->getThemes() item=aTheme}
									<span>{$aTheme.value}</span>
									<i class="fa fa-info" title="{$aTheme.description|escape:'html'}"></i>
									{if !$aTheme@last},{/if}
								{/foreach}
							{/if}
						</dd>
					</dl>
				{/if}
			</div>
		{/if}
	</div>
</div>