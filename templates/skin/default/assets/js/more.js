var ls = ls || {};
ls.admin_process =( function ($) {

	this.$process;
	this.stack={};

	this.start = function(name) {
		if (name) {
			if (this.stack[name]) {
				return false;
			}
			this.stack[name]=1;
		}
		this.$process.show();
		return true;
	};

	this.stop = function(name) {
		if (name && this.stack[name]) {
			delete this.stack[name];
		}
		this.$process.hide();
	};

	this.init = function() {
		this.$process=$('<div id="fsdfsfsfs" style="display: none;z-index: 9999; background-color: #C5C5C5;color: #FF0000;height: 100px;position: fixed;text-align: center;top: 0;width: 100%;"></div>');
		this.$process.append($('<div style="margin-top: 30px;font-size: 22px;"><img src="'+PATH_FRAMEWORK_FRONTEND+'/images/modal-loader.gif"> Идет обработка запроса...</div>'));
		this.$process.appendTo('body');
	};

	return this;
}).call(ls.admin_process || {},jQuery);
jQuery(document).ready(function($) {
	ls.admin_process.init();
});