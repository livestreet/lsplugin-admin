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
 * Расширение возможностей работы с подключаемыми файлами (css и js)
 * 
 */

class PluginAdmin_ModuleAsset extends PluginAdmin_Inherit_ModuleAsset
{

    /*
     * Счетчик последнего сброса кеша для добавления гет-параметра к имени файлов ассетов
     */
    private $iCacheLastResetCounter = null;


    /**
     * Очистить списки таблиц стилей и JS загружаемых вместе с движком
     */
    public function ClearAssets()
    {
        $this->InitAssets();
        Config::Set('head.default', array(
                'js'  => array(),
                'css' => array()
            )
        );
    }


    /**
     * Сохраняет на время сессии в переменную значение счетчика последнего сброса кеша из хранилища (модуль Storage)
     * Чтобы не дергать постоянно значение счетчика напрямую из хранилища т.к. это может быть слишком медленно
     *
     * @return integer|null
     */
    private function GetCacheLastResetCounterCached()
    {
        if (is_null($this->iCacheLastResetCounter)) {
            /*
             * получить счетчик последнего сброса кеша
             */
            $this->iCacheLastResetCounter = $this->Storage_Get(PluginAdmin_ModuleTools::CACHE_LAST_RESET_COUNTER,
                $this);
            if (!$this->iCacheLastResetCounter) {
                $this->iCacheLastResetCounter = 0;
            }
        }
        return $this->iCacheLastResetCounter;
    }


    /**
     * Добавляет к имени файла ассета счетчик последнего сброса кеша
     *
     * @param $sFile            путь и имя файла ассета
     * @return string            гет-параметр с версией счетчика
     */
    public function AddCacheLastResetCounterToAssetFile($sFile)
    {
        /*
         * Получить корректный разделитель для добавления гет-параметра к имени файла (? или &amp;)
         */
        return (strpos($sFile, '?') === false ? '?' : '&amp;') . 'v=' . (int)$this->GetCacheLastResetCounterCached();
    }

}
