<?php 

if(!function_exists('smarty_modifier_str_sprintf')){
	function smarty_modifier_str_sprintf()
	{
		$args = func_get_args();
		return call_user_func_array('sprintf', $args);
	}
}

?>