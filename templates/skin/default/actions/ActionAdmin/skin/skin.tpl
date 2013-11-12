{**
 * Шаблон
 *}

<div class="skin-list-item {if $oSkin@iteration % 2 == 0}even{/if}">
	<img src="{$oSkin->getPreview()}" class="skin-list-item-image" />

	<div class="skin-list-item-content">
		{$oInfo = $oSkin->getInfo()}

		{if $oInfo}
			{$sName = $oInfo->name->data}
		{else}
			{$sName = $oSkin->getName()}
		{/if}

		<h4 class="skin-list-item-title">{$sName}</h4>

		<div class="mb-15">
			{$bThisSkin = false}

			{if $oCurrentSkin->getName() == $oSkin->getName()}
				{$bThisSkin = true}
			{/if}

			{if ! $bThisSkin}
				<a href="{router page="admin/settings/skins/use/{$oSkin->getName()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
				   class="button button-primary">{$aLang.plugin.admin.skin.use_skin}</a>
				<a href="{router page="admin/settings/skins/preview/{$oSkin->getName()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
				   class="button button-primary">{$aLang.plugin.admin.skin.preview_skin}</a>
			{/if}
		</div>

		{if $oInfo}
			<div class="skin-list-item-info">
				<dl>
					<dt>{$aLang.plugin.admin.skin.author}:</dt>
					<dd>{$oInfo->author->data}</dd>
				</dl>
				<dl>
					<dt>{$aLang.plugin.admin.skin.homepage}:</dt>
					<dd>{$oInfo->homepage}</dd>
				</dl>
				<dl>
					<dt>{$aLang.plugin.admin.skin.version}:</dt>
					<dd>{$oInfo->version}</dd>
				</dl>
				<dl>
					<dt>{$aLang.plugin.admin.skin.description}:</dt>
					<dd>{$oInfo->description->data}</dd>
				</dl>

				{if $oInfo->themes->children() and count($oInfo->themes->children()) > 0}
					<dl>
						<dt>{$aLang.plugin.admin.skin.themes}:</dt>
						<dd>
							{if $bThisSkin}
								{*
									для текущего шаблона можно менять список тем
								*}
								<form action="{router page="admin/settings/skins/theme/{$oSkin->getName()}"}"
									  enctype="application/x-www-form-urlencoded"
									  method="post">
									<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />

									<select name="theme" class="width-150">
										{foreach from=$oInfo->themes->children() item=oTheme}
											<option value="{$oTheme->value}" {if $oConfig->GetValue('view.theme')==$oTheme->value}selected="selected"{/if}>
												{$oTheme->description->data}
											</option>
										{/foreach}
									</select>

									<button type="submit" class="button">{$aLang.plugin.admin.skin.change_theme}</button>
								</form>
							{else}
								{*
									для неактивного шаблона нужно только вывести список тем, т.к. включить их для неактивного шаблона нельзя
								*}
								{foreach from=$oInfo->themes->children() item=oTheme}
									<span>{$oTheme->value}</span>
									<i class="icon-info-sign" title="{$oTheme->description->data|escape:'html'}"></i>
									{if !$oTheme@last},{/if}
								{/foreach}
							{/if}
						</dd>
					</dl>
				{/if}
			</div>
		{/if}
	</div>
</div>