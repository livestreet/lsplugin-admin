/**
 * Дополнительные поля
 *
 * @module ls/plugin/admin/property
 *
 * @license   GNU General Public License, version 2
 * @copyright 2013 OOO "ЛС-СОФТ" {@link http://livestreetcms.com}
 */

var ls = ls || {};

ls.admin_property = ( function($) {

    this.clickSelectItemNew = function(el) {
        if (el) {
            var el = $(el);
        } else {
            var el = $('#property-select-items');
        }
        var $aItems = el.find('.js-property-select-item');

        if ($aItems.length) {
            var $aItemNew = $($aItems[0]).clone();
            $aItemNew.find('.js-property-select-item-value').val('');
            $aItemNew.find('.js-property-select-item-sort').val('10');
            $aItemNew.find('.js-property-select-item-id').val('');

            el.append($aItemNew);
        }
        return false;
    };


    this.clickSelectItemRemove = function(obj) {
        obj = $(obj);

        var area = obj.parents('.js-property-select-area');

        if (area.find('.js-property-select-item').length < 2) return false;

        obj.parent().fadeOut(function() {
            $(this).remove();
        });

        return false;
    };


    this.initTableProperty = function() {
        /**
         * todo:
         *      1. вынести хелпер в общие, чтобы можно было повторно использовать в сортировке типов топиков и здесь
         *      т.к. данный хелпер может быть полезен и для плагинов
         *
         */
        var fixHelper = function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        };

        // $('#property-list tbody').sortable({
        //  cursor: 'move',
        //  helper: fixHelper,
        //  update: this.UpdateTableTypeSort
        // }).disableSelection();
    };


    this.UpdateTableTypeSort = function(e, ui) {
        var items = $('#property-list tbody tr');
        var data = [];
        /**
         * todo:
         *      2. вынести метод получения ид для отправки на сортировку в метод для повторного использования при сортировке типов топиков
         *      т.к. данный метод может быть полезен и для плагинов
         *
         */
        items.each(function(k, v) {
            data.push({ id: $(v).data('id'), sort: items.length - k });
        });
        if (data.length) {
            ls.ajax.load(aRouter.admin + 'ajax/properties/sort-save/', { data: data }, function(result) {
                if (result.bStateError) {
                    ls.msg.error(null, result.sMsg);
                } else {
                    ls.msg.notice(null, result.sMsg);
                }
            });
        }
    };

    return this;

}).call(ls.admin_property || {}, jQuery);
