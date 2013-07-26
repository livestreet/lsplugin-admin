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
 * @author PSNet <light.feel@gmail.com>
 * 
 */

/*
 *	Работа с элементами массива особого вида отображения
 *
*/

var ls = ls || {};

ls.admin_array = (function ($) {
	
	this.selectors = {
		HiddenArrayItemCopy: '.js-hidden-array-item-copy',
		ArrayItemValue: '.js-array-item-value',
		ArrayValues: '.js-array-values',
		ArrayEnum: '.js-array-enum',
		ArrayInputText: '.js-array-input-text',
		ArrayInputType: '.js-array-input-type'
	};
	
	// ---

	this.RemoveArrayItem = function (oThis) {
		oArrayItemValue = $ (oThis).closest (this.selectors.ArrayItemValue);
		
		sKey = oArrayItemValue.closest (this.selectors.ArrayValues).attr ('data-key');
		sValue = oArrayItemValue.find ('input').val ();
		this.GetEnumSelector (sKey).find ('option[value=' + sValue + ']').removeAttr ('disabled');
		
		oArrayItemValue.fadeOut (200, function () {
			$ (this).remove ();
		});
	};
	
	// ---
	
	this.GetArrayItemBaseStructure = function () {
		return $ (this.selectors.HiddenArrayItemCopy).children ().clone ();
	};
	
	// ---
	
	this.GetEnumSelector = function (sKey) {
		return $ (this.selectors.ArrayEnum + '[data-key="' + sKey + '"]');
	};
	
	// ---
	
	this.SwitchOriginalNameToInput = function (oInput) {
		return oInput.attr ('name', oInput.attr ('data-name-original'));
	};
	
	// ---
	
	this.AddArrayItemFromEnum = function (sKey) {
		oSelectInput = this.GetEnumSelector (sKey);
		if (!(sValue = oSelectInput.val ())) return false;
		oSelectInput.find ('option[value=' + sValue + ']').attr ('disabled', true);
		
		oNewItem = this.GetArrayItemBaseStructure ();
		this.SwitchOriginalNameToInput (oNewItem.find ('input')).val (sValue);
		
		$ (this.selectors.ArrayValues + '[data-key="' + sKey + '"]').append (oNewItem);
		return true;
	};
	
	// ---
	
	this.AddArrayItemFromTextInput = function (sKey) {
		oTextInput = $ (this.selectors.ArrayInputText + '[data-key="' + sKey + '"]');
		if (!(sValue = oTextInput.val ())) return false;
		oTextInput.val ('');
		
		oNewItem = this.GetArrayItemBaseStructure ();
		this.SwitchOriginalNameToInput (oNewItem.find ('input')).val (sValue);
		
		$ (this.selectors.ArrayValues + '[data-key="' + sKey + '"]').append (oNewItem);
		return true;
	};
	
	// ---
	
	this.GetArrayInputType = function (sKey) {
		return $ (this.selectors.ArrayInputType + '[data-key="' + sKey + '"]').val ();
	};
	
	// ---
	
	this.AddArrayItem = function (oThis) {
		bResult = false;
		sKey = $ (oThis).attr ('data-key');
		switch (this.GetArrayInputType (sKey)) {
			case 'enum':
				bResult = this.AddArrayItemFromEnum (sKey);
				break;
			case 'text-field':
				bResult = this.AddArrayItemFromTextInput (sKey);
				break;
			default:
				ls.msg.error ('Error', 'Undefined array items type');
		}
		return bResult;
	};
	
	// ---

	return this;
	
}).call (ls.admin_array || {}, jQuery);

// ---

jQuery (document).ready (function ($) {
	
	//
	// Remove elements from array special list
	//
	$ (document).on ('click.admin', '.js-array-values .js-array-item-value .js-remove-previous', function () {
		ls.admin_array.RemoveArrayItem (this);
		ls.msg.error ('Ok', 'Deleted');
	});
	
	//
	// Add elements to array special list
	//
	$ (document).on ('click.admin', '.OneParameterContainer .js-array-add-value', function () {
		if (ls.admin_array.AddArrayItem (this)) {
			ls.msg.notice ('Ok', 'Added');
		}
		return false;
	});

});
