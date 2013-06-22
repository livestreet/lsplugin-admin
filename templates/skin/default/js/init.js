jQuery(document).ready(function($){

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
});