{**
 * Просмотр жалобы на пользователя
 *
 * @styles css/modals.css
 *}

{capture 'modal_content'}
	<form action="" method="post" onsubmit="return false;" id="js-admin-user-complaint-answer-form">
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.hidden.tpl"
			sFieldName='complaint_id'
			sFieldValue=$oComplaint->getId()
		}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.hidden.tpl"
			sFieldName='submit_answer'
			sFieldValue=1
		}

		{*
			текст жалобы
		*}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.textarea.tpl"
			sFieldValue = $oComplaint->getText()
			iFieldRows    = 5
			sFieldClasses = 'width-full'
			bFieldIsDisabled = true
		}
		{*
			кому ответить
		*}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.select.tpl"
			sFieldName          = 'type'
			sFieldLabel         = $aLang.plugin.admin.users.complaints.view.answer.type_note
			sFieldClasses       = 'width-full'
			aFieldItems         = [
				['value' => 'user', 'text' => $aLang.plugin.admin.users.complaints.view.answer.types.user|ls_lang:"login%%`$oComplaint->getUser()->getLogin()`"],
				['value' => 'target_user', 'text' => $aLang.plugin.admin.users.complaints.view.answer.types.target_user|ls_lang:"login%%`$oComplaint->getTargetUser()->getLogin()`"]
			]
		}
		{*
			ответ
		*}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.textarea.tpl"
			sFieldName    = 'answer'
			sFieldValue = $aLang.plugin.admin.users.complaints.view.answer.default_text
			iFieldRows    = 5
			sFieldLabel   = $aLang.plugin.admin.users.complaints.view.answer.text_note
			sFieldClasses = 'width-full'
		}
	</form>
{/capture}

{component 'modal'
	title         = "{$aLang.plugin.admin.users.complaints.view.title} \"{$oComplaint->getTypeTitle()}\""
	content       = $smarty.capture.modal_content
	classes       = 'js-modal-default'
	id            = 'js-admin-modal-complaint-view'
	primaryButton  = [
		'text'    => {lang 'plugin.admin.users.complaints.view.answer.button'},
		'classes' => 'js-admin-user-complaint-send-answer',
		'attributes' => [
			'data-user-complaint-form-id' => '#js-admin-user-complaint-answer-form',
			'data-user-complaint-modal-id' => '#js-admin-modal-complaint-view'
		]
	]
}