{extends file='layouts/layout.base.tpl'}

{block name='layout_content'}

{include file=$aTemplatePathPlugin.article|cat:'article.list.tpl' aArticleItems=$aArticleItems}

{include file='pagination.tpl' aPaging=$aPaging}

{/block}