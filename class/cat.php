<?php


if (!defined("ICMS_ROOT_PATH")) {
	die("ICMS root path not defined");
}

include_once ICMS_ROOT_PATH.'/modules/icalendar/class/IcalendarPersistableObjectHandler.php';
include_once ICMS_ROOT_PATH.'/modules/icalendar/class/perm.php';
include_once ICMS_ROOT_PATH.'/modules/icalendar/class/time.php';

class IcalendarCat extends icms_core_Object
{

	var $externalKey = array();

	function IcalendarCat()
	{
		$this->initVar('cat_id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('cat_name', XOBJ_DTYPE_TXTBOX, null, true, 255);
		$this->initVar('cat_desc', XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar('cat_color', XOBJ_DTYPE_TXTBOX, '000000', false, 255);
	}

}

class IcalendarCatHandler extends IcalendarPersistableObjectHandler {

	var $_icalendarPerm;

	function IcalendarCatHandler(&$db)
	{ 
		$this->_icalendarPerm = IcalendarPerm::getHandler();
		$this->IcalendarPersistableObjectHandler($db, 'icalendar_cat', 'IcalendarCat', 'cat_id');
	}

	function createCat(&$data) {
		$cat = $this->create();
		$cat->setVars($data);
		$this->insert($cat);

		$catId = $this->getInsertId();

		// Retriving permission mask
		$gpermHandler = icms::handler('icms_member_groupperm');
		$moduleId = icms::$module->getVar('mid');

		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item('gperm_name','icalendar_perm_mask'));
		$criteria->add(new icms_db_criteria_Item('gperm_modid',$moduleId));
		$permMask = $gpermHandler->getObjects($criteria);

		// Retriving group list
		$memberHandler = icms::handler('icms_member');
		$glist = $memberHandler->getGroupList();

		// Applying permission mask
		foreach($permMask as $perm) {
			if($perm->getVar('gperm_itemid') == 1)
				$gpermHandler->addRight('icalendar_cat_view', $cat->getVar('cat_id'), $perm->getVar('gperm_groupid'), $moduleId);
			if($perm->getVar('gperm_itemid') == 2)
				$gpermHandler->addRight('icalendar_cat_submit', $cat->getVar('cat_id'), $perm->getVar('gperm_groupid'), $moduleId);
			if($perm->getVar('gperm_itemid') == 4)
				$gpermHandler->addRight('icalendar_cat_autoapprove', $cat->getVar('cat_id'), $perm->getVar('gperm_groupid'), $moduleId);
			if($perm->getVar('gperm_itemid') == 8)
				$gpermHandler->addRight('icalendar_cat_edit', $cat->getVar('cat_id'), $perm->getVar('gperm_groupid'), $moduleId);
		}
		return true;
	}

	function modifyCat($catId,$data) {
		$cat = $this->get($catId);
		$cat->setVars($data);
		return $this->insert($cat);
	}

	function deleteCat($catId) {
		/* TODO :
		 - Delete all event in this category
		*/
		$this->delete($catId);
	}

	// Return one cat selected by his id
	function getCat($catId, $skipPerm = false) {
		$criteriaCompo = new icms_db_criteria_Compo();
		$criteriaCompo->add(new icms_db_criteria_Item('cat_id', $catId));
		if(!$skipPerm) {
			$this->_addCatPermCriteria($criteriaCompo, icms::$user);
		}
		$ret = $this->getObjects($criteriaCompo);
		if(isset($ret[0])) {
			return $ret[0];
		} else {
			return false;
		}
	}

	function getAllCat($user, $perm = 'icalendar_cat_view') {
		$criteriaCompo = new icms_db_criteria_Compo();
		if($perm != 'all') {
			$this->_addCatPermCriteria($criteriaCompo, $user, $perm);
		}
		return $this->getObjects($criteriaCompo);
	}

	function _addCatPermCriteria(&$criteria, &$user, $perm = 'icalendar_cat_view') {
		$authorizedAccessCats = $this->_icalendarPerm->getAuthorizedCat($user, 'icalendar_cat_view');
		$count = count($authorizedAccessCats);
		if($count > 0) {
			$in = '('.$authorizedAccessCats[0];
			array_shift($authorizedAccessCats);
			foreach($authorizedAccessCats as $authorizedAccessCat) {
				$in .= ','.$authorizedAccessCat;
			}
			$in .= ')';
			$criteria->add(new icms_db_criteria_Item('cat_id', $in, 'IN'));
		} else {
			$criteria->add(new icms_db_criteria_Item('cat_id', '(0)', 'IN'));
		}
	}

	function haveSubmitRight(&$user) {
		return count($this->_icalendarPerm->getAuthorizedCat($user, 'icalendar_cat_submit')) > 0;
	}

}
?>