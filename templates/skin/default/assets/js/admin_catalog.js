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

/*
	Работа с каталогом
 */

var ls = ls || {};

ls.admin_catalog = (function($) {
	
	this.selectors = {
		/*
			кнопка показа справки по каталогу
		 */
		tip_toggle_button: '.js-catalog-toggle-tip-button',
		tip_message: '.js-catalog-tip-message',

		/*
			для удобства (последняя запятая отсутствует)
		 */
		last_element: 'without_comma'
	};

	// ---

	return this;
	
}).call(ls.admin_catalog || {}, jQuery);

// ---

jQuery(document).ready(function($) {

	/*
		показать/скрыть справку по каталогу
	 */
	$ (ls.admin_catalog.selectors.tip_toggle_button).click(function() {
		$ (ls.admin_catalog.selectors.tip_message).slideToggle(150);
		return false;
	});

});
