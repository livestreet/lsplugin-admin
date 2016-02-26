{component_define_params params=[ 'report' ]}

<form action="" method="post" id="js-admin-user-complaint-answer-form">
    {component 'admin:field' template='hidden' name='complaint_id' value=$report->getId()}
    {component 'admin:field' template='hidden' name='submit_answer' value=1}

    {* текст жалобы *}
    {if $report->getText()}
        <div class="ls-text">
            <blockquote>
                {$report->getText()}
            </blockquote>
        </div>
    {/if}

    {* кому ответить *}
    {component 'admin:field' template='select' name='type' label=$aLang.plugin.admin.users.complaints.view.answer.type_note items=[
        ['value' => 'user', 'text' => $aLang.plugin.admin.users.complaints.view.answer.types.user|ls_lang:"login%%`$report->getUser()->getLogin()`"],
        ['value' => 'target_user', 'text' => $aLang.plugin.admin.users.complaints.view.answer.types.target_user|ls_lang:"login%%`$report->getTargetUser()->getLogin()`"]
    ]}

    {* ответ *}
    {component 'admin:field' template='textarea'
        name='answer'
        rows=5
        value=$aLang.plugin.admin.users.complaints.view.answer.default_text
        label=$aLang.plugin.admin.users.complaints.view.answer.text_note}
</form>