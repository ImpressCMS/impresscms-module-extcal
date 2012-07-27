<?php

if (!defined("ICMS_ROOT_PATH")) {
	die("ICMS root path not defined");
}

function icalendar_notify_iteminfo($category, $item_id)
{
	if ($category == 'global' || $category == 'cat') {
		$item['name'] = '';
		$item['url'] = '';
		return $item;
	}

	if ($category == 'event') {
		$eventHandler = icms_getModuleHandler('event', 'icalendar');
		$event = $eventHandler->getEvent($item_id, 0, true);
		$item['name'] = $event->getVar('event_title');
		$item['url'] = ICMS_URL . '/modules/icalendar/event.php?event='.$event->getVar('event_id');
		return $item;
	}
}
?>