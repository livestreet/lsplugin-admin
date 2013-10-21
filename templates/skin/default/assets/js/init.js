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
	 * Popovers
	 */
	$('.js-popover-default').tooltip({
		useAttrTitle: false,
		trigger: 'click',
		classes: 'tooltip-light'
	});

	$('[data-type=tab]').tab();
	
	$('.js-alert').alert();

	/**
	 * Modals
	 */
	$('.js-modal-default').modal();


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
	$('.js-dropdown').dropdown({
	    position: {
	        my: "right+10 top+10",
	        at: "right bottom",
	        collision: "flipfit flip"
		},
		body: true
	});
	/*
		используется для списка сортировок столбца таблицы
	 */
	$('.js-dropdown-left-bottom').dropdown({
		position: {
			my: "left-10 top+10",
			at: "left bottom",
			collision: "flipfit flip"
		},
		body: true
	});


	/**
	 * Tooltips
	 */
	$('.js-tooltip').tooltip();


	/**
	 * Autocomplete
	 */
	ls.autocomplete.add($(".autocomplete-users"), aRouter['ajax']+'autocompleter/user/', false);


	/**
	 * Scroll
	 */
	$(window)._scrollable();


	/**
	 * Code highlight
	 */
	prettyPrint();

	/*
		вопрос при активации элементов интерфейса
	 */
	$ ('.ls-admin .question').bind ('click.admin', function() {
		sQ = $ (this).attr ('data-question-title') ? $ (this).attr ('data-question-title') : 'Ok?';
		if (!confirm (sQ)) return false;
	});

	/**
	 * Activity
	 */
	/*
		не нужна, в админке своя активность
	 */
	//ls.stream.init();

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
});