<?php

function xoops_module_install_icalendar(&$module) {

	// Create iCalendar upload directory
	$dir = ICMS_ROOT_PATH.'/uploads/icalendar';
	if(!is_dir($dir))
		mkdir($dir,0777,true);

	// Copy index.html files on uploads folders
	$indexFile = ICMS_ROOT_PATH.'/modules/'.icms::$module->getVar('dirname').'/include/index.html';
	copy($indexFile, ICMS_ROOT_PATH.'/uploads/icalendar/index.html');

	$module_id = $module->getVar('mid');
	$gpermHandler = icms::handler('icms_member_groupperm');
	$configHandler = icms::$config;

	/**
	 * Default public category permission mask
	 */

	// Access right
//	$gpermHandler->addRight('icalendar_cat_view', 1, ICMS_GROUP_ADMIN, $module_id);
//	$gpermHandler->addRight('icalendar_cat_view', 1, ICMS_GROUP_USERS, $module_id);
//	$gpermHandler->addRight('icalendar_cat_view', 1, ICMS_GROUP_ANONYMOUS, $module_id);

	// Can submit
//	$gpermHandler->addRight('icalendar_cat_submit', 2, ICMS_GROUP_ADMIN, $module_id);

	// Auto approve
//	$gpermHandler->addRight('icalendar_cat_autoapprove', 4, ICMS_GROUP_ADMIN, $module_id);

	return true;
}