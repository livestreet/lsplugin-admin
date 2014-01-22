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
	Редактирование полей пользователя в его профиле в инлайн режиме
 */

var ls = ls || {};

ls.admin_profile_edit = (function($) {

	/**
	 * Селекторы
	 */
	this.selectors = {
		/*
			селектор элементов, которые можно редактировать как текст
		 */
		editable_elements: '.js-profile-inline-edit-input',


		/*
			для удобства (последняя запятая отсутствует)
		 */
		last_element: 'without_comma'
	};


	/**
	 * Data атрибуты редактируемого элемента, которые указывают на владельца (ид и тип данных)
	 */
	this.data_attr = {
		item_type: 'data-item-type',
		item_id: 'data-item-id',


		/*
		 	для удобства (последняя запятая отсутствует)
		 */
		last_element: 'without_comma'
	};


	/**
	 * Разбирает ответ сохранения данных от сервера
	 *
	 * @param data
	 * @return {*}
	 * @constructor
	 */
	this.SaveDataAnswerHandler = function(data) {
		if (data.bStateError) {
			ls.msg.error(data.sTitle, data.sMsg);
		} else {
			ls.msg.notice(data.sTitle, data.sMsg);
		}
		/*
			все равно вернуть редактируемое значение, чтобы можно было исправить его и отправить снова
		 */
		if (data.aData) {
			return data.aData;
		}
		return false;
	};


	/**
	 * Хендлер изменения значения и отправки нового значения на сервер
	 *
	 * @param value		новое значение
	 * @param settings	настройки jeditable
	 * @returns {*}		новое значение
	 * @constructor
	 */
	this.PerformServerSaveRequest = function(value, settings) {
		var aData = value;
		ls.ajax.load(
			aRouter['admin'] + 'users/ajax-profile-edit',
			{
				field_type: $ (this).attr(ls.admin_profile_edit.data_attr.item_type),
				user_id: $ (this).attr(ls.admin_profile_edit.data_attr.item_id),
				value: value
			},
			function(data) {
				aData = ls.admin_profile_edit.SaveDataAnswerHandler(data);
			},
			/*
			 	дополнительные параметры для $.ajax
			 */
			{
				/*
				 	важно - отключить асинхронную загрузку т.к. нужно ждать ответа чтобы вернуть данные
				 */
				async : false
			}
		);
		return aData;
	};

	// ---

	return this;
	
}).call(ls.admin_profile_edit || {}, jQuery);

// ---

jQuery(document).ready(function($) {

	/*
		инлайн редактирование полей в профиле пользователя
	 */
	// docs: http://www.appelsiini.net/projects/jeditable
	$ (ls.admin_profile_edit.selectors.editable_elements).editable(
		/*
			хендлер изменения значения
		 */
		ls.admin_profile_edit.PerformServerSaveRequest,
		/*
			настройки
		 */
		{
			/*
				тип поля для редактирования
			 */
			type: 'text',

			indicator: 'Сохранение...',				// todo: add langs
			tooltip: 'Нажмите для редактирования',
			placeholder: 'Редактировать',

			style: 'inherit'
		}
	);

});
