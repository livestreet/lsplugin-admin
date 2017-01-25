jQuery(function($) {
    var selectors = {
        on_page_form_id: '#admin_onpage',
        on_page_count: '#admin_onpage select'
    };

    /*
        изменение количества элементов на страницу
        обработка формы через аякс
     */
    $(selectors.on_page_form_id).ajaxForm({
        dataType: 'json',
        beforeSend: function() {},
        success: function(data) {
            if (data.bStateError) {
                ls.msg.error(data.sMsgTitle, data.sMsg);
            } else {
                ls.msg.notice('', ls.lang.get('plugin.admin.notices.items_per_page.value_changed'));
            }
        },
        complete: function(xhr) {
            window.location.reload(true);
        }
    });
    /*
        послать запрос при изменении количества элементов в селекте
     */
    $(document).on('change.admin', selectors.on_page_count, function () {
        $ (selectors.on_page_form_id).submit();
    });
});