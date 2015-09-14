{**
 * Форма поиска по тегам
 *
 * @styles css/forms.css
 *}

{component 'search-form' name='main' inputName='tag'  value=$sTag placeholder="{$aLang.block_tags_search}" inputAttributes=[ "data-property-id" => $oPropertyTags->getId() ] inputClasses="autocomplete-property-tags"}