{$oValue=$oProperty->getValue()}

{$oProperty->getTitle()}:
{include file="{$aTemplatePathPlugin.admin}modals/modal.property_type_video.tpl" oValue=$oValue}
<a href="#" data-type="modal-toggle" data-option-target="modal-property-type-video-{$oValue->getId()}">see!</a>
<input type="text" value="{$oValue->getValueVarchar()}" name="property[{$oProperty->getId()}]" class="width-500"><br/><br/>