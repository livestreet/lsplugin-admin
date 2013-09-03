
		<div class="OneSkin {if $smarty.foreach.SkinForCycle.iteration % 2 == 0}second{/if}">
			<div class="Preview">
				{assign var="sPreview" value=''}
				{if $oSkin->getPreview()}
					{assign var="sPreview" value=$oSkin->getPreview()}
				{/if}
				<img src="{$sPreview}" />
			</div>
			<div class="Description">
				{assign var="oInfo" value=$oSkin->getInfo()}
				{if $oInfo}
					{assign var="sName" value=$oInfo->name->data}
				{else}
					{assign var="sName" value=$oSkin->getName()}
				{/if}
				<div class="Controls">
					{$bThisSkin=false}
					{if $oCurrentSkin->getName()==$oSkin->getName()}
						{$bThisSkin=true}
					{/if}
					{if !$bThisSkin}
						<a
							href="{router page="admin/settings/skin/use/{$oSkin->getName()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
							class="button button-primary">{$aLang.plugin.admin.skin.use_skin}</a>
						<a
							href="{router page="admin/settings/skin/preview/{$oSkin->getName()}"}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
							class="button button-primary">{$aLang.plugin.admin.skin.preview_skin}</a>
					{/if}
				</div>
				<h4>{$sName}{if $bThisSkin} ({$aLang.plugin.admin.skin.current_skin}){/if}</h4>
				{if $oInfo}
					<div class="Info">
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
						{if $oInfo->themes->children() and count($oInfo->themes->children())>0}
							<dl>
								<dt>{$aLang.plugin.admin.skin.themes}:</dt>
								<dd>
									{if $bThisSkin}
										<form action="{router page="admin/settings/skin/theme/{$oSkin->getName()}"}"
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
											<input type="submit" value="{$aLang.plugin.admin.skin.change_theme}" class="button" />
										</form>
									{else}
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
