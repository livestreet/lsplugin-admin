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
			кнопка опций
		 */
		options_button: '#dropdown_admin_plugins_install_options_button',
		/*
		 	класс селекта для перехода по урлу в значении селекта
		 */
		url_to_go_in_select: '.js-admin-url-to-go-in-select',

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
	 	добавлять класс "нажатия" кнопке открывающей дропдаун опций
	 */
	$ (ls.admin_catalog.selectors.options_button).on('dropdownbeforeshow.admin, dropdownafterhide.admin', function() {
		$ (this).toggleClass('active');
	});

	/*
		переход по урлу из значения селекта
	 */
	$ (ls.admin_catalog.selectors.url_to_go_in_select).change(function() {
		window.location.href = $ (this).val();
	});

});
