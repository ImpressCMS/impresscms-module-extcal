<?php

if (!defined("ICMS_ROOT_PATH")) {
	die("ICMS root path not defined");
}

include_once ICMS_ROOT_PATH.'/modules/extcal/class/ExtcalPersistableObjectHandler.php';

class ExtcalEventmember extends icms_core_Object {

	function ExtcalEventmember()
	{
		$this->initVar('eventmember_id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('event_id', XOBJ_DTYPE_INT, null, true);
		$this->initVar('uid', XOBJ_DTYPE_INT, null, true);
	}

}

class ExtcalEventmemberHandler extends ExtcalPersistableObjectHandler
{
	function ExtcalEventmemberHandler(&$db) {
		$this->ExtcalPersistableObjectHandler($db, 'extcal_eventmember', 'ExtcalEventmember', array('event_id', 'uid'));
	}

	function createEventmember($var_arr) {
		$eventmember = $this->create();
		$eventmember->setVars($var_arr);
		if($this->insert($eventmember, true)) {
			$eventNotmemberHandler = icms_getModuleHandler('eventnotmember', 'extcal');
			$member = array($var_arr['event_id'],$var_arr['uid']);
			$eventNotmemberHandler->delete($member);
		}
	}

	function deleteEventmember($key) {
		return $this->delete($key, true);
	}

	function getMembers($eventId) {
		$memberHandler = icms::handler('icms_member');
		$eventMember = $this->getObjects(new icms_db_criteria_Item('event_id', $eventId));
		$count = count($eventMember);
		if($count > 0) {
			$in = '('.$eventMember[0]->getVar('uid');
			array_shift($eventMember);
			foreach($eventMember as $member) {
				$in .= ','.$member->getVar('uid');
			}
			$in .= ')';
			$criteria = new icms_db_criteria_Item('uid', $in, 'IN');
		} else {
			$criteria = new icms_db_criteria_Item('uid', '(0)', 'IN');
		}
		return $memberHandler->getUsers($criteria, true);
	}

	function getNbMember($eventId) {
		$criteria = new icms_db_criteria_Item('event_id',$eventId);
		return $this->getCount($criteria);
	}
}
?>