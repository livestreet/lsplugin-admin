/*
	admin plugin
	(P) PSNet, 2008 - 2013
	http://psnet.lookformp3.net/
	http://livestreet.ru/profile/PSNet/
	https://catalog.livestreetcms.com/profile/PSNet/
	http://livestreetguide.com/developer/PSNet/
*/

var ls = ls || {};

ls.admin = (function ($) {

	this.newFunction = function () {

	};
	
	// ---

	return this;
	
}).call (ls.admin || {}, jQuery);

// ---

jQuery (document).ready (function ($) {

	//
	// Question popup
	//
	$ ('div.admin .question').bind ('click.admin', function () {
		$sQ = $ (this).attr ('data-question-title') ? $ (this).attr ('data-question-title') : 'Ok?';
		if (!confirm ($sQ)) return false;
	});

});
