/**
 * Report
 */

var ls = ls || {};

ls.admin_user_report = (function($) {
    /**
     * @constructor
     */
    this.init = function() {
        $('#js-admin-user-complaint-answer-form').livequery(function () {
            ls.ajax.form(aRouter['admin'] + 'users/complaints/ajax-modal-view/', $(this), function() {
                $('#js-admin-modal-complaint-view').lsModal('hide');
            });
        });
    };

    return this;
}).call(ls.admin_user_report || {}, jQuery);

jQuery(document).ready(function($) {
    ls.admin_user_report.init();
});