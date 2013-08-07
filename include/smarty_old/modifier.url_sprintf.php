<?php 

if (!function_exists('smarty_modifier_url_sprintf')){
	function smarty_modifier_url_sprintf()
	{
		$args = func_get_args();
		for($i=1; $i<count($args); $i++){
			$args[$i] = rawurlencode($args[$i]);
		}
		return call_user_func_array('sprintf', $args);
	}
}

?>