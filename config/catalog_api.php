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
 * --- Описание АПИ официального каталога плагинов для LiveStreet CMS ---
 *
 */

$config = array();

/*
 * Базовый путь к АПИ каталога
 */
$config['catalog']['api']['base_url'] = 'https://catalog.livestreetcms.com/api/';

/*
 * Методы для работы с каталогом
 * tip:
 * 		1. строка "{plugin_code}" - код плагина (имя папки плагина)
 * 		2. ключи в массивах нужны для формирования метода для доступа к АПИ каталога, в значениях указывается относительный урл
 */
$config['catalog']['api']['methods'] = array(
    /*
     * Группа: работа с одним плагином с указанием его кода
     */
    'plugin' => array(
        /*
         * относительный урл: получить лого плагина (180х180)
         */
        'logo' => 'plugin/{plugin_code}/get-logo/',
    ),
    /*
     * Группа: работа со списком плагинов
     */
    'addons' => array(
        /*
         * относительный урл: получить обновления списка плагинов
         */
        'check_version' => 'addons/check-version/',
        /*
         * относительный урл: получить список плагинов из каталога по фильтру
         */
        'filter'        => 'addons/filter/',
    ),
);

/*
 * Время кеширования запросов из каталога
 */
$config['catalog']['cache']['time'] = array(
    /*
     * получение обновлений (1 час)
     */
    'plugin_updates_check' => 60 * 30,
    /*
     * получение дополнений из каталога (1 час)
     */
    'catalog_addons_list'  => 60 * 60 * 1,
);

/*
 * Проверять наличие новых версий плагинов в каталоге
 */
$config['catalog']['updates']['allow_plugin_updates_checking'] = true;

/*
 * Добавить кнопку в тулбар с количеством обновлений плагинов
 */
$config['catalog']['updates']['show_updates_count_in_toolbar'] = true;

/*
 * макс. время подключения к серверу, сек
 */
$config['catalog']['timeouts']['max_connect_timeout'] = 2;
/*
 * макс. время получения данных от сервера, сек
 */
$config['catalog']['timeouts']['max_work_timeout'] = 4;

/*
 *
 * --- Для отображения дополнений из каталога ---
 *
 */

/*
 * типы плагинов
 */
$config['catalog']['remote']['addons']['type'] = array(
    /*
     * все
     */
    null,
    /*
     * платные
     */
    2,
    /*
     * бесплатные
     */
    1,
);

/*
 * типы сортировок
 */
$config['catalog']['remote']['addons']['sorting'] = array(
    'new',
    'review',
    'update',
    'download',
    'buy',
    'price'
);

/*
 * сортировка в каталоге по-умолчанию
 */
$config['catalog']['remote']['addons']['default_sorting'] = 'update';

/*
 * версии
 */
$config['catalog']['remote']['addons']['versions'] = array(
    /*
     * все
     */
    null,
    /*
     * 042
     */
    //3,
    /*
     * 051
     */
    //1,
    /*
     * 103
     */
    2,
    /*
     * 200
     */
    4
);

/*
 * секция
 */
$config['catalog']['remote']['addons']['sections'] = array(
    /* Все */
    null,
    /* SEO */
    3,
    /* Админка */
    14,
    /* Безопасность */
    18,
    /* Блоги */
    12,
    /* Блоки */
    2,
    /* Голосование */
    16,
    /* Интеграция */
    17,
    /* Комментарии */
    4,
    /* Коммерция */
    10,
    /* Медиа */
    9,
    /* Оформление */
    8,
    /* Пользователи */
    15,
    /* Разное */
    11,
    /* Разработка */
    1,
    /* Редактор */
    5,
    /* Рейтинг */
    7,
    /* Топики */
    6,
    /* Юзабилити */
    13,
);

return $config;

?>