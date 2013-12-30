<?php
/*-------------------------------------------------------
*
*   LiveStreet Engine Social Networking
*   Copyright © 2008 Mzhelskiy Maxim
*
*--------------------------------------------------------
*
*   Official site: www.livestreet.ru
*   Contact e-mail: rus.engine@gmail.com
*
*   GNU General Public License, version 2:
*   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*/

class PluginArticle_ModuleMain_EntityArticle extends EntityORM {

	protected $aValidateRules=array(
		array('user_id','number','min'=>1,'allowEmpty'=>false,'integerOnly'=>true),
		array('title','string','allowEmpty'=>false,'min'=>1,'max'=>250,'label'=>'Заголовок'),

		array('user_id','user_check'),
		array('title','title_check'),
	);

	protected $aRelations=array(
		'user' => array(self::RELATION_TYPE_BELONGS_TO,'ModuleUser_EntityUser','user_id'),
	);

	protected function beforeSave() {
		if ($this->_isNew()) {
			$this->setDateCreate(date("Y-m-d H:i:s"));
		}
		return true;
	}

	public function ValidateUserCheck() {
		if ($this->User_GetUserById($this->getUserId())) {
			return true;
		}
		return 'Пользователь не найден';
	}

	public function ValidateTitleCheck() {
		$this->setTitle(htmlspecialchars($this->getTitle()));
		return true;
	}

	public function getWebUrl() {
		return Router::GetPath('article/view').$this->getId().'/';
	}

	public function getPropertyTargetType() {
		return $this->PluginArticle_Main_GetPropertyTargetType();
	}
}