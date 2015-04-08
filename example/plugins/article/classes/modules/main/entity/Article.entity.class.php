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
class PluginArticle_ModuleMain_EntityArticle extends EntityORM
{

    /**
     * Список поведений
     *
     * @var array
     */
    protected $aBehaviors = array(
        // Настройка дополнительных полей
        'property' => array(
            'class'       => 'ModuleProperty_BehaviorEntity',
            'target_type' => 'article'
        ),
        // Настройка категорий
        'category' => array(
            'class'                          => 'ModuleCategory_BehaviorEntity',
            'target_type'                    => 'article',
            'form_field'                     => 'category',
            'multiple'                       => true,
            'validate_enable'                => true,
            'validate_require'               => false,
            'validate_from_request'          => true,
            'validate_only_without_children' => false,
        ),
    );

    /**
     * Правила валидации полей
     *
     * @var array
     */
    protected $aValidateRules = array(
        array('user_id', 'number', 'min' => 1, 'allowEmpty' => false, 'integerOnly' => true),
        array('title', 'string', 'allowEmpty' => false, 'min' => 1, 'max' => 250, 'label' => 'Заголовок'),
        array('user_id', 'user_check'),
        array('title', 'title_check'),
    );

    /**
     * Связи с другими таблицами
     *
     * @var array
     */
    protected $aRelations = array(
        'user' => array(
            'type' => self::RELATION_TYPE_BELONGS_TO,
            'rel_entity' => 'ModuleUser_EntityUser',
            'rel_key' => 'user_id',
        ),
    );

    /**
     * Метод автоматически выполняется перед сохранением объекта сущности (статьи)
     *
     * @return bool
     */
    protected function beforeSave()
    {
        /**
         * Если статья новая, то устанавливаем дату создания
         */
        if ($this->_isNew()) {
            $this->setDateCreate(date("Y-m-d H:i:s"));
        }
        return true;
    }

    /**
     * Валидация автора статьи
     *
     * @return bool|string
     */
    public function ValidateUserCheck()
    {
        if ($this->User_GetUserById($this->getUserId())) {
            return true;
        }
        return 'Пользователь не найден';
    }

    /**
     * Валидация заголовка статьи - простое экранирование символов
     * TODO: выполнять только при отсутствии других ошибок валидации
     *
     * @return bool
     */
    public function ValidateTitleCheck()
    {
        $this->setTitle(htmlspecialchars($this->getTitle()));
        return true;
    }

    /**
     * Возвращает полный URL до детального просмотра статьи
     *
     * @return string
     */
    public function getWebUrl()
    {
        return Router::GetPath('article/view') . $this->getId() . '/';
    }
}