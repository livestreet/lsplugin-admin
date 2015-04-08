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
 * Модуль сообщений, в зависимости от типа запроса (аякс или нет) добавляет сообщения об ошибках
 * Используется при получении данных формы настроек
 *
 */

class PluginAdmin_ModuleMessage extends PluginAdmin_Inherits_ModuleMessage
{

    /*
     * Список ошибок по полям настроек
     */
    private $aParamErrors = array();


    /**
     * Добавляет запись ошибки в массив
     *
     * @param $sMsg        текст ошибки
     * @param $sKey        ключ, у которого эта ошибка возникла
     */
    private function AddParamError($sMsg, $sKey)
    {
        $this->aParamErrors[] = array(
            'key' => $sKey,
            'msg' => $sMsg
        );
    }


    /**
     * Добавить показ ошибки
     * В зависимости от запроса (обычный или через аякс) будет использован стандартный метод для вывода ошибок или специальный
     *
     * @param $sMsg        текст ошибки
     * @param $sKey        ключ, у которого эта ошибка возникла
     */
    public function AddOneParamError($sMsg, $sKey)
    {
        if (isAjaxRequest()) {
            /*
             * добавить ошибку в специальный список
             */
            $this->AddParamError($sMsg, $sKey);
        } else {
            $this->AddError($sMsg, $this->Lang_Get('common.error.error'), true);
        }
    }


    /**
     * Получить список всех ошибок для вывода их через аякс
     *
     * @return array
     */
    public function GetParamsErrors()
    {
        return $this->aParamErrors;
    }


    /*
     *
     * --- Дополнение к стандартным методам ---
     *
     */

    /**
     * Добавить сообщение об ошибке с проверкой текста на уникальность и пропустить в случае дубля
     *
     * @param      $sMsg            сообщение
     * @param null $sTitle заголовок
     * @param bool $bUseSession отложить в сессию
     * @return bool
     */
    public function AddErrorUnique($sMsg, $sTitle = null, $bUseSession = false)
    {
        return $this->AddMessageUnique('error', $sMsg, $sTitle, $bUseSession);
    }


    /**
     * Добавить уведомление с проверкой текста на уникальность и пропустить в случае дубля
     *
     * @param      $sMsg            сообщение
     * @param null $sTitle заголовок
     * @param bool $bUseSession отложить в сессию
     * @return bool
     */
    public function AddNoticeUnique($sMsg, $sTitle = null, $bUseSession = false)
    {
        return $this->AddMessageUnique('notice', $sMsg, $sTitle, $bUseSession);
    }


    /**
     * Добавить сообщение указанного типа с проверкой на уникальность
     *
     * @param $sType                тип
     * @param $sMsg                    сообщение
     * @param $sTitle                заголовок
     * @param $bUseSession            отложить в сессию
     * @return bool                    добавлено или нет
     */
    private function AddMessageUnique($sType, $sMsg, $sTitle, $bUseSession)
    {
        $sType = ucfirst(strtolower($sType));
        /*
         * получить имя массива, в котором искать
         */
        $sMessageArrayName = $bUseSession ? 'aMsg' . $sType . 'Session' : 'aMsg' . $sType;
        /*
         * искать в массиве
         */
        foreach ($this->{$sMessageArrayName} as $aMsgRecord) {
            /*
             * если такой текст уже есть - не добавлять
             */
            if ($sMsg == $aMsgRecord['msg']) {
                return false;
            }
        }
        $sMethodName = 'Add' . $sType;
        $this->{$sMethodName}($sMsg, $sTitle, $bUseSession);
        return true;
    }

}

?>