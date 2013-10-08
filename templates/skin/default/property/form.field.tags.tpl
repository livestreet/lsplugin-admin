{$oValue=$oProperty->getValue()}

{$oProperty->getTitle()}:
<input type="text" value="{$oValue->getValueVarchar()}" name="property[{$oProperty->getId()}]" class="width-500" id="property-value-tags-{$oProperty->getId()}"><br/><br/>
<script type="text/javascript">
	jQuery(function($){
        ls.autocomplete.add($("#property-value-tags-{$oProperty->getId()}"), aRouter['ajax']+'property/tags/autocompleter/', true, { property_id: '{$oValue->getPropertyId()}' });
	});
</script>