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

/*
 * Правила конвертации IP адресов
 *
 * Есть сложности с ipv6 и его конвертацией, особенно если php собран без его поддержки,
 * поэтому чтобы не менять код в нескольких местах при его будущем внедрении, конвертация айпишников будет здесь
 *
 */

/**
 * Конвертирует читаемый IP адрес в упакованное представление
 *
 * @param $sIp            Читаемый IPv4 или IPv6 адрес (пока не доступно)
 * @return string
 */
function convert_ip2long($sIp)
{
    //return inet_pton($sIp);		// todo: возвращает бинарную строку, не работает на Вин платформах до пхп 5.3.0
    return ip2long($sIp);
}

/**
 * Конвертирует упакованный интернет адрес в читаемый формат
 *
 * @param $iLong 32-битный IPv4, или 128-битный IPv6 адрес (пока не доступно)
 * @return string
 */
function convert_long2ip($iLong)
{
    //return inet_ntop($iLong);
    return long2ip($iLong);
}

?>