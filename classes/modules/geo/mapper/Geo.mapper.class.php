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
 * Расширение возможностей модуля для гео-локации
 *
 */

class PluginAdmin_ModuleGeo_MapperGeo extends PluginAdmin_Inherits_ModuleGeo_MapperGeo
{


    /**
     * Получить страны по массиву переданных имен
     *
     * @param $aFilter        фильтр
     * @return mixed
     */
    public function GetCountriesByArrayFilter($aFilter)
    {
        /*
         * разрешенные ключи условий фильтра
         */
        $aAllowedFilterKeys = array('id', 'name_ru', 'name_en', 'code');
        /*
         * проверить условия фильтра
         */
        $aFilter = $this->CheckArrayFilter($aFilter, $aAllowedFilterKeys);

        $sSql = 'SELECT *
			FROM
				?#
			WHERE
				1 = 1
				{ AND id IN (?a) }
				{ AND name_ru IN (?a) }
				{ AND name_en IN (?a) }
				{ AND code IN (?a) }
			ORDER BY
				FIELD
				(
					{id, ?a}
					{name_ru, ?a}
					{name_en, ?a}
					{code, ?a}
				)
			LIMIT
				?d, ?d
		';
        /*
         * проверить есть ли данные для запроса т.к. сортировка идет по значению поля, а дбсимпл пропускает пустые массивы
         */
        if ($this->CheckArrayFilterDataExists($aFilter, $aAllowedFilterKeys) and $aData = $this->oDb->select($sSql,
                Config::Get('db.table.geo_country'),
                /*
                 * поле для поиска
                 */
                isset($aFilter['id']) ? $aFilter['id'] : DBSIMPLE_SKIP,
                isset($aFilter['name_ru']) ? $aFilter['name_ru'] : DBSIMPLE_SKIP,
                isset($aFilter['name_en']) ? $aFilter['name_en'] : DBSIMPLE_SKIP,
                isset($aFilter['code']) ? $aFilter['code'] : DBSIMPLE_SKIP,
                /*
                 * сортировка по значениям поля поиска
                 */
                isset($aFilter['id']) ? $aFilter['id'] : DBSIMPLE_SKIP,
                isset($aFilter['name_ru']) ? $aFilter['name_ru'] : DBSIMPLE_SKIP,
                isset($aFilter['name_en']) ? $aFilter['name_en'] : DBSIMPLE_SKIP,
                isset($aFilter['code']) ? $aFilter['code'] : DBSIMPLE_SKIP,
                /*
                 * страница
                 */
                ($aFilter['page'] - 1) * $aFilter['per_page'],
                $aFilter['per_page']
            )
        ) {
            return Engine::GetEntityItems('Geo_Country', $aData);
        }
        return array();
    }


    /**
     * Получить города по массиву переданных имен
     *
     * @param $aFilter        фильтр
     * @return mixed
     */
    public function GetCitiesByArrayFilter($aFilter)
    {
        /*
         * разрешенные ключи условий фильтра
         */
        $aAllowedFilterKeys = array('id', 'name_ru', 'name_en', 'country_id', 'region_id');
        /*
         * проверить условия фильтра
         */
        $aFilter = $this->CheckArrayFilter($aFilter, $aAllowedFilterKeys);

        $sSql = 'SELECT *
			FROM
				?#
			WHERE
				1 = 1
				{ AND id IN (?a) }
				{ AND name_ru IN (?a) }
				{ AND name_en IN (?a) }
				{ AND country_id IN (?a) }
				{ AND region_id IN (?a) }
			ORDER BY
				FIELD
				(
					{id, ?a}
					{name_ru, ?a}
					{name_en, ?a}
					{country_id, ?a}
					{region_id, ?a}
				)
			LIMIT
				?d, ?d
		';
        /*
         * проверить есть ли данные для запроса т.к. сортировка идет по значению поля, а дбсимпл пропускает пустые массивы
         */
        if ($this->CheckArrayFilterDataExists($aFilter, $aAllowedFilterKeys) and $aData = $this->oDb->select($sSql,
                Config::Get('db.table.geo_city'),
                /*
                 * поле для поиска
                 */
                isset($aFilter['id']) ? $aFilter['id'] : DBSIMPLE_SKIP,
                isset($aFilter['name_ru']) ? $aFilter['name_ru'] : DBSIMPLE_SKIP,
                isset($aFilter['name_en']) ? $aFilter['name_en'] : DBSIMPLE_SKIP,
                isset($aFilter['country_id']) ? $aFilter['country_id'] : DBSIMPLE_SKIP,
                isset($aFilter['region_id']) ? $aFilter['region_id'] : DBSIMPLE_SKIP,
                /*
                 * сортировка по значениям поля поиска
                 */
                isset($aFilter['id']) ? $aFilter['id'] : DBSIMPLE_SKIP,
                isset($aFilter['name_ru']) ? $aFilter['name_ru'] : DBSIMPLE_SKIP,
                isset($aFilter['name_en']) ? $aFilter['name_en'] : DBSIMPLE_SKIP,
                isset($aFilter['country_id']) ? $aFilter['country_id'] : DBSIMPLE_SKIP,
                isset($aFilter['region_id']) ? $aFilter['region_id'] : DBSIMPLE_SKIP,
                /*
                 * страница
                 */
                ($aFilter['page'] - 1) * $aFilter['per_page'],
                $aFilter['per_page']
            )
        ) {
            return Engine::GetEntityItems('Geo_City', $aData);
        }
        return array();
    }


    /*
     *
     * --- Хелперы ---
     *
     */

    /**
     * Вернуть проверенный фильтр чтобы значения условий всегда были массивом
     *
     * @param $aFilter                фильтр
     * @param $aAllowedFilter        разрешенные ключи условий фильтра для проверки
     * @return mixed                проверенный фильтр
     */
    protected function CheckArrayFilter($aFilter, $aAllowedFilter)
    {
        foreach ($aFilter as $sKey => &$mValue) {
            /*
             * все параметры должны быть массивом
             */
            if (in_array($sKey, $aAllowedFilter) and !is_array($mValue)) {
                $mValue = (array)$mValue;
            }
        }
        /*
         * должна быть задана страница
         */
        if (!isset($aFilter['page'])) {
            $aFilter['page'] = 1;
        }
        /*
         * должно быть задано количество элементов на страницу
         */
        if (!isset($aFilter['per_page'])) {
            $aFilter['per_page'] = PHP_INT_MAX;
        }
        return $aFilter;
    }


    /**
     * Есть ли данные для запроса
     *
     * @param $aFilter                фильтр
     * @param $aAllowedFilter        разрешенные ключи условий фильтра для проверки
     * @return bool
     */
    protected function CheckArrayFilterDataExists($aFilter, $aAllowedFilter)
    {
        foreach ($aFilter as $sKey => $mValue) {
            /*
             * есть ли значения для запроса
             */
            if (in_array($sKey, $aAllowedFilter) and !empty($mValue)) {
                return true;
            }
        }
        return false;
    }


}

?>