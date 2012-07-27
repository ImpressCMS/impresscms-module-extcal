<?php

if (!defined("ICMS_ROOT_PATH")) {
	die("ICMS root path not defined");
}

include_once ICMS_ROOT_PATH.'/modules/icalendar/class/IcalendarPersistableObjectHandler.php';

class IcalendarEventnotmember extends icms_core_Object {

	function IcalendarEventnotmember()	{
		$this->initVar('eventnotmember_id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('event_id', XOBJ_DTYPE_INT, null, true);
		$this->initVar('uid', XOBJ_DTYPE_INT, null, true);
	}

}

class IcalendarEventnotmemberHandler extends IcalendarPersistableObjectHandler {

	function IcalendarEventnotmemberHandler(&$db) {
		$this->IcalendarPersistableObjectHandler($db, 'icalendar_eventnotmember', 'IcalendarEventnotmember', array('event_id', 'uid'));
	}

	function createEventnotmember($var_arr) {
		$eventnotmember = $this->create();
		$eventnotmember->setVars($var_arr);
		
		if($this->insert($eventnotmember, true)) {
			$eventMemberHandler = icms_getModuleHandler('eventmember', 'icalendar');
			$member = array($var_arr['event_id'],$var_arr['uid']);
			$eventMemberHandler->delete($member);
			
		}
	}

	function deleteEventnotmember($key) {
		return $this->delete($key, true);
	}

	function getMembers($eventId) {
		$memberHandler = icms::handler('icms_member');
		$eventNotMember = $this->getObjects(new icms_db_criteria_Item('event_id', $eventId));
		$count = count($eventNotMember);
		if($count > 0) {
			$in = '('.$eventNotMember[0]->getVar('uid');
			array_shift($eventNotMember);
			foreach($eventNotMember as $member) {
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