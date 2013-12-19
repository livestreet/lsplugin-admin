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
 *
 * настройка банов
 *
 */

/*
 * количество банов на страницу
 */
$config['bans']['per_page'] = 10;

/*
 * Автоматически удалять старые записи банов если дата окончания бана уже прошла
 */
$config['auto_delete_old_ban_records'] = true;

/*
 * Собирать статистку по срабатываниям банов
 */
$config['gather_bans_running_stats'] = true;

return $config;

?>