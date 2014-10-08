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
class PluginAdmin_ModuleDeletecontent_MapperDeletecontent extends Mapper
{

    /**
     * Удаление данных из БД по фильтру
     *
     * @param $aFilter        фильтр
     * @return array|null
     */
    public function DeleteContentByFilter($aFilter)
    {
        $sWhere = $this->BuildWhereQuery($aFilter[PluginAdmin_ModuleDeletecontent::FILTER_CONDITIONS]);
        $sSql = 'DELETE
			FROM
				`' . $aFilter[PluginAdmin_ModuleDeletecontent::FILTER_TABLE] . '`
			WHERE
				' . $sWhere . '
		';
        return $this->oDb->query($sSql);
    }


    /*
     * todo: использовать данный метод и в модуле статистики (и удалить оттуда ручное экранирование значений)
     * т.е. заменить данным методом аналогичный там и удалить один лишний
     * НЕ УДАЛЯТЬ ОТТУДА, пересмотреть нужен ли там массив т.к. данный метод его НЕ поддерживает
     *
     * + можно вообще вынести его в общий какой-то модуль чтобы не дублировать
     */
    /**
     * Построить условие WHERE sql-запроса
     *
     * @param $aConditions        массив условий
     * @return string            часть sql-строки
     */
    protected function BuildWhereQuery($aConditions)
    {
        $sSql = '1 = 1';
        foreach ($aConditions as $sField => $mValue) {
            /*
             * экранировать поле таблицы как идентификатор и значение в зависимости от типа
             */
            $sSql .= ' AND ' . $this->oDb->escape($sField, true) . ' = ' . $this->oDb->escape($mValue);
        }
        return $sSql;
    }


    /**
     * Установить флаг проверки внешних связей (для таблиц типа InnoDB).
     * Данное изменение действует в пределах сессии подключения к БД.
     * После того как соединение с БД закроется, в новой сессии будет установлено значение по-умолчанию
     *
     * @param $iValue        значение флага
     * @return array|null
     */
    public function SetForeignKeysChecking($iValue)
    {
        $sSql = 'SET foreign_key_checks = ?d';
        return $this->oDb->query($sSql, $iValue);
    }


    /**
     * Удаляет комментарии у которых указаны несуществующие родительские ид комментариев в comment_pid
     *
     * @return int        количество удаленных комментариев
     */
    public function DeleteCommentsWithBrokenParentLinks()
    {
        /*
         * в данном запросе специально создается подзапрос чтобы создать временную таблицу
         * т.к. в противном случае можно получить ошибку 1093 "You can't specify target table 'prefix_comment' for update in FROM clause"
         */
        $sSql = 'DELETE
			FROM
				`' . Config::Get('db.table.comment') . '`
			WHERE
				`comment_pid` IS NOT NULL
				AND
				`comment_pid` NOT IN (
					SELECT `comment_id`
					FROM (
						SELECT `comment_id`
						FROM
							`' . Config::Get('db.table.comment') . '`
					) as tmptable
				)
		';
        return (int)$this->oDb->query($sSql);
    }


    /**
     * Удаление данных, ссылающихся на несуществующие данные из другой таблицы, по фильтру
     *
     * @param $aFilter        фильтр
     * @return array|null
     */
    public function DeleteReferencesToOtherTableRecordsNotExists($aFilter)
    {
        $sWhere = $this->BuildWhereQuery($aFilter[PluginAdmin_ModuleDeletecontent::FILTER_CONDITIONS]);
        $sSql = 'DELETE
			FROM
				`' . $aFilter[PluginAdmin_ModuleDeletecontent::FILTER_TABLE] . '`
			WHERE
				' . $sWhere . '
				AND
				`' . $aFilter[PluginAdmin_ModuleDeletecontent::FILTER_CONNECTED_FIELD] . '` NOT IN (
					SELECT `' . $aFilter[PluginAdmin_ModuleDeletecontent::FILTER_SUBQUERY_FIELD] . '`
					FROM
						`' . $aFilter[PluginAdmin_ModuleDeletecontent::FILTER_SUBQUERY_TABLE] . '`
				)
		';
        return $this->oDb->query($sSql);
    }


}

?>