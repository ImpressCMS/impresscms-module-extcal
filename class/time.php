<?php

if (!defined("ICMS_ROOT_PATH")) {
	die("ICMS root path not defined");
}

global $icmsConfig;

include_once ICMS_ROOT_PATH."/language/".$icmsConfig['language']."/calendar.php";
if(file_exists(ICMS_ROOT_PATH."/modules/icalendar/language/".$icmsConfig['language']."/main.php")) {
	include_once ICMS_ROOT_PATH."/modules/icalendar/language/".$icmsConfig['language']."/main.php";
} else {
	include_once ICMS_ROOT_PATH."/modules/icalendar/language/english/main.php";
}

class IcalendarTime {

	function &getHandler()
	{
		static $timeHandler;
		if(!isset($timeHandler)) {
			$timeHandler = new IcalendarTime();
		}
		return $timeHandler;
	}
	
	function _getUserTimeZone($user)
	{
		global $icmsConfig;
		return ($user) ? $user->getVar("timezone_offset") : $icmsConfig['default_TZ'];
	}
	
	function getMonthName($id)
	{
		$monthName = array(
			'1'=>_CAL_JANUARY,
			'2'=>_CAL_FEBRUARY,
			'3'=>_CAL_MARCH,
			'4'=>_CAL_APRIL,
			'5'=>_CAL_MAY,
			'6'=>_CAL_JUNE,
			'7'=>_CAL_JULY,
			'8'=>_CAL_AUGUST,
			'9'=>_CAL_SEPTEMBER,
			'10'=>_CAL_OCTOBER,
			'11'=>_CAL_NOVEMBER,
			'12'=>_CAL_DECEMBER
		);
		return $monthName[$id];
	}
	
	function getDayName($id)
	{
		$dayName = array(
			_CAL_SUNDAY,
			_CAL_MONDAY,
			_CAL_TUESDAY,
			_CAL_WEDNESDAY,
			_CAL_THURSDAY,
			_CAL_FRIDAY,
			_CAL_SATURDAY
		);
		return $dayName[$id];
	}
	
	function getFormatedDate($format, $timestamp)
	{
		$patterns = array(
			'/January/',
			'/February/',
			'/March/',
			'/April/',
			'/May/',
			'/June/',
			'/July/',
			'/August/',
			'/September/',
			'/October/',
			'/November/',
			'/December/',
			'/Jan /',
			'/Feb /',
			'/Mar /',
			'/Apr /',
			'/May /',
			'/Jun /',
			'/Jul /',
			'/Aug /',
			'/Sep /',
			'/Oct /',
			'/Nov /',
			'/Dec /',
			'/Sunday/',
			'/Monday/',
			'/Tuesday/',
			'/Wednesday/',
			'/Thursday/',
			'/Friday/',
			'/Saturday/',
			'/Sun /',
			'/Mon /',
			'/Tue /',
			'/Wed /',
			'/Thu /',
			'/Fri /',
			'/Sat /'
		);
		$replacements = array(
			_CAL_JANUARY,
			_CAL_FEBRUARY,
			_CAL_MARCH,
			_CAL_APRIL,
			_CAL_MAY,
			_CAL_JUNE,
			_CAL_JULY,
			_CAL_AUGUST,
			_CAL_SEPTEMBER,
			_CAL_OCTOBER,
			_CAL_NOVEMBER,
			_CAL_DECEMBER,
			substr(_CAL_JANUARY,0,3).' ',
			substr(_CAL_FEBRUARY,0,3).' ',
			substr(_CAL_MARCH,0,3).' ',
			substr(_CAL_APRIL,0,3).' ',
			substr(_CAL_MAY,0,3).' ',
			substr(_CAL_JUNE,0,3).' ',
			substr(_CAL_JULY,0,3).' ',
			substr(_CAL_AUGUST,0,3).' ',
			substr(_CAL_SEPTEMBER,0,3).' ',
			substr(_CAL_OCTOBER,0,3).' ',
			substr(_CAL_NOVEMBER,0,3).' ',
			substr(_CAL_DECEMBER,0,3).' ',
			_CAL_SUNDAY,
			_CAL_MONDAY,
			_CAL_TUESDAY,
			_CAL_WEDNESDAY,
			_CAL_THURSDAY,
			_CAL_FRIDAY,
			_CAL_SATURDAY,
			substr(_CAL_SUNDAY,0,3).' ',
			substr(_CAL_MONDAY,0,3).' ',
			substr(_CAL_TUESDAY,0,3).' ',
			substr(_CAL_WEDNESDAY,0,3).' ',
			substr(_CAL_THURSDAY,0,3).' ',
			substr(_CAL_FRIDAY,0,3).' ',
			substr(_CAL_SATURDAY,0,3).' '
		);
		return preg_replace($patterns,$replacements,date($format, $timestamp));
	}
	
	function getFormatedReccurRule($event_recur_rules) {
		
		$eventOptions = explode('|', $event_recur_rules);
		
		switch($eventOptions[0]) {

			case 'daily':
				
				$interval = $eventOptions[1];
				return sprintf(_MD_ICALENDAR_RR_DAILY, $interval);

				break;

			case 'weekly':

				$daysName = array('MO'=>_CAL_MONDAY,'TU'=>_CAL_TUESDAY,'WE'=>_CAL_WEDNESDAY,'TH'=>_CAL_THURSDAY,'FR'=>_CAL_FRIDAY,'SA'=>_CAL_SATURDAY,'SU'=>_CAL_SUNDAY);
			
				$interval = $eventOptions[1];
				array_shift($eventOptions);
				array_shift($eventOptions);
				$day = '';
				foreach($eventOptions as $option) {
					$day .= " ".$daysName[$option].", ";
				}
				$ret = sprintf(_MD_ICALENDAR_RR_WEEKLY, $day, $interval);

				return $ret;
				
				break;

			case 'monthly':
				
				$monthDays = array(
									'1MO'=>_MD_ICALENDAR_1_MO,
									'1TU'=>_MD_ICALENDAR_1_TU,
									'1WE'=>_MD_ICALENDAR_1_WE,
									'1TH'=>_MD_ICALENDAR_1_TH,
									'1FR'=>_MD_ICALENDAR_1_FR,
									'1SA'=>_MD_ICALENDAR_1_SA,
									'1SU'=>_MD_ICALENDAR_1_SU,
									'2MO'=>_MD_ICALENDAR_2_MO,
									'2TU'=>_MD_ICALENDAR_2_TU,
									'2WE'=>_MD_ICALENDAR_2_WE,
									'2TH'=>_MD_ICALENDAR_2_TH,
									'2FR'=>_MD_ICALENDAR_2_FR,
									'2SA'=>_MD_ICALENDAR_2_SA,
									'2SU'=>_MD_ICALENDAR_2_SU,
									'3MO'=>_MD_ICALENDAR_3_MO,
									'3TU'=>_MD_ICALENDAR_3_TU,
									'3WE'=>_MD_ICALENDAR_3_WE,
									'3TH'=>_MD_ICALENDAR_3_TH,
									'3FR'=>_MD_ICALENDAR_3_FR,
									'3SA'=>_MD_ICALENDAR_3_SA,
									'3SU'=>_MD_ICALENDAR_3_SU,
									'4MO'=>_MD_ICALENDAR_4_MO,
									'4TU'=>_MD_ICALENDAR_4_TU,
									'4WE'=>_MD_ICALENDAR_4_WE,
									'4TH'=>_MD_ICALENDAR_4_TH,
									'4FR'=>_MD_ICALENDAR_4_FR,
									'4SA'=>_MD_ICALENDAR_4_SA,
									'4SU'=>_MD_ICALENDAR_4_SU,
									'-1MO'=>_MD_ICALENDAR_LAST_MO,
									'-1TU'=>_MD_ICALENDAR_LAST_TU,
									'-1WE'=>_MD_ICALENDAR_LAST_WE,
									'-1TH'=>_MD_ICALENDAR_LAST_TH,
									'-1FR'=>_MD_ICALENDAR_LAST_FR,
									'-1SA'=>_MD_ICALENDAR_LAST_SA,
									'-1SU'=>_MD_ICALENDAR_LAST_SU
									);
				
				$interval = $eventOptions[1];
				if(substr($eventOptions[2], 0,2) == 'MD') {
					return sprintf(_MD_ICALENDAR_RR_MONTHLY, substr($eventOptions[2], 2), $interval);
				} else {
					return sprintf(_MD_ICALENDAR_RR_MONTHLY, $monthDays[$eventOptions[2]], $interval);
				}

				break;

			case 'yearly':

				$monthDays = array(
									'1MO'=>_MD_ICALENDAR_1_MO,
									'1TU'=>_MD_ICALENDAR_1_TU,
									'1WE'=>_MD_ICALENDAR_1_WE,
									'1TH'=>_MD_ICALENDAR_1_TH,
									'1FR'=>_MD_ICALENDAR_1_FR,
									'1SA'=>_MD_ICALENDAR_1_SA,
									'1SU'=>_MD_ICALENDAR_1_SU,
									'2MO'=>_MD_ICALENDAR_2_MO,
									'2TU'=>_MD_ICALENDAR_2_TU,
									'2WE'=>_MD_ICALENDAR_2_WE,
									'2TH'=>_MD_ICALENDAR_2_TH,
									'2FR'=>_MD_ICALENDAR_2_FR,
									'2SA'=>_MD_ICALENDAR_2_SA,
									'2SU'=>_MD_ICALENDAR_2_SU,
									'3MO'=>_MD_ICALENDAR_3_MO,
									'3TU'=>_MD_ICALENDAR_3_TU,
									'3WE'=>_MD_ICALENDAR_3_WE,
									'3TH'=>_MD_ICALENDAR_3_TH,
									'3FR'=>_MD_ICALENDAR_3_FR,
									'3SA'=>_MD_ICALENDAR_3_SA,
									'3SU'=>_MD_ICALENDAR_3_SU,
									'4MO'=>_MD_ICALENDAR_4_MO,
									'4TU'=>_MD_ICALENDAR_4_TU,
									'4WE'=>_MD_ICALENDAR_4_WE,
									'4TH'=>_MD_ICALENDAR_4_TH,
									'4FR'=>_MD_ICALENDAR_4_FR,
									'4SA'=>_MD_ICALENDAR_4_SA,
									'4SU'=>_MD_ICALENDAR_4_SU,
									'-1MO'=>_MD_ICALENDAR_LAST_MO,
									'-1TU'=>_MD_ICALENDAR_LAST_TU,
									'-1WE'=>_MD_ICALENDAR_LAST_WE,
									'-1TH'=>_MD_ICALENDAR_LAST_TH,
									'-1FR'=>_MD_ICALENDAR_LAST_FR,
									'-1SA'=>_MD_ICALENDAR_LAST_SA,
									'-1SU'=>_MD_ICALENDAR_LAST_SU
									);
			
				$monthName = array(
									1=>_CAL_JANUARY,
									2=>_CAL_FEBRUARY,
									3=>_CAL_MARCH,
									4=>_CAL_APRIL,
									5=>_CAL_MAY,
									6=>_CAL_JUNE,
									7=>_CAL_JULY,
									8=>_CAL_AUGUST,
									9=>_CAL_SEPTEMBER,
									10=>_CAL_OCTOBER,
									11=>_CAL_NOVEMBER,
									12=>_CAL_DECEMBER
									);
			
				$interval = $eventOptions[1];
				$day = $eventOptions[2];
				array_shift($eventOptions);
				array_shift($eventOptions);
				array_shift($eventOptions);
				$month = '';
				foreach($eventOptions as $option) {
					$month .= " ".$monthName[$option].", ";
				}
				if(array_key_exists($day, $monthDays)) {
					$dayString = $monthDays[$day];
				} else {
					$dayString = $day;
				}
				$ret = sprintf(_MD_ICALENDAR_RR_YEARLY, $month, $dayString, $interval);

				return $ret;			
				break;
		}
	}
}
?>