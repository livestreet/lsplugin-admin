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
		editable_elements: '.profile-inline-edit-input',
		/*
			селектор элементов, которые нужно редактировать в выпадающем списке, предварительно получая от сервера
		 */
		editable_elements_select: '.profile-inline-edit-select',


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
	 * @constructor
	 */
	this.AnswerHandler = function(data) {
		if (data.bStateError) {
			ls.msg.notice(data.sTitle, data.sMsg);
		} else {
			ls.msg.notice('Ok');
		}
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
	};


	/**
	 * Получает данные для селекта от сервера
	 *
	 * @param value
	 * @param settings
	 * @returns {*}
	 * @constructor
	 */
	this.GetSelectDataFromServer = function(value, settings) {
		aData = false;
		ls.ajax.load(
			aRouter['admin'] + 'users/ajax-profile-get-data',
			{
				/*
				 	получить данные для типа
				 */
				type: $ (this).attr(ls.admin_profile_edit.data_attr.item_type),
				/*
					нужного пользователя
				 */
				user_id: $ (this).attr(ls.admin_profile_edit.data_attr.item_id)
			},
			function(data) {
				aData = ls.admin_profile_edit.GetDataHandler(data);
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


	/**
	 * Разбирает ответ получения данных от сервера
	 *
	 * @param data
	 * @returns {*}		новое значение
	 * @constructor
	 */
	this.GetDataHandler = function(data) {
		if (data.bStateError) {
			ls.msg.notice(data.sTitle, data.sMsg);
			return false;
		} else if (data.aData) {
			return data.aData;
		}
		return false;
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


	/*
	 	инлайн редактирование полей в профиле пользователя, которые требуют подгрузки данных для своих значений
	 	т.е. для селектов (пол, дата рождения и страны)
	 */
	// docs: http://www.appelsiini.net/projects/jeditable
	$ (ls.admin_profile_edit.selectors.editable_elements_select).editable(
		ls.admin_profile_edit.PerformServerSaveRequest,
		{
			/*
			 	для получения исходника редактируемого значения.
			 	можно использовать loadurl, а вместе с ним и loaddata, но те требуют в ответ строго json массив.
			 	ЛС не отдает такие данные по нормальному т.к. в ответе будут как минимум три ключа ассоциативного массива:
			 	флаг ошибки, текст ошибки и заголовок ошибки + ещё один ключ с нужными данными.
			 	Поэтому библиотека предоставляет возможность в виде метода получения данных, а в нем возврат данных в удобном для библиотеки виде
			 */
			data: ls.admin_profile_edit.GetSelectDataFromServer,
			/*
			 	выпадающий список
			 */
			type: 'select',
			/*
				для селекта кнопка нужна для подтверждения редактирования
			 */
			submit: 'OK',

			indicator: 'Сохранение...',
			tooltip: 'Нажмите для редактирования',
			placeholder: 'Редактировать',

			style: 'inherit'
		}
	);

});
