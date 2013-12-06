{$oValue = $oProperty->getValue()}

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
		 sFieldName    = "property[{$oProperty->getId()}]"
		 sFieldValue   = $oValue->getValueVarchar()
		 sFieldClasses = 'width-300'
		 sFieldLabel   = $oProperty->getTitle()}

{* TODO: Модального нету *}
{include file="{$aTemplatePathPlugin.admin}modals/modal.property_type_video.tpl" oValue=$oValue}
<p class="mb-20"><a href="#" class="link-dotted" data-modal-target="modal-property-type-video-{$oValue->getId()}">Смотреть</a></p>