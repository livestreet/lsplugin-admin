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


/*
 * todo: пересмотреть на свежую голову
 */

/**
 * Фильтр для построения строки запроса с автоматическим достроением части запроса из реквеста
 *
 *
 * Пример со всеми параметрами:
 *
 *	{request_filter name=array('order', 'way') value=array('login', 'desc') with=array('q', 'field') prefix="?" separator="&"}
 *
 * возвратит строку:
 *
 * 	?order=login&way=desc&q=значение_q_из_реквеста&field=значение_field_из_реквеста
 *
 *
 * @param $aParams		параметры
 * @param $oSmarty		объект смарти
 * @return string		строка запроса
 */
function smarty_function_request_filter($aParams, &$oSmarty) {
	$aRequest = $_REQUEST;
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
				$aRequest[$sVal] = $aParams['value'][$iKey];
			}

		} else {
			/*
			 * удалить значения из реквеста по имени ключей
			 */
			foreach ($aParams['name'] as $iKey => $sVal) {
				unset($aRequest[$aParams['name'][$iKey]]);
			}
		}
	}

	/*
	 * что выбирать из реквеста (имена ключей заданные + связанные)
	 */
	$aAllowFromKeys = isset($aParams['name']) ? $aParams['name'] : array();
	$aAllowFromWith = isset($aParams['with']) ? $aParams['with'] : array();
	$aAllow = array_merge($aAllowFromKeys, $aAllowFromWith);

	$aResult = array_intersect_key($aRequest, array_flip($aAllow));

	/*
	 * для построения запроса
	 */
	$sPrefix = isset($aParams['prefix']) ? $aParams['prefix'] : '?';
	$sSeparator = isset($aParams['separator']) ? $aParams['separator'] : '&';

	$sResult = http_build_query($aResult, '', $sSeparator);
	return $sResult ? $sPrefix . $sResult : '';
}

?>