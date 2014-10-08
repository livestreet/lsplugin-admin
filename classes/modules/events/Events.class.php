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
 *	Модуль подписки на уведомление о изменении параметров конфига.
 * 	Данный модуль предоставляет два метода событий:
 *
 *		1. вызов метода при изменении значения конкретного параметра (возможность проверить новое значение параметра ключа)
 * 		2. вызов метода при изменении хотя бы одного параметра конфига перед записью новых значений
 *
 *
 *	1.	Плагины, которые хотят получить уведомления о смене параметра их конфига, должны унаследовать этот модуль
 *	и добавить в него свой метод "PluginnameOnChange($sKey, $mNewValue, $mPreviousValue)"
 *	и возвращать true в случае успеха (разрешения на изменение параметра)
 *	или текст ошибки (тип string) в случае запрета для данного значения ключа.
 *
 *
 * 	2.	Плагины, которые хотят получить управление если хотя бы одно значение конфига было изменено (перед записью новых значений),
 * 	должны унаследовать данный модуль и добавить в него новый метод с именем "PluginnameSomethingChanged()"
 *	и возвращать true в случае успеха (сброса кеша и т.п.) или текст ошибки (тип string) в случае провала.
 *
 *
 * 	Информация:
 *
 *	Подписка может быть нужна, например, когда в админке изменили список размеров изображений и их нужно автоматически пересоздать.
 *	В таком случае плагин может подписаться на событие и его метод в наследуемом модуле будет вызван если один из его ключей изменился.
 *	Метод получит имя ключа в виде "ключ1.ключ2.ключ3"(как и в вызовах класса Config), новое и старое значение параметра.
 *	Метод обязательно должен вернуть true в случае успеха или текст ошибки (строку).
 *
 */

class PluginAdmin_ModuleEvents extends Module
{

    /*
     * часть названия метода для вызова события на изменение значения одного параметра
     */
    protected $sOnChangeFunctionPostfix = 'OnChange';

    /*
     * часть названия метода для вызовая события если хоть один параметр конфига был изменен
     */
    protected $sAtLeastOneParameterIsChangedPostfix = 'SomethingChanged';


    public function Init()
    {
    }


    /**
     * Проверяет наличие подписанных методов на изменение настроек, вызывает подписчиков
     *
     * @param $sConfigName            имя конфига
     * @param $sKey                    ключ
     * @param $mNewValue            новое значение ключа
     * @param $mPreviousValue        предыдущее значение ключа
     * @return bool|mixed            можно ли ключу принимать такое значение
     */
    final public function ConfigParameterChangeNotification($sConfigName, $sKey, $mNewValue, $mPreviousValue)
    {
        /*
         * получить имя метода, который должен проверить значение одного изменившегося параметра
         */
        $sMethodName = $this->GetOnChangeHandlerMethodName($sConfigName, $this->sOnChangeFunctionPostfix);
        if (method_exists($this, $sMethodName)) {
            return call_user_func(array($this, $sMethodName), $sKey, $mNewValue, $mPreviousValue);
        }
        return true;
    }


    /**
     * Возвращает имя метода подписки для плагина или ядра
     *
     * @param $sConfigName            имя конфига
     * @param $sMethodPostfix        постфикс для построения имени метода
     * @return string                полное имя метода
     */
    final protected function GetOnChangeHandlerMethodName($sConfigName, $sMethodPostfix)
    {
        if ($sConfigName != ModuleStorage::DEFAULT_KEY_NAME) {
            return ucfirst($sConfigName) . $sMethodPostfix;
        }
        /*
         * для ядра это будет просто постфикс (без имени перед ним)
         */
        return $sMethodPostfix;
    }


    /**
     * Проверяет есть ли методы, которые должны получить управление если хоть один параметр плагина был изменен
     *
     * @param $sConfigName            имя конфига
     * @return bool|mixed            разрешение на запись параметров
     */
    final public function ConfigParametersAreChangedNotification($sConfigName)
    {
        /*
         * получить имя метода, который должен выполнить действия если хоть один параметр конфига изменился
         */
        $sMethodName = $this->GetOnChangeHandlerMethodName($sConfigName, $this->sAtLeastOneParameterIsChangedPostfix);
        if (method_exists($this, $sMethodName)) {
            return call_user_func(array($this, $sMethodName));
        }
        return true;
    }

}

?>