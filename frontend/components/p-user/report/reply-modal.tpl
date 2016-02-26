{component_define_params params=[ 'report' ]}

{component 'modal'
    title         = "{$aLang.plugin.admin.users.complaints.view.title} \"{$report->getTypeTitle()}\""
    content       = {component 'admin:p-user' template='report-reply' report=$report}
    classes       = 'js-modal-default'
    id            = 'js-admin-modal-complaint-view'
    primaryButton  = [
        'text'    => {lang 'plugin.admin.users.complaints.view.answer.button'},
        'form' => 'js-admin-user-complaint-answer-form'
    ]}