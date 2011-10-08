<?php
/**
* Calendar - a calendar and events management module for ImpressCMS
*
* Based upon eXtCal 2.22
*
* File: rss.php
*
* @copyright	http://www.xoops.org/ The XOOPS Project
* @copyright	XOOPS_copyrights.txt
* @copyright	http://www.impresscms.org/ The ImpressCMS Project
* @license		GNU General Public License (GPL)
*				a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package		eXtCal 
* @since		2.22
* @author		Zoullou
* ----------------------------------------------------------------------------------------------------------
* 				Calendar 
* @since		2.3
* @author		ImpressCMS community
*/

include '../../mainfile.php';
include_once ICMS_ROOT_PATH.'/class/template.php';

$eventHandler = icms_getModuleHandler('event', 'extcal');

if(!isset($_GET['cat'])) {
	$cat = 0;
} else {
	$cat = intval($_GET['cat']);
}

$tpl = new icms_view_Tpl();
$tpl->xoops_setCaching(0);
$tpl->xoops_setCacheTime(icms::$module->config['rss_cache_time']*60);
if (!$tpl->is_cached('db:extcal_rss.html', $cat)) {
	$events = $eventHandler->getUpcommingEvent(icms::$module->config['rss_nb_event'], $cat);
	if (is_array($events)) {
		icms::$logger->disableLogger();
		$tpl->assign('channel_title', htmlspecialchars($icmsConfig['sitename']));
		$tpl->assign('channel_link', ICMS_URL);
		$tpl->assign('channel_desc', $icmsConfig['slogan']);
		$tpl->assign('channel_lastbuild', formatTimestamp(time(), 'r'));
		$tpl->assign('channel_webmaster', $icmsConfig['adminmail']);
		$tpl->assign('channel_editor', $icmsConfig['adminmail']);
		$tpl->assign('channel_copyright', _COPYRIGHT . ' ' . formatTimestamp(time(), 'Y') . ' ' . htmlspecialchars($icmsConfig['sitename'], ENT_QUOTES, _CHARSET));
		$tpl->assign('channel_category', 'Event');
		$tpl->assign('channel_generator', ICMS_VERSION_NAME);
		$tpl->assign('channel_language', _LANGCODE);
		$tpl->assign('channel_ttl',icms::$module->config['rss_cache_time']);
		$tpl->assign('channel_folder', basename( dirname( __FILE__ ) ) );
		$tpl->assign('image_url', ICMS_URL.'/modules/'.icms::$module->getVar('dirname').'/images/calendar_logo.png');
		$tpl->assign('channel_width', 37);
		$tpl->assign('channel_height', 35);
		foreach ($events as $event) {
			$tpl->append('items', array(
				'title' => htmlspecialchars($event->getVar('event_title')), 
				'link' => ICMS_URL.'/modules/'.icms::$module->getVar('dirname').'/event.php?event='.$event->getVar('event_id'), 
				'guid' => ICMS_URL.'/modules/'.icms::$module->getVar('dirname').'/event.php?event='.$event->getVar('event_id'), 
				'pubdate' => formatTimestamp($event->getVar('event_start'), 'r'), 
				'description' => htmlspecialchars($event->getVar('event_desc'))
				));
		}
	}
}
$tpl->display('db:extcal_rss.html', $cat);
?>