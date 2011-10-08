<?php

if (!defined("ICMS_ROOT_PATH")) {
	die("ICMS root path not defined");
}

class ExtcalPerm {

	function &getHandler()
	{
		static $permHandler;
		if(!isset($permHandler)) {
			$permHandler = new ExtcalPerm();
		}
		return $permHandler;
	}

	function _getUserGroup(&$user) {
		if (is_a($user, 'icms_member_user_Object')) {
			return $user->getGroups();
		} else {
			return ICMS_GROUP_ANONYMOUS;
		}
	}

	function getAuthorizedCat(&$user, $perm) {
		static $authorizedCat;
		$userId = ($user) ? $user->getVar('uid') : 0;
		if(!isset($authorizedCat[$perm][$userId])) {
			$groupPermHandler = icms::handler( 'icms_member_groupperm' );
			$moduleHandler = icms::handler( 'icms_module' );
			$module = $moduleHandler->getByDirname('extcal');
			if(!$module){
				return false;}
			$authorizedCat[$perm][$userId] = $groupPermHandler->getItemIds($perm, $this->_getUserGroup($user), $module->getVar('mid'));
		}
		return $authorizedCat[$perm][$userId];
	}

	function isAllowed(&$user, $perm, $catId) {
		$autorizedCat = $this->getAuthorizedCat($user, $perm);
		return in_array($catId, $autorizedCat);
	}
}
?>