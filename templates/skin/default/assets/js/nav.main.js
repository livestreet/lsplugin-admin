/**
 * Главное меню
 * 
 * @module ls/plugin/admin/navMain
 * 
 * @license   GNU General Public License, version 2
 * @copyright 2013 OOO "ЛС-СОФТ" {@link http://livestreetcms.com}
 * @author    Denis Shakhov <denis.shakhov@gmail.com>
 */

var ls = ls || {};
ls.plugin = ls.plugin || {};
ls.plugin.admin = ls.plugin.admin || {};

ls.plugin.admin.navMain = (function ($) {
	"use strict";

	/**
	 * jQuery объект меню
	 */
	var oNav = null,
		oToggle = null,
		oBody = null,
		oWindow = null;

	/**
	 * Дефолтные опции
	 * 
	 * @private
	 */
	var _defaults = {
		// Селекторы
		selectors: {
			nav: '.js-nav-main',
			toggle: '.js-nav-main-fold',
			toggleMobile: '.js-nav-main-fold-mobile',
			subMenu: '.js-nav-main-submenu'
		},
		classes: {
			folded: 'is-nav-main-folded',
			dropdownMenu: 'dropdown-menu-nav-main'
		},
		cookie: {
			folded: 'plugin_admin_nav_main_folded',
			items: 'plugin_admin_nav_main_items'
		}
	};

	/**
	 * Инициализация
	 *
	 * @param {Object} options Опции
	 */
	this.init = function(options) {
		var self = this;

		this.options = $.extend({}, _defaults, options);
		this.cookie = $.cookie(this.options.cookie.items);

		oNav = $(this.options.selectors.nav);
		oToggle = $(this.options.selectors.toggle);
		oBody = $('body');
		oWindow = $(window);

		// Проверяем свернуто меню или нет
		if ( $.cookie(this.options.cookie.folded) ) this.fold();

		// Сворачивает / разворачивает меню
		oToggle.on('click', function (e) {
			this.toggle();
			e.preventDefault();
		}.bind(this));

		/**
		 * Подменю
		 */

		// Сворачивает / разворачивает подменю
		oNav.find('.js-nav-main-item-root > a').on('click', function (e) {
			var oItem = $(this).closest('li'),
				oSubMenu = oItem.find('ul'),
				isOpen = oItem.hasClass('open');

			self[ isOpen ? 'closeSubMenu' : 'openSubMenu' ](oSubMenu, oItem);

			e.preventDefault();
		});

		// Открывает подменю при загрузке страницы
		$('.js-nav-main-item-root').each(function () {
			var oItem = $(this),
				oSubMenu = oItem.find('ul'),
				iId = oItem.data('item-id'),
				sCookie = $.cookie(self.options.cookie.items),
				aItems = sCookie ? sCookie.split(',') : [];

			if ( aItems.indexOf(iId + "") !== -1 ) {
				oItem.addClass('open');
				oSubMenu.show();
			}
		});

		/**
		 * Мобильная версия
		 */

		// Скрыть / показать меню
		$(this.options.selectors.toggleMobile).on('click', function () {
			oNav.toggleClass('open');
		}.bind(this));

		oWindow.on('resize', function () {
			this.checkMobile();
		}.bind(this));

		this.checkMobile();
	};

	/**
	 * 
	 */
	this.checkMobile = function (oSubMenu, oItem) {
		if ( oWindow.width() <= 999 && oBody.hasClass(this.options.classes.folded)) this.unfold();
	};

	/**
	 * 
	 */
	this.openSubMenu = function (oSubMenu, oItem) {
		if ( oBody.hasClass(this.options.classes.folded) ) return;

		this.add( oItem.data('item-id') );

		oItem.addClass('open');
		oSubMenu.slideDown(200);
	};

	/**
	 * 
	 */
	this.closeSubMenu = function (oSubMenu, oItem) {
		this.remove( oItem.data('item-id') );

		oItem.removeClass('open');
		oSubMenu.slideUp(200);
	};

	/**
	 * 
	 */
	this.add = function (iId) {
		var sCookie = $.cookie(this.options.cookie.items);
		var aItems = sCookie ? sCookie.split(',') : [];

		aItems.push(iId);
		$.cookie(this.options.cookie.items, aItems.join(','), { path: '/', expires: 999 });
	};

	/**
	 * 
	 */
	this.remove = function (iId) {
		var sCookie = $.cookie(this.options.cookie.items);
		var aItems = sCookie ? sCookie.split(',') : [];
		var index = aItems.indexOf(iId + "");

		if (index !== -1) aItems.splice(index, 1);
		$.cookie(this.options.cookie.items, aItems.join(','), { path: '/', expires: 999 });
	};

	/**
	 * 
	 */
	this.dropdownsInit = function () {
		var _this = this;

		oNav.find(this.options.selectors.subMenu).each(function () {
			var oSubMenu = $(this);

			oSubMenu.clone()
					.addClass('dropdown-menu ' + _this.options.classes.dropdownMenu)
					.attr('id', 'dropdown-menu-nav-main-' + oSubMenu.closest('li').data('item-id'))
					.appendTo(oBody);
		});

		$('.js-dropdown-nav-main').dropdown({
			position: {
				my: "right-8 top-4",
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
		});
	};

	/**
	 * 
	 */
	this.dropdownsDestroy = function () {
		$('.' + this.options.classes.dropdownMenu).remove();
		$('.js-dropdown-nav-main').dropdown('destroy');
	};

	/**
	 * Сворачивает / разворачивает меню
	 */
	this.toggle = function () {
		this[ oBody.hasClass(this.options.classes.folded) ? 'unfold' : 'fold' ]();
	};

	/**
	 * Сворачивает главное меню
	 */
	this.fold = function () {
		oBody.addClass(this.options.classes.folded);
		oWindow.trigger('resize');
		this.dropdownsInit();
		$.cookie(this.options.cookie.folded, 1, { path: '/', expires: 999 });
	};

	/**
	 * Разворачивает главное меню
	 */
	this.unfold = function () {
		oBody.removeClass(this.options.classes.folded);
		oWindow.trigger('resize');
		this.dropdownsDestroy();
		$.cookie(this.options.cookie.folded, null, { path: '/', expires: '' });
	};

	return this;
}).call(ls.captcha || {}, jQuery);