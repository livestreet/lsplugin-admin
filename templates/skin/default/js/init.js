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
 * @author PSNet <light.feel@gmail.com>
 *
 */

jQuery(document).ready(function($) {

	/**
	 * Popovers
	 */
	$(document).popover({ selector: '.js-popover-default' });


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
	$('.js-dropdown-default').dropdown();


	/**
	 * Tooltips
	 */
	$(document).tooltip({
		selector: '.js-tooltip'
	});


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
});