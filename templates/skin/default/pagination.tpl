{**
 * Пагинация
 *
 * @styles assets/css/pagination.css
 *}

{if $aPaging and $aPaging.iCountPage > 1} 
	{strip}
		<div class="pagination">
			<div class="pagination-item pagination-item-prev">
				{if $aPaging.iPrevPage}
					<a href="{$aPaging.sBaseUrl}{if $aPaging.iPrevPage>1}/page{$aPaging.iPrevPage}{/if}/{$aPaging.sGetParams}" class="js-paging-prev-page">
						<i></i>{$aLang.plugin.admin.pagination.prev}
					</a>
				{else}
					<span><i></i>{$aLang.plugin.admin.pagination.prev}</span>
				{/if}
			</div>

			
			<div class="pagination-item pagination-item-next">
				{if $aPaging.iNextPage}
					<a href="{$aPaging.sBaseUrl}/page{$aPaging.iNextPage}/{$aPaging.sGetParams}" class="js-paging-next-page">{$aLang.plugin.admin.pagination.next}<i></i></a>
				{else}
					<span>{$aLang.plugin.admin.pagination.next}<i></i></span>
				{/if}
			</div>


			<ul class="pagination-list">
				{foreach from=$aPaging.aPagesLeft item=iPage}
					<li class="pagination-item"><a href="{$aPaging.sBaseUrl}{if $iPage>1}/page{$iPage}{/if}/{$aPaging.sGetParams}">{$iPage}</a></li>
				{/foreach}
				
				<li class="pagination-item active"><span>{$aPaging.iCurrentPage}</span></li>
				
				{foreach from=$aPaging.aPagesRight item=iPage}
					<li class="pagination-item"><a href="{$aPaging.sBaseUrl}{if $iPage>1}/page{$iPage}{/if}/{$aPaging.sGetParams}">{$iPage}</a></li>
				{/foreach}
			</ul>
		</div>
	{/strip}
{/if}