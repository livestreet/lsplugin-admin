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
			кнопка опций
		 */
		dropdown_admin_plugins_install_options_button: '#dropdown_admin_plugins_install_options_button',
		/*
			ид селекта сортировки
		 */
		admin_plugins_install_sorting: '#admin_plugins_install_sorting',
		/*
			ид селекта категории
		 */
		admin_plugins_install_category: '#admin_plugins_install_category',

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

	/*
	 	добавлять класс "нажатия" кнопке открывающей дропдаун опций
	 */
	$ (ls.admin_catalog.selectors.dropdown_admin_plugins_install_options_button).on('dropdownbeforeshow.admin, dropdownafterhide.admin', function() {
		$ (this).toggleClass('active');
	});

	/*
		изменеие сортировки
	 */
	$ (ls.admin_catalog.selectors.admin_plugins_install_sorting).change(function() {
		window.location.href = $ (this).val();
	});

	/*
	 	изменеие категории
	 */
	$ (ls.admin_catalog.selectors.admin_plugins_install_category).change(function() {
		window.location.href = $ (this).val();
	});

});
