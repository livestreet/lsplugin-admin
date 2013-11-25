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
			селектор элементов, которые можно редактировать
		 */
		editable_elements: '.profile-inline-edit-input',


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
	 * Разбирает ответ от сервера
	 *
	 * @param data
	 * @constructor
	 */
	this.AnswerHandler = function(data) {
		if (data.bStateError) {
			ls.msg.notice(data.sTitle, data.sMsg);
		} else {
			ls.msg.notice('Ok');
		}
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
		function(value, settings) {
			ls.ajax.load(
				aRouter['admin'] + 'users/ajax-profile-edit',
				{
					field_type: $ (this).attr(ls.admin_profile_edit.data_attr.item_type),
					user_id: $ (this).attr(ls.admin_profile_edit.data_attr.item_id),
					value: value
				},
				function(data) {
					ls.admin_profile_edit.AnswerHandler(data);
				}
			);
			return value;
		},
		/*
			настройки
		 */
		{
			/*
				для получения исходника редактируемого значения вместо хтмл данных
			 */
			//loadurl : 'http://www.example.com/load.php',
			//loaddata : function(value, settings) { return {foo: "bar"}; }
			/*
				при отправке данных добавить параметры
			 */
			//submitdata : function(value, settings) { return {foo: "bar"}; }

			/*
				тип поля для редактирования
			 */
			type: 'text',	// textarea, select

			/*
				тексты кнопок
			 */
			//cancel: 'Отмена',
			//submit: 'OK',

			indicator: 'Сохранение...',
			tooltip: 'Нажмите для редактирования',
			placeholder: 'Редактировать',

			//cssclass: 'someclass'
			style: 'inherit'
		}
	);

});
