<?php
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


/**
 * Фильтр для построения строки запроса с автоматическим достроением части запроса из переменной fillter[] реквеста
 *
 *
 * Пример со всеми параметрами:
 *
 *	{request_filter name=array('order', 'way') value=array('login', 'desc') prefix="?" separator="&"}
 *
 * возвратит строку:
 *
 * 	?fillter[order]=login&fillter[way]=desc&fillter[q]=значение_q_из_реквеста&fillter[field]=значение_field_из_реквеста
 *
 *
 * @param $aParams		параметры
 * @param $oSmarty		объект смарти
 * @return string		строка запроса
 */
function smarty_function_request_filter($aParams, &$oSmarty) {
	$aFilter = (array) @$_REQUEST['filter'];

	/*
	 * если указаны доп. ключи для реквеста
	 */
	if (isset($aParams['name'])) {
		/*
		 * список ключей должен быть массивом
		 */
		if (!is_array($aParams['name'])) {
			$aParams['name'] = (array) $aParams['name'];
		}

		/*
		 * если задана установка значений
		 */
		if (isset($aParams['value'])) {
			/*
			 * списки значений ключей должны быть массивом
			 */
			if (!is_array($aParams['value'])) {
				$aParams['value'] = (array) $aParams['value'];
			}
			/*
			 * установить все пары "ключ=значение" в реквесте
			 */
			foreach ($aParams['name'] as $iKey => $sVal) {
				$aFilter[$sVal] = $aParams['value'][$iKey];
			}

		} else {
			/*
			 * удалить значения из реквеста по имени ключей
			 */
			foreach ($aParams['name'] as $iKey => $sVal) {
				unset($aFilter[$aParams['name'][$iKey]]);
			}
		}
	}

	/*
	 * все значение хранятся в массиве filter реквеста
	 */
	$aResult = array('filter' => $aFilter);

	/*
	 * для построения запроса
	 */
	$sPrefix = isset($aParams['prefix']) ? $aParams['prefix'] : '?';
	$sSeparator = isset($aParams['separator']) ? $aParams['separator'] : '&';

	/*
	 * построить строку
	 */
	$sResult = http_build_query($aResult, '', $sSeparator);
	return $sResult ? $sPrefix . $sResult : '';
}

?>