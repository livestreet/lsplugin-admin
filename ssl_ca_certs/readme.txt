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

Эта сборка основных центров сертификатов нужна для проверки сертификата каталога.

--- Детали ---

При попытке связи по HTTPS (SSL или TLS) через CURL можно получить ошибку:

SSL certificate problem, verify that the CA cert is OK. Details: error:14090086:SSL routines:SSL3_GET_SERVER_CERTIFICATE:certificate verify failed

Это связано с тем, что курл по-умолчанию не настроен доверять любым центрам сертификации (CA) и, как следствие, сертификату HTTPS сервера. При использовании браузера нет таких проблем т.к. разработчики браузеров включили список основных центров сертификации, которым можно доверять и которые подтверждают большинство сертификатов сайтов, администраторы которых купили сертификаты у этих же центров сертификации (CA).

Поэтому данный сертификат используется курлом как доверенный и с помощью его курл будет проверять сертификаты других сайтов, в данном случае - каталога.

Эта сборка центров корневых сертификатов (cA) типа X.509 взята с открытого источника - mozilla.org, которая распространяется вместе с библиотекой CURL по адресу:

http://curl.haxx.se/docs/caextract.html
