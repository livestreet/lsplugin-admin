/**
 * Дополнительные поля
 *
 * @module ls/plugin/admin/property
 *
 * @license   GNU General Public License, version 2
 * @copyright 2013 OOO "ЛС-СОФТ" {@link http://livestreetcms.com}
 */

var ls = ls || {};

ls.admin_topic = ( function($) {

    this.initTableType = function() {
        /**
         * todo: см. property.js
         * 
         * @param e
         * @param ui
         * @returns {*}
         */
        var fixHelper = function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        };

        // $('#type-list tbody').sortable({
        //  cursor: 'move',
        //  helper: fixHelper,
        //  update: this.UpdateTableTypeSort
        // }).disableSelection();
    };
    

    this.UpdateTableTypeSort = function(e, ui) {
        var items = $('#type-list tbody tr');
        var data = [];
        /**
         * * todo: см. property.js
         */
        items.each(function(k, v) {
            data.push({ id: $(v).data('typeId'), sort: items.length - k });
        });
        if (data.length) {
            ls.ajax.load(aRouter.admin + 'settings/topic-type/ajax-sort/', { data: data }, function(result) {
                if (result.bStateError) {
                    ls.msg.error(null, result.sMsg);
                } else {
                    ls.msg.notice(null, result.sMsg);
                }
            });
        }
    };

    return this;
    
}).call(ls.admin_topic || {}, jQuery);
