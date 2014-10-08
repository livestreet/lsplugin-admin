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
 * --- Языковые настройки ---
 *
 */

$config = array();

/*
 * Маппинг нового формата записи языка сайта на старый формат
 * Используется для корректного чтения данных xml файлов плагинов и шаблонов
 */
$config['lang']['i18n_mapping'] = array(
    /*
     * новый формат записи => старый
     */
    'ru' => 'russian',
    'ua' => 'ukrainian',
    'en' => 'english',
    'de' => 'deutsch',
);

return $config;

?>