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

ls.admin_edit_user_rating = (function($) {
	
	this.selectors = {
		edit_rating_form_id: '#admin_editrating'
	};
	
	// ---

	return this;
	
}).call(ls.admin_edit_user_rating || {}, jQuery);

// ---

jQuery(document).ready(function($) {

	$ (ls.admin_edit_user_rating.selectors.edit_rating_form_id).ajaxForm({
		dataType: 'json',
		beforeSend: function() {},
		success: function(data) {
			if (data.bStateError) {
				ls.msg.error(data.sMsgTitle, data.sMsg);
			} else {
				ls.msg.notice('Ok');
			}
		},
		complete: function(xhr) {
			//window.location.reload(true);
		}
	});

});
