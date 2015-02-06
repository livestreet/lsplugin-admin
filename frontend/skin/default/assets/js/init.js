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

jQuery(document).ready(function($) {

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

	$('[data-type=tab]').lsTab();
	
	$('.js-alert').lsAlert();

	/**
	 * Modals
	 */
	$('.js-modal-default').lsModal();


	/**
	 * Datepicker
	 */
	$('.date-picker').datepicker();


	/**
	 * Datepicker with php date format
	 */
	$('.date-picker-php').datepicker({
		/*
		 	формат даты изменен для удобства работы с ней на стороне php
		 */
		dateFormat: 'yy-mm-dd'
	});


	/**
	 * Dropdowns
	 */
	$('.js-dropdown').lsDropdown({
	    position: {
	        my: "right+10 top+10",
	        at: "right bottom",
	        collision: "flipfit flip"
		},
		body: true,
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
		body: true,
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
	        my: "right top",
	        at: "right bottom",
	        collision: "flipfit flip"
		},
		body: true,
		beforeshow: function (e, dropdown) {
			// Задаем минимальную ширину меню
			var toggleWidth = dropdown.element.outerWidth();
			dropdown.getMenu().css('width', toggleWidth > 200 ? toggleWidth : 'auto' );
		},
		show: {
			effect: 'fadeIn'
		},
		hide: {
			effect: 'fadeOut'
		}
	});


	/**
	 * Tooltips
	 */
	$('.js-tooltip').lsTooltip();


	/**
	 * Autocomplete
	 */
	$( '.autocomplete-users' ).lsAutocomplete({
		multiple: false,
		urls: {
			load: aRouter.ajax + 'autocompleter/user/'
		}
	});


	/**
	 * Scroll
	 */
	$(window)._scrollable();


	/**
	 * Code highlight
	 */
	$( 'pre code' ).lsHighlighter();

	/**
	 * вопрос при активации элементов интерфейса
	 */
	$ ('.js-question').bind ('click.admin', function() {
		var sMsg = $ (this).attr ('data-question-title') ? $ (this).attr ('data-question-title') : $ (this).attr ('title') + '?';
		sMsg = sMsg ? sMsg : 'Ok?';
		if (!confirm (sMsg)) return false;
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
		var checkboxes = $( '.' + checkAll.data('checkboxes-class') );

		if ( checkAll.is(':checked') ) checkboxes.iCheck('check'); else checkboxes.iCheck('uncheck');
	});


	/**
	 * Main navigation
	 */
	ls.plugin.admin.navMain.init();

	/**
	 * Механизм заметок для пользователей
	 */
	$('.js-user-note').livequery(function () {
		$(this).usernote();
	});
});