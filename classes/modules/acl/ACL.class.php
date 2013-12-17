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
 * ACL (Access Control List)
 *
 */

/*
 * здесь использован хитрый трюк: цепочка наследования разрывается т.к. модуль наследует Module, а не PluginAdmin_Inherits_ModuleACL как должно быть
 * потом через __call он сравнивает методы и если это не те методы, которые ожидаются, то вызывается дальше по цепочке
 */

/*
 * потому что class_alias есть в пхп 5.3, а в лс есть эмулятор, который обьявляет алиас как абстрактный класс, который нельзя new
 */
class Not_Abstract_PluginAdmin_Inherits_ModuleACL extends PluginAdmin_Inherits_ModuleACL {}


class PluginAdmin_ModuleACL extends Module {

	private $oUserCurrent = null;
	/*
	 * объект наследумого модуля (для вызова цепочки наследования дальше)
	 */
	private $oInheritedParentClass = null;


	public function Init() {
		$this->oInheritedParentClass = new Not_Abstract_PluginAdmin_Inherits_ModuleACL($this->oEngine);

		//parent::Init();
		$this->oUserCurrent = $this->User_GetUserCurrent();

	}


	/**
	 * Обработчик для реализации механизма "read only" банов, захватывающий на себя все разрешения в движке
	 *
	 * @param $sName		имя вызываемого метода
	 * @param $aArgs		массив аргументов
	 * @return mixed
	 */
	public function __call($sName, $aArgs) {
		/*
		 * tip: все методы, которые разрешают определенное действие (публикация топика или комментария) начинаются на "Can" или "Is" (CanCreateBlog, CanAddTopic, IsAllowEditTopic)
		 */
		if (stripos($sName, 'Can') === 0 or stripos($sName, 'Is') === 0) {
			if ($oBan = $this->oUserCurrent->getBannedReadOnly()) {
				/*
				 * пополнить статистику срабатываний
				 */
				//$this->AddBanStats($oBan);//todo:
				/*
				 * сообщение пользователю в зависимости от типа бана (временный или постоянный)
				 */
				$this->Message_AddError($oBan->getBanMessageForUser(), '403');
				return false;
			}
		}
		/*
		 * продолжить вызов по цепочке
		 */
		$aArgsRef=array();
		foreach ($aArgs as $key=>$v) {
			$aArgsRef[]=&$aArgs[$key];
		}
		return call_user_func_array(array($this->oInheritedParentClass, $sName), $aArgsRef);
	}

}

?>