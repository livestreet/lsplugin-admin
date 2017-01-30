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
 	Работа с элементами массива особого вида отображения
 */

var ls = ls || {};

ls.admin_settings_array = (function($) {

	/**
	 * Селекторы
	 */
	this.selectors = {
		HiddenArrayItemCopy: '.js-hidden-array-item-copy',
		ArrayItemValue: '.js-array-item-value',
		ArrayValues: '.js-array-values',
		ArrayEnum: '.js-array-enum',
		ArrayInputText: '.js-array-input-text',
		ArrayInputType: '.js-array-input-type'
	};


	this.init = function(selector, options) {
		this._element = $(selector);

		/**
		 * Удалить элемент из массива специального вида отображения
		 */
		this._element.on('click.admin', '.js-array-item-remove', function(event) {
			this.RemoveArrayItem(event.target);
		}.bind(this));

		/**
		 * Добавить элемент в массив специального вида отображения
		 */
		this._element.on('click.admin', '.js-array-add-value', function(event) {
			this.AddArrayItem(event.target);
		}.bind(this));
	};


	/**
	 * Удалить значение массива
	 *
	 * @param oThis
	 * @constructor
	 */
	this.RemoveArrayItem = function(oThis) {
		var oArrayItemValue = $ (oThis).closest(this.selectors.ArrayItemValue);

		var sKey = oArrayItemValue.closest(this.selectors.ArrayValues).attr('data-key');
		var sValue = oArrayItemValue.find('input').val();
		this.GetEnumSelector(sKey).find('option[value=' + sValue + ']').removeAttr('disabled');

		oArrayItemValue.fadeOut(200, function() {
			$ (this).remove();
		});
	};


	/**
	 * Получить правило для отбора по ключу
	 *
	 * @param sKey
	 * @returns {string}
	 * @constructor
	 */
	this.GetDataKeySelectorRule = function(sKey) {
		return '[data-key="' + sKey + '"]';
	};


	/**
	 * Получить копию структуры одного элемента массива
	 *
	 * @param sKey
	 * @constructor
	 */
	this.GetArrayItemBaseStructure = function(sKey) {
		return $ (this.selectors.HiddenArrayItemCopy + this.GetDataKeySelectorRule(sKey)).children().clone();
	};


	/**
	 * Получить данные селекта с разрешенными значениями
	 *
	 * @param sKey
	 * @constructor
	 */
	this.GetEnumSelector = function(sKey) {
		return $ (this.selectors.ArrayEnum + this.GetDataKeySelectorRule(sKey));
	};


	/**
	 * Установить утрибут name для инпута из его сохраненного значения
	 *
	 * @param oInput	инпут
	 * @constructor
	 */
	this.SwitchOriginalNameToInput = function(oInput) {
		return oInput.attr('name', oInput.attr('data-name-original'));
	};


	/**
	 * Добавить значение массива из перечисления (селекта)
	 *
	 * @param sKey
	 * @returns {boolean}
	 * @constructor
	 */
	this.AddArrayItemFromEnum = function(sKey) {
		var oSelectInput = this.GetEnumSelector(sKey);
		var sValue = oSelectInput.val();
		if (!sValue) return false;
		oSelectInput.find('option[value=' + sValue + ']').attr('disabled', true);
		
		var oNewItem = this.GetArrayItemBaseStructure(sKey);
		this.SwitchOriginalNameToInput(oNewItem.find('input')).val(sValue);
		
		$ (this.selectors.ArrayValues + this.GetDataKeySelectorRule(sKey)).append(oNewItem);
		return true;
	};


	/**
	 * Добавить значение массива из инпута (введенное пользователем)
	 *
	 * @param sKey
	 * @returns {boolean}
	 * @constructor
	 */
	this.AddArrayItemFromTextInput = function(sKey) {
		var oTextInput = $ (this.selectors.ArrayInputText + this.GetDataKeySelectorRule(sKey));
		var sValue = oTextInput.val();
		if (!sValue) return false;
		oTextInput.val('');
		
		var oNewItem = this.GetArrayItemBaseStructure(sKey);
		this.SwitchOriginalNameToInput(oNewItem.find('input')).val(sValue);
		
		$ (this.selectors.ArrayValues + this.GetDataKeySelectorRule(sKey)).append(oNewItem);
		return true;
	};


	/**
	 * Получить тип ввода для массива
	 *
	 * @param sKey
	 * @returns {*}
	 * @constructor
	 */
	this.GetArrayInputType = function(sKey) {
		return $ (this.selectors.ArrayInputType + this.GetDataKeySelectorRule(sKey)).val();
	};


	/**
	 * Добавить значение в массив
	 *
	 * @param oThis
	 * @returns {*}
	 * @constructor
	 */
	this.AddArrayItem = function(oThis) {
		var bResult = false;
		var sKey = $ (oThis).attr('data-key');
		switch(this.GetArrayInputType(sKey)) {
			case 'enum':
				bResult = this.AddArrayItemFromEnum(sKey);
				break;
			case 'text-field':
				bResult = this.AddArrayItemFromTextInput(sKey);
				break;
			default:
				ls.msg.error('Error', 'Undefined array items type');
		}
		return bResult;
	};
	
	// ---

	return this;
	
}).call(ls.admin_settings_array || {}, jQuery);

// ---

jQuery(document).ready(function($) {
	ls.admin_settings_array.init('.js-admin-settings-array-default');
});
