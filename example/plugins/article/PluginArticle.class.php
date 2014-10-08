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
 * @author Maxim Mzhelskiy <rus.engine@gmail.com>
 *
 */

/**
 * Запрещаем напрямую через браузер обращение к этому файлу.
 */
if (!class_exists('Plugin')) {
    die('Hacking attempt!');
}

class PluginArticle extends Plugin
{

    protected $sTargetType = 'article';

    protected $aInherits = array(
        'entity' => array('ModuleCategory_EntityCategory' => 'PluginArticle_ModuleCategory_EntityCategory'),
        'module' => array('ModuleRbac' => 'PluginArticle_ModuleRbac'),
    );

    public function Init()
    {

    }

    public function Activate()
    {
        /**
         * Создаем новый тип для дополнительных полей
         * Третий параметр true ознает перезапись параметров, если такой тип уже есть в БД
         */
        if (!$this->Property_CreateTargetType($this->sTargetType,
            array('entity' => 'PluginArticle_ModuleMain_EntityArticle', 'name' => 'Статьи'), true)
        ) {
            return false;
        }
        /**
         * Добавляем новые поля к статьям, далее пользователь может делать это через интерфейс админки
         */
        $aProperties = array(
            array(
                'data'          => array(
                    'type'  => ModuleProperty::PROPERTY_TYPE_INT,
                    'title' => 'Номер',
                    'code'  => 'number',
                    'sort'  => 100
                ),
                'validate_rule' => array(
                    'min' => 10
                ),
                'params'        => array(),
                'additional'    => array()
            )
        );
        if (!$this->Property_CreateDefaultTargetPropertyFromPlugin($aProperties, $this->sTargetType)) {
            return false;
        }

        /**
         * Создаем новый тип для категорий
         */
        if (!$this->Category_CreateTargetType($this->sTargetType, 'Статьи', array(), true)) {
            return false;
        }

        /**
         * Создаем необходимые права доступа
         */
        $aData = array(
            'groups'      => array(
                array('article', 'Статьи'),
            ),
            'roles'       => array(
                array('article_moderator', 'Модератор статей'),
            ),
            'permissions' => array(
                array(
                    'view',
                    'Просмотр статьи',
                    'msg_error' => 'У вас нет прав на просмотр статьи',
                    'group'     => 'article',
                    'roles'     => array('guest', 'user')
                ),
                array(
                    'create',
                    'Создание статей',
                    'msg_error' => 'У вас нет прав на создание статьи',
                    'group'     => 'article',
                    'roles'     => 'user'
                ),
                array(
                    'update_all',
                    'Правка всех статей',
                    'msg_error' => 'У вас нет прав на редактирование статьи',
                    'group'     => 'article',
                    'roles'     => 'article_moderator'
                ),
                array(
                    'update',
                    'Правка своих статей',
                    'msg_error' => 'У вас нет прав на редактирование статьи',
                    'group'     => 'article',
                    'roles'     => 'user'
                ),
            ),
        );
        if (!$this->Rbac_CreatePermissions($aData, $this)) {
            return false;
        }

        return true;
    }

    public function Deactivate()
    {
        $this->Property_RemoveTargetType($this->sTargetType, ModuleProperty::TARGET_STATE_NOT_ACTIVE);
        $this->Category_RemoveTargetType($this->sTargetType, ModuleCategory::TARGET_STATE_NOT_ACTIVE);
        $this->Rbac_RemovePermissions(array(
            'groups' => 'article',
            'roles'  => 'article_moderator',
        ), $this);

        return true;
    }
}