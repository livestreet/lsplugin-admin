<?php
/*-------------------------------------------------------
*
*   LiveStreet Engine Social Networking
*   Copyright © 2008 Mzhelskiy Maxim
*
*--------------------------------------------------------
*
*   Official site: www.livestreet.ru
*   Contact e-mail: rus.engine@gmail.com
*
*   GNU General Public License, version 2:
*   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*/

//
// Базовые настройки, которые не меняются через интерфейс
//

$config['user']['per_page'] = 3;

/*
	роутер
*/
$config['$root$']['router']['page']['admin'] = 'PluginAdmin_ActionAdmin';

return $config;

?>