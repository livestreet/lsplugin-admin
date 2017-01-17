/**
 * Menu
 */

(function($) {
    "use strict";

    $.widget( "livestreet.lsAdminMenu", $.livestreet.lsComponent, {
        /**
         * Дефолтные опции
         */
        options: {
            // Селекторы
            selectors: {
                fold: '.js-menu-fold',
                mobileToggle: '.js-menu-mobile-toggle',
                nav: '.js-menu-nav',
                section: '.js-menu-section',
                sectionToggle: '.js-menu-section-toggle'
            },

            // Классы
            classes : {
                folded: 'folded',
                bodyFolded: 'is-nav-main-folded',
                open: 'open'
            },

            cookie: {
                folded: 'plugin_admin_nav_main_folded',
                items: 'plugin_admin_nav_main_items'
            },

            mobileWidth: 999
        },

        /**
         * Конструктор
         *
         * @constructor
         * @private
         */
        _create: function () {
            this._super();

            this._closedSections = this._getClosedSections();

            this._checkClosedSections();
            this._checkFold();

            this._on(this.elements.fold, { click: 'toggleFold' });
            this._on(this.elements.mobileToggle, { click: 'toggleMobile' });
            this._on(this.elements.sectionToggle, { click: 'toggleSection' });
            this._on(this.window, { resize: '_checkMobile' });
        },

        /**
         * 
         */
        toggleMobile: function() {
            this.element.toggleClass(this.option('classes.open'));
        },

        /**
         * 
         */
        _checkMobile: function() {
            if ( this.window.width() <= this.option('mobileWidth') && this.isFolded()) this.unfold();
        },

        /**
         * 
         */
        _checkFold: function() {
            if ($.cookie(this.options.cookie.folded)) this.fold();
        },

        /**
         * 
         */
        _checkClosedSections: function(event) {
            this.elements.section.each(function (index, section) {
                section = $(section);

                if (this._closedSections.indexOf(section.data('uid')) !== -1) {
                    this.closeSection(section, false);
                }
            }.bind(this));
        },

        /**
         * 
         */
        _addClosedSection: function(uid) {
            this._closedSections.push(uid);
            this._saveClosedSections();
        },

        /**
         * 
         */
        _removeClosedSection: function(uid) {
            var index = this._closedSections.indexOf(uid);
            if (index !== -1) this._closedSections.splice(index, 1);

            this._saveClosedSections();
        },

        /**
         * 
         */
        _getClosedSections: function() {
            return ($.cookie(this.options.cookie.items) || "").split(',');
        },

        /**
         * 
         */
        _saveClosedSections: function() {
            $.cookie(this.options.cookie.items, this._closedSections.join(','), { path: '/', expires: 999 });
        },

        /**
         * 
         */
        toggleSection: function(event) {
            if (this.isFolded()) return;

            var section = $(event.target).closest(this.option('selectors.section'));

            this[ this._hasClass(section, 'open') ? 'closeSection' : 'openSection' ](section, true);
            event.preventDefault();
        },

        /**
         * 
         */
        openSection: function(section, save) {
            if (this.isFolded()) return;

            this._addClass(section, 'open');
            save && this._removeClosedSection(section.data('uid'));
        },

        /**
         * 
         */
        closeSection: function(section, save) {
            if (this.isFolded()) return;

            this._removeClass(section, 'open');
            save && this._addClosedSection(section.data('uid'));
        },

        /**
         * 
         */
        toggleFold: function(event) {
            event && event.preventDefault();

            this[ this.isFolded() ? 'unfold' : 'fold' ]();
        },

        /**
         * 
         */
        fold: function() {
            this._addClass('folded');
            this._addClass($('body'), 'bodyFolded');
            this._dropdownInit();
            $.cookie(this.options.cookie.folded, 1, { path: '/', expires: 999 });
        },

        /**
         * 
         */
        unfold: function() {
            this._removeClass('folded');
            this._removeClass($('body'), 'bodyFolded');
            this._dropdownDestroy();
            $.cookie(this.options.cookie.folded, null, { path: '/', expires: -1 });
        },

        /**
         * 
         */
        isFolded: function() {
            return this._hasClass('folded');
        },

        /**
         * 
         */
        _dropdownInit: function() {
            this.elements.section.each(function (index, section) {
                section = $(section);

                var submenu = section
                    .find('.p-menu-section-submenu')
                    .clone()
                    .addClass('ls-dropdown-menu js-dropdown-menu')
                    .appendTo(section);

                section.lsDropdown({
                    selectors: {
                        toggle: '.js-menu-section-toggle',
                        menu: '.js-dropdown-menu'
                    },
                    position: {
                        my: "right-5 top",
                        at: "left top",
                        collision: "none none"
                    },
                    body: false,
                    show: {
                        effect: 'fadeIn'
                    },
                    hide: {
                        effect: 'fadeOut'
                    }
                })
            }.bind(this));
        },

        /**
         * 
         */
        _dropdownDestroy: function() {
            this.elements.section.lsDropdown('destroy');
            this.element.find('.js-dropdown-menu').remove();
        }
    });
})(jQuery);
