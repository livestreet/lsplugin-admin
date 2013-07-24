{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}

	<h2 class="Title mb20">
		{$aLang.plugin.admin.settings.titles.skin_config}
	</h2>
	
	<div class="SkinList">
		{foreach from=$aSkins item=oSkin name=SkinForCycle}
			<div class="OneSkin {if $smarty.foreach.SkinForCycle.iteration % 2 == 0}second{/if}">
				<div class="Preview">
					{assign var="sPreview" value='default.png'}
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
						<a href="#" class="button button-primary">use skin</a>											{* todo: *}
						<a href="#" class="button">preview</a>
					</div>
					<h4>{$sName}</h4>
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
		{/foreach}
	</div>
	
{/block}