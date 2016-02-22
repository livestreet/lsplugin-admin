/**
 * Менеджер cron
 *
 * @module ls/plugin/admin/cron
 *
 * @license   GNU General Public License, version 2
 * @copyright 2013 OOO "ЛС-СОФТ" {@link http://livestreetcms.com}
 */

var ls = ls || {};

ls.admin_cron = ( function($) {

    this.runTask = function(id) {
        ls.ajax.load(aRouter.admin + 'utils/cron/ajax-run/', { id: id }, function(res) {
            if (res.sHtmlRow) {
                $('#cron-item-' + id).replaceWith(res.sHtmlRow);
            }
        }.bind(this));

        return false;
    };

    return this;
}).call(ls.admin_cron || {}, jQuery);