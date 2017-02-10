/**
 * LiveStreet CMS
 * Copyright © 2013 OOO "ЛС-СОФТ"
 *
 * ------------------------------------------------------
 *
 * Official site: www.livestreetcms.com
 * Contact e-mail: office@livestreetcms.com
 *
 * GNU General Public License, version 2:
 * http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * ------------------------------------------------------
 *
 * @link http://www.livestreetcms.com
 * @copyright 2013 OOO "ЛС-СОФТ"
 * @author Serge Pustovit (PSNet) <light.feel@gmail.com>
 *
 */

jQuery(document).ready(function ($) {

    /**
     * Иниц-ия модулей ядра
     */
    ls.init({
        production: false
    });

    /**
     * Popovers
     */
    $('.js-popover-default').lsTooltip({
        useAttrTitle: false,
        trigger: 'click',
        classes: 'tooltip-light'
    });

    $('[data-type=tabs]').lsTabs();
    $('[data-type=tab]').lsTab();

    $('.js-alert').lsAlert();

    /**
     * Modals
     */
    $('.js-modal-default').lsModal();
    $('.js-modal-toggle-default').lsModalToggle();

    /**
     * Details
     */
    $('.js-details-default').lsDetails();

    /**
     * Confirm
     */
    $('.js-confirm-remove').livequery(function () {
        $(this).lsConfirm({
            message: 'Действительно удалить?'
        });
    });


    /**
     * Datepicker
     */
    $('.js-field-date-default').livequery(function () {
        $(this).lsDate({
            language: LANGUAGE
        });
    });
    $('.js-field-time-default').livequery(function () {
        $(this).lsTime();
    });


    /**
     * Datepicker with php date format
     */
    $('.date-picker-php').livequery(function () {
        $(this).lsDate({ format: 'YYYY-MM-DD'});
    });


    /**
     * Fields
     */
    $('.js-field-geo-default').lsFieldGeo({
        urls: {
            regions: aRouter.ajax + 'geo/get/regions/',
            cities: aRouter.ajax + 'geo/get/cities/'
        }
    });

    /**
     * Dropdowns
     */
    $('.js-dropdown').lsDropdown({
        position: {
            my: "right top+5",
            at: "right bottom",
            collision: "flipfit flip"
        },
        //body: true,
        show: {
            effect: 'fadeIn'
        },
        hide: {
            effect: 'fadeOut'
        }
    });
    /*
     используется для списка сортировок столбца таблицы
     */
    $('.js-dropdown-left-bottom').lsDropdown({
        position: {
            my: "left-10 top+10",
            at: "left bottom",
            collision: "flipfit flip"
        },
        //body: true,
        show: {
            effect: 'fadeIn'
        },
        hide: {
            effect: 'fadeOut'
        }
    });

    /* Юзербар */
    $('.js-dropdown-userbar').lsDropdown({
        position: {
            my: "right top+5",
            at: "right bottom",
            collision: "flipfit flip"
        },
        //body: true,
        beforeshow: function (e, dropdown) {
            // Задаем минимальную ширину меню
            var toggleWidth = dropdown.element.outerWidth();
            dropdown.getMenu().css('width', toggleWidth > 200 ? toggleWidth : 'auto');
        },
        show: {
            effect: 'fadeIn'
        },
        hide: {
            effect: 'fadeOut'
        }
    });

    $('.js-admin-actionbar-dropdown').lsDropdown({
        selectable: true
    });


    /**
     * Tooltips
     */
    $('.js-tooltip').lsTooltip();


    /**
     * Autocomplete
     */
    $('.autocomplete-users').lsAutocomplete({
        multiple: false,
        urls: {
            load: aRouter.ajax + 'autocompleter/user/'
        }
    });

    $('.autocomplete-property-tags').each(function(k,v){
        $(v).lsAutocomplete({
            multiple: false,
            urls: {
                load: aRouter.ajax + 'property/tags/autocompleter/'
            },
            params: {
                property_id: $(v).data('propertyId')
            }
        });
    });

    $('.autocomplete-property-tags-sep').each(function(k,v){
        $(v).lsAutocomplete({
            multiple: true,
            urls: {
                load: aRouter.ajax + 'property/tags/autocompleter/'
            },
            params: {
                property_id: $(v).data('propertyId')
            }
        });
    });

    /**
     * Editor
     */
    $( '.js-editor-default' ).lsEditor();


    /**
     * Code highlight
     */
    $('pre code').lsHighlighter();

    /**
     * вопрос при активации элементов интерфейса
     */
    $('.js-question').bind('click.admin', function () {
        var sMsg = $(this).attr('data-question-title');
        if (!sMsg && $(this).attr('title')) {
            sMsg = $(this).attr('title') + '?';
        }
        sMsg = sMsg ? sMsg : 'Ok?';
        if (!confirm(sMsg)) return false;
    });

    /**
     * Custom checkboxes and radios
     */
    $('input').iCheck({
        labelHover: false,
        cursor: true,
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal'
    });

    /* Выделение всех чексбоксов */
    $('.js-check-all').on('ifChanged', function () {
        var checkAll = $(this);
        var checkboxes = $('.' + checkAll.data('checkboxes-class'));

        if (checkAll.is(':checked')) checkboxes.iCheck('check'); else checkboxes.iCheck('uncheck');
    });


    /**
     * Main navigation
     */
    $('.js-menu').lsAdminMenu();

    /**
     * Activity
     */
    $('.js-dashboard-activity').lsActivity({ urls: { more: aRouter.stream + 'get_more_all' } });

    /**
     * Механизм заметок для пользователей
     */
    $('.js-user-profile-note').livequery(function () {
        $(this).lsNote({
            urls: {
                save:   aRouter['profile'] + 'ajax-note-save/',
                remove: aRouter['profile'] + 'ajax-note-remove/'
            }
        });
    });
});
