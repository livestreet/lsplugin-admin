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
	Обработка жалоб на пользователей
 */

var ls = ls || {};

ls.admin_users_complaints = (function($) {

	/**
	 * Селекторы
	 */
	this.selectors = {
		/*
			кнопка отправки ответа на жалобу
		 */
		answer_button_class: '.js-admin-user-complaint-send-answer',

		/*
			для удобства (последняя запятая отсутствует)
		 */
		last_element: 'without_comma'
	};


	/**
	 * Установить слушатель отправки ответа на жалобу
	 *
	 * @constructor
	 */
	this.AssignListenerForSubmitAnswer = function() {
		$ (document).on('click.admin', this.selectors.answer_button_class, function() {
			var sFormId = $ (this).attr('data-user-complaint-form-id');
			var sModalId = $ (this).attr('data-user-complaint-modal-id');
			ls.ajax.submit(aRouter['admin'] + 'users/complaints/ajax-modal-view/', sFormId, function(result) {
				$ (sModalId).modal('hide');
			});
		});
	};

	// ---

	return this;
	
}).call(ls.admin_users_complaints || {}, jQuery);

// ---

jQuery(document).ready(function($) {

	/*
	 	установить слушатель отправки ответа на жалобу
	 */
	ls.admin_users_complaints.AssignListenerForSubmitAnswer();

});
