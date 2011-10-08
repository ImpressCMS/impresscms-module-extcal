<?php

if (!defined("ICMS_ROOT_PATH")) {
	die("ICMS root path not defined");
}

function extcal_search($queryarray, $andor, $limit, $offset, $userid)
{
	
	$eventHandler = icms_getModuleHandler('event', 'extcal');
	
	return $eventHandler->getSearchEvent($queryarray, $andor, $limit, $offset, $userid, icms::$user);

}
?>