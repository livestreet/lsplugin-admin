{**
 * Добавление/редактирование статьи
 *
 * @param array $oArticle Объект редактируемой статьи
 *}

<h3 class="page-sub-header">
	{if $oArticle}
		Редактирование статьи
	{else}
		Добавление статьи
	{/if}
</h3>

<form id="form-article-create" enctype="multipart/form-data" action="" method="post" onsubmit="{if $oArticle}ls.plugin.article.admin.updateArticle('form-article-create');{else}ls.plugin.article.admin.createArticle('form-article-create');{/if} return false;">
	{if $oArticle}
		{$sFieldValue = $oArticle->getTitle()}
	{/if}

	{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
			 sFieldName  = 'article[title]'
			 sFieldValue = $sFieldValue
			 sFieldLabel = 'Заголовок'}


	{* Подключаем блок для управления категориями *}
	{insert name="block" block="categoryUpdate" params=[ 'plugin' => 'admin', 'target' => $oArticle, 'entity' => 'PluginArticle_ModuleMain_EntityArticle' ]}


	{* Подключаем блок для управления дополнительными свойствами *}
	{$aBlockParams = []}
	{$aBlockParams.plugin = 'admin'}
	{$aBlockParams.target_type = 'article'}

	{if $oArticle}
		{$aBlockParams.target_id = $oArticle->getId()}
	{/if}

	{insert name="block" block="propertyUpdate" params=$aBlockParams}

	{* Кнпоки *}
	{if $oArticle}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.hidden.tpl" sFieldName='article[id]' sFieldValue=$oArticle->getId()}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.button.tpl"
				 sFieldName  = 'article[submit]'
				 sFieldStyle = 'primary'
				 sFieldText  = 'Сохранить'}
	{else}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.button.tpl"
				 sFieldName  = 'article[submit]'
				 sFieldStyle = 'primary'
				 sFieldText  = 'Добавить'}
	{/if}
</form>
