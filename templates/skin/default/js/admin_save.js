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

var ls = ls || {};

ls.admin_save = (function ($) {
	
	this.styleClass = {
		Error: 'admin-save-error-border',
		ErrorMsgContainer: 'admin-save-error-wrapper'
	};
	
	// ---
	
	this.selectors = {
		FormId: '#admin_save',
		OneParameterContainer: '.OneParameterContainer',
		OneParameterErrorWrapper: '.' + this.styleClass.ErrorMsgContainer
	};
	
	// ---

	this.ShowErrors = function (aParamErrors) {
		oThat = this;
		// show errors
		$ (aParamErrors).each (function (i, o) {
			oWrapper = oThat.GetOneParameterContainer (o.key);
			oWrapper.addClass (oThat.styleClass.Error);
			oWrapper.append (
				$ ('<div />', {
					class: oThat.styleClass.ErrorMsgContainer,
					html: o.msg
				})
			);
		});
		// scroll to first error
		this.ScrollToContainer (this.GetOneParameterContainer (aParamErrors [0].key));
	};
	
	// ---

	this.ScrollToContainer = function (oContainer) {
    iOffset = - parseInt (($ (window).height () - $ (oContainer).height ()) / 2);
		iOffset = iOffset ? iOffset : -230;
    
    var iTargetOffset = $ (oContainer).offset ().top + iOffset;
    $ ('html, body').animate ({
      'scrollTop': iTargetOffset
    }, 500);
	}
	
	// ---

	this.RemoveAllErrorMessages = function () {
		$ (this.selectors.FormId + ' ' + this.selectors.OneParameterContainer).removeClass (this.styleClass.Error);
		$ (this.selectors.FormId + ' ' + this.selectors.OneParameterErrorWrapper).remove ();
	}
	
	// ---
	
	this.GetOneParameterContainer = function (sKey) {
		return $ (this.selectors.FormId + ' input[value="' + sKey + '"]').closest (this.selectors.OneParameterContainer);
	}
	
	// ---

	return this;
	
}).call (ls.admin_save || {}, jQuery);

// ---

jQuery (document).ready (function ($) {

  if (ls.registry.get ('admin_save_form_ajax_use')) {
  
    $ ('#admin_save').ajaxForm ({
      dataType: 'json',
      beforeSend: function () {
        ls.admin_save.RemoveAllErrorMessages ();
        // todo: add load indicator for submit button
        // disable submit button
      },
      success: function (data) {
        // process result
        if (data.bStateError) {
          ls.msg.error (data.sMsgTitle,data.sMsg);
        } else {
          if (data.aParamErrors.length > 0) {
            ls.admin_save.ShowErrors (data.aParamErrors);
            ls.msg.error ('', ls.lang.get ('plugin.admin.Errors.Some_Fields_Are_Incorrect'));
            return false;
          }
          ls.msg.notice ('Ok');
        }
      },
      complete: function (xhr) {
        // todo: remove load indicator for submit button
        // enable submit button
      }
    });
    
  }

});
