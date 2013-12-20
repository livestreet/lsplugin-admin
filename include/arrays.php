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
 * @author Serge Pustovit (PSNet) <light.feel@gmail.com>
 *
 */


/**
 * Проверяет чтобы у массива были только строковые ключи (полностью ассоциативный массив)
 *
 * @param $aData		массив
 * @return bool
 */
function check_if_array_has_string_keys($aData) {
	foreach($aData as $mKey => $mVal) {
		if (!is_string($mKey)) return false;
	}
	return true;
}


/**
 * Объеденяет массивы, указанные в параметрах по особым правилам: ассоциативные массивы объеденяет, а массивы с числовыми ключами - заменяет
 * tip: этот метод - аналог func_array_merge_assoc, только более универсальный
 * 		(может принимать неограниченное количество массивов в качестве параметров и с более глубокой проверкой ключей массивов)
 *
 * @return array		результирующий массив
 */
function array_replace_recursive_distinct() {
	$aAllArrays = func_get_args();
	$aOriginal = array_shift($aAllArrays);

	foreach ($aAllArrays as $aCurrentArray) {
		foreach ($aCurrentArray as $mKey => $mValue) {
			if (is_array($mValue) and isset($aOriginal[$mKey]) and is_array($aOriginal[$mKey]) and check_if_array_has_string_keys($mValue)) {
				/*
				 * заменить или объеденить значения в оригинальном ассоциативном массиве
				 */
				$aOriginal[$mKey] = array_replace_recursive_distinct($aOriginal[$mKey], $aCurrentArray[$mKey]);
			} else {
				/*
				 * значение - не массив или ключи массива числовые (нужна замена, а не объеденение)
				 */
				$aOriginal[$mKey] = $mValue;
			}
		}
	}
	return $aOriginal;
}

?>