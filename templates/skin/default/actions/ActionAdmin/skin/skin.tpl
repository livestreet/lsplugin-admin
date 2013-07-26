
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
						{if $oCurrentSkin->getName()==$oSkin->getName()}
							{$bThisSkin=true}
						{/if}
						{if !$bThisSkin}
							<a
								href="{router page='admin'}settings/skin/use/{$oSkin->getName()}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
								class="button button-primary">{$aLang.plugin.admin.skin.use_skin}</a>
							<a
								href="{router page='admin'}settings/skin/preview/{$oSkin->getName()}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
								class="button button-primary">{$aLang.plugin.admin.skin.preview_skin}</a>
						{/if}
					</div>
					<h4>{$sName}{if $bThisSkin} ({$aLang.plugin.admin.skin.current_skin}){/if}</h4>
					{if $oInfo}
						<div class="Info">
							<dl>
								<dt>author:</dt>
								<dd>{$oInfo->author->data}</dd>
							</dl>
							<dl>
								<dt>homepage:</dt>
								<dd>{$oInfo->homepage}</dd>
							</dl>
							<dl>
								<dt>version:</dt>
								<dd>{$oInfo->version}</dd>
							</dl>
							<dl>
								<dt>description:</dt>
								<dd>{$oInfo->description->data}</dd>
							</dl>
						</div>
					{/if}
				</div>
			</div>
