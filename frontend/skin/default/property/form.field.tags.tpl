{$oValue = $oProperty->getValue()}

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
		 sFieldName  = "property[{$oProperty->getId()}]"
		 sFieldValue = $oValue->getValueVarchar()
		 sFieldId    = "property-value-tags-{$oProperty->getId()}"
		 sFieldNote = $oProperty->getDescription()
		 sFieldLabel = $oProperty->getTitle()}

<script>
	jQuery(function($){
        $( "#property-value-tags-{$oProperty->getId()}" ).lsAutocomplete({
			multiple: true,
			urls: {
				load: aRouter['ajax']+'property/tags/autocompleter/'
			},
			params: {
				property_id: '{$oValue->getPropertyId()}'
			}
		});
	});
</script>