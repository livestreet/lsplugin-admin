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

<form id="form-article-create" enctype="multipart/form-data" action="" method="post" data-content-action="{( $oArticle ) ? 'edit' : 'add'}" >

	{component 'admin:field' template='text'
		name        = 'article[title]'
		value       = ( $oArticle ) ? $oArticle->getTitle() : ''
		label       = 'Заголовок'}


	{* Подключаем блок для управления категориями *}
	{insert name='block' block='fieldCategory' params=[ 'target' => $oArticle, 'entity' => 'PluginArticle_ModuleMain_EntityArticle' ]}

	{* Показывает дополнительные поля *}
	{insert name='block' block='propertyUpdate' params=[ 'target' => $oArticle, 'entity' => 'PluginArticle_ModuleMain_EntityArticle' ]}

	{* Кнпоки *}
	{if $oArticle}
		{component 'admin:field' template='hidden'
			name        = 'article[id]'
			value       = $oArticle->getId() }
	{/if}

	<br/>

	{component 'button' type='submit' form='form-article-create' text=( $oArticle ) ? 'Сохранить' : 'Добавить'}
</form>
