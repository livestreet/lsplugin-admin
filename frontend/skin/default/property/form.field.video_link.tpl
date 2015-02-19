{$oValue = $oProperty->getValue()}

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
		 sFieldName    = "property[{$oProperty->getId()}]"
		 sFieldValue   = $oValue->getValueVarchar()
		 sFieldClasses = 'width-300'
		 sFieldNote = $oProperty->getDescription()
		 sFieldLabel   = $oProperty->getTitle()}


{component 'admin:modal'
	title   = {lang 'property.video.preview'}
	content = $oValue->getValueTypeObject()->getVideoCodeFrame()
	classes = 'js-modal-default'
	mods    = 'property property-video'
	id      = "modal-property-type-video-{$oValue->getId()}"}

<p class="mb-20"><a href="#" class="link-dotted" data-modal-target="modal-property-type-video-{$oValue->getId()}">Смотреть</a></p>