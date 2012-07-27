<?php
/**
* Calendar - a calendar and events management module for ImpressCMS
*
* Based upon iCalendar 2.22
*
* File: icms_version.php
*
* @copyright	http://www.xoops.org/ The XOOPS Project
* @copyright	XOOPS_copyrights.txt
* @copyright	http://www.impresscms.org/ The ImpressCMS Project
* @license		GNU General Public License (GPL)
*				a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package		iCalendar 
* @since		2.22
* @author		Zoullou
* ----------------------------------------------------------------------------------------------------------
* 				Calendar 
* @since		2.3
* @author		ImpressCMS community
*/

$modversion['name'] 			= _MI_ICALENDAR_NAME;
$modversion['version'] 			= 2.3;
$modversion['status'] 			= 'RC-01';
$modversion['status_version'] 	= 'RC-01';
$modversion['description'] 		= _MI_ICALENDAR_DESC;
$modversion['credits'] 			= 'http://www.zoullou.net/';
$modversion['help'] 			= '';
$modversion['license'] 			= 'GPL see LICENSE';
$modversion['image'] 			= 'images/calendar_logo.png';
$modversion['iconsmall'] 		= 'images/date.png'; 
$modversion['iconbig'] 			= 'images/calendar_logo.png';
$modversion['dirname'] 			= basename(dirname(__FILE__));

// 	** Contributors **
$modversion['author'] 					= 'Version developer: Zoullou';
$modversion['credits'] 					= 'http://www.zoullou.net/';
$modversion['author_website_url'] 		= 'http://www.zoullou.net/';
$modversion['author_website_name'] 		= 'Zoullou.net';

$modversion['support_site_url'] = 'http://community.impresscms.org/modules/newbb/viewforum.php?forum=9';
$modversion['support_site_name']= 'ImpressCMS Community Forum - Modules Support';
$modversion['submit_bug'] 		= 'http://sourceforge.net/apps/trac/impresscms/newticket?type=defect';

$modversion['people']['testers'][] = '';

//   ** Translators **
$modversion['people']['translators'][] = '';


//	** If Release Candidate **
$modversion['warning'] = _CO_ICMS_WARNING_RC;

//	** If Final  **
// $modversion['warning'] = _MODABOUT_WARNING_FINAL;

$modversion['onInstall'] = 'include/install_function.php';
$modversion['onUpdate'] = 'include/update_function.php';

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

// Menu


$modversion['hasMain'] = 1;

$module_handler = icms::handler( 'icms_module' );
$module = &$module_handler -> getByDirname( $modversion['dirname'] );
if(isset(icms::$module) && icms::$module->getVar('dirname') == "icalendar") {
	$groups = ( is_object( icms::$user ) ) ? icms::$user -> getGroups() : ICMS_GROUP_ANONYMOUS;
	$gperm_handler = icms::handler('icms_member_groupperm');
    if ( $gperm_handler -> checkRight( 'icalendar_cat_submit', 0, $groups, $module -> getVar( 'mid' ) ) ) {
		$modversion['sub'][0]['name'] = _MI_ICALENDAR_SUBMIT_EVENT;
		$modversion['sub'][0]['url'] = 'new_event.php';
	}
	/*$i = 1;
	$modversion['sub'][$i]['name'] = 'Calendar Month';
	$modversion['sub'][$i]['url'] = 'calendar-month.php';
	$i++;
	$modversion['sub'][$i]['name'] = 'Calendar Week';
	$modversion['sub'][$i]['url'] = 'calendar-week.php';
	$i++;
	$modversion['sub'][$i]['name'] = 'Year';
	$modversion['sub'][$i]['url'] = 'year.php';
	$i++;
	$modversion['sub'][$i]['name'] = 'Month';
	$modversion['sub'][$i]['url'] = 'month.php';
	$i++;
	$modversion['sub'][$i]['name'] = 'Week';
	$modversion['sub'][$i]['url'] = 'week.php';
	$i++;
	$modversion['sub'][$i]['name'] = 'Day';
	$modversion['sub'][$i]['url'] = 'day.php';
	$i++;*/
}

// SQL
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][1] = 'icalendar_cat';
$modversion['tables'][2] = 'icalendar_event';
$modversion['tables'][3] = 'icalendar_eventmember';
$modversion['tables'][4] = 'icalendar_eventnotmember';
$modversion['tables'][5] = 'icalendar_file';

// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['itemName'] = 'event';
$modversion['comments']['pageName'] = 'event.php';

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'icalendar_search';

// Config items
$i = 0;
$modversion['config'][$i]['name'] = 'start_page';
$modversion['config'][$i]['title'] = '_MI_ICALENDAR_START_PAGE';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$modversion['config'][$i]['options'] = array('_MI_ICALENDAR_MONTH_CALENDAR'=>0, '_MI_ICALENDAR_WEEKLY_CALENDAR'=>1, '_MI_ICALENDAR_YEARLY_VIEW'=>2, '_MI_ICALENDAR_MONTHLY_VIEW'=>3, '_MI_ICALENDAR_WEEKLY_VIEW'=>4, '_MI_ICALENDAR_DAILY_VIEW'=>5);
$i++;
$modversion['config'][$i]['name'] = 'week_start_day';
$modversion['config'][$i]['title'] = '_MI_ICALENDAR_WEEK_START_DAY';
$modversion['config'][$i]['description'] = '_MI_ICALENDAR_WEEK_START_DAY_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['options'] = array('_MI_ICALENDAR_SUNDAY'=>0, '_MI_ICALENDAR_MONDAY'=>1, '_MI_ICALENDAR_TUESDAY'=>2, '_MI_ICALENDAR_WEDNESDAY'=>3, '_MI_ICALENDAR_THURSDAY'=>4, '_MI_ICALENDAR_FRIDAY'=>5, '_MI_ICALENDAR_SATURDAY'=>6);
$i++;
$modversion['config'][$i]['name'] = 'rss_cache_time';
$modversion['config'][$i]['title'] = '_MI_ICALENDAR_RSS_CACHE_TIME';
$modversion['config'][$i]['description'] = '_MI_ICALENDAR_RSS_CACHE_TIME_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 60;
$i++;
$modversion['config'][$i]['name'] = 'rss_nb_event';
$modversion['config'][$i]['title'] = '_MI_ICALENDAR_RSS_NB_EVENT';
$modversion['config'][$i]['description'] = '_MI_ICALENDAR_RSS_NB_EVENT_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 10;
$i++;
$modversion['config'][$i]['name'] = 'whos_going';
$modversion['config'][$i]['title'] = '_MI_ICALENDAR_WHOS_GOING';
$modversion['config'][$i]['description'] = '_MI_ICALENDAR_WHOS_GOING_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'whosnot_going';
$modversion['config'][$i]['title'] = '_MI_ICALENDAR_WHOSNOT_GOING';
$modversion['config'][$i]['description'] = '_MI_ICALENDAR_WHOSNOT_GOING_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'sort_order';
$modversion['config'][$i]['title'] = '_MI_ICALENDAR_SORT_ORDER';
$modversion['config'][$i]['description'] = '_MI_ICALENDAR_SORT_ORDER_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['options'] = array('_MI_ICALENDAR_ASCENDING'=>'ASC', '_MI_ICALENDAR_DESCENDING'=>'DESC');
$i++;
$modversion['config'][$i]['name'] = 'event_date_year';
$modversion['config'][$i]['title'] = '_MI_ICALENDAR_EY_DATE_PATTERN';
$modversion['config'][$i]['description'] = '_MI_ICALENDAR_EY_DATE_PATTERN_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_ICALENDAR_EY_DATE_PATTERN_VALUE;
$i++;
$modversion['config'][$i]['name'] = 'nav_date_month';
$modversion['config'][$i]['title'] = '_MI_ICALENDAR_NM_DATE_PATTERN';
$modversion['config'][$i]['description'] = '_MI_ICALENDAR_NM_DATE_PATTERN_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_ICALENDAR_NM_DATE_PATTERN_VALUE;
$i++;
$modversion['config'][$i]['name'] = 'event_date_month';
$modversion['config'][$i]['title'] = '_MI_ICALENDAR_EM_DATE_PATTERN';
$modversion['config'][$i]['description'] = '_MI_ICALENDAR_EM_DATE_PATTERN_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_ICALENDAR_EM_DATE_PATTERN_VALUE;
$i++;
$modversion['config'][$i]['name'] = 'nav_date_week';
$modversion['config'][$i]['title'] = '_MI_ICALENDAR_NW_DATE_PATTERN';
$modversion['config'][$i]['description'] = '_MI_ICALENDAR_NW_DATE_PATTERN_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_ICALENDAR_NW_DATE_PATTERN_VALUE;
$i++;
$modversion['config'][$i]['name'] = 'event_date_week';
$modversion['config'][$i]['title'] = '_MI_ICALENDAR_EW_DATE_PATTERN';
$modversion['config'][$i]['description'] = '_MI_ICALENDAR_EW_DATE_PATTERN_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_ICALENDAR_EW_DATE_PATTERN_VALUE;
$i++;
$modversion['config'][$i]['name'] = 'nav_date_day';
$modversion['config'][$i]['title'] = '_MI_ICALENDAR_ND_DATE_PATTERN';
$modversion['config'][$i]['description'] = '_MI_ICALENDAR_ND_DATE_PATTERN_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_ICALENDAR_ND_DATE_PATTERN_VALUE;
$i++;
$modversion['config'][$i]['name'] = 'event_date_day';
$modversion['config'][$i]['title'] = '_MI_ICALENDAR_ED_DATE_PATTERN';
$modversion['config'][$i]['description'] = '_MI_ICALENDAR_ED_DATE_PATTERN_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_ICALENDAR_ED_DATE_PATTERN_VALUE;
$i++;
$modversion['config'][$i]['name'] = 'event_date_event';
$modversion['config'][$i]['title'] = '_MI_ICALENDAR_EE_DATE_PATTERN';
$modversion['config'][$i]['description'] = '_MI_ICALENDAR_EE_DATE_PATTERN_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_ICALENDAR_EE_DATE_PATTERN_VALUE;
$i++;
$modversion['config'][$i]['name'] = 'event_date_block';
$modversion['config'][$i]['title'] = '_MI_ICALENDAR_EB_DATE_PATTERN';
$modversion['config'][$i]['description'] = '_MI_ICALENDAR_EB_DATE_PATTERN_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_ICALENDAR_EB_DATE_PATTERN_VALUE;
$i++;
$modversion['config'][$i]['name'] = 'diplay_past_event_list';
$modversion['config'][$i]['title'] = '_MI_ICALENDAR_DISP_PAST_E_LIST';
$modversion['config'][$i]['description'] = '_MI_ICALENDAR_DISP_PAST_E_LIST_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'diplay_past_event_cal';
$modversion['config'][$i]['title'] = '_MI_ICALENDAR_DISP_PAST_E_CAL';
$modversion['config'][$i]['description'] = '_MI_ICALENDAR_DISP_PAST_E_CAL_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'allowed_file_extention';
$modversion['config'][$i]['title'] = '_MI_ICALENDAR_FILE_EXTENTION';
$modversion['config'][$i]['description'] = '_MI_ICALENDAR_FILE_EXTENTION_DESC';
$modversion['config'][$i]['formtype'] = 'select_multi';
$modversion['config'][$i]['valuetype'] = 'array';
$modversion['config'][$i]['default'] = array('doc', 'jpg', 'jpeg', 'gif', 'png', 'pdf', 'txt');
$modversion['config'][$i]['options'] = array('ai'=>'ai', 'aif'=>'aif', 'aiff'=>'aiff', 'asc'=>'asc', 'au'=>'au', 'avi'=>'avi', 'bin'=>'bin', 'bmp'=>'bmp', 'class'=>'class', 'csh'=>'csh', 'css'=>'css', 'dcr'=>'dcr', 'dir'=>'dir', 'dll'=>'dll', 'doc'=>'doc', 'dot'=>'dot', 'dtd'=>'dtd', 'dxr'=>'dxr', 'ent'=>'ent', 'eps'=>'eps', 'exe'=>'exe', 'gif'=>'gif', 'gtar'=>'gtar', 'gz'=>'gz', 'hqx'=>'hqx', 'htm'=>'htm', 'html'=>'html', 'ics'=>'ics', 'ifb'=>'ifb', 'jpe'=>'jpe', 'jpeg'=>'jpeg', 'jpg'=>'jpg', 'js'=>'js', 'kar'=>'kar', 'lha'=>'lha', 'lzh'=>'lzh', 'm3u'=>'m3u', 'mid'=>'mid', 'midi'=>'midi', 'mod'=>'mod', 'mov'=>'mov', 'mp1'=>'mp1', 'mp2'=>'mp2', 'mp3'=>'mp3', 'mpe'=>'mpe', 'mpeg'=>'mpeg', 'mpg'=>'mpg', 'pbm'=>'pbm', 'pdf'=>'pdf', 'pgm'=>'pgm', 'php'=>'php', 'php3'=>'php3', 'php5'=>'php5', 'phtml'=>'phtml', 'png'=>'png', 'pnm'=>'pnm', 'ppm'=>'ppm', 'ppt'=>'ppt', 'ps'=>'ps', 'qt'=>'qt', 'ra'=>'ra', 'ram'=>'ram', 'rm'=>'rm', 'rpm'=>'rpm', 'rtf'=>'rtf', 'sgm'=>'sgm', 'sgml'=>'sgml', 'sh'=>'sh', 'sit'=>'sit', 'smi'=>'smi', 'smil'=>'smil', 'snd'=>'snd', 'so'=>'so', 'spl'=>'spl', 'swf'=>'swf', 'tar'=>'tar', 'tcl'=>'tcl', 'tif'=>'tif', 'tiff'=>'tiff', 'tsv'=>'tsv', 'txt'=>'txt', 'wav'=>'wav', 'wbmp'=>'wbmp', 'wbxml'=>'wbxml', 'wml'=>'wml', 'wmlc'=>'wmlc', 'wmls'=>'wmls', 'wmlsc'=>'wmlsc', 'xbm'=>'xbm', 'xht'=>'xht', 'xhtml'=>'xhtml', 'xla'=>'xla', 'xls'=>'xls', 'xlt'=>'xlt', 'xpm'=>'xpm', 'xsl'=>'xsl', 'zip'=>'zip');
$i++;
$modversion['config'][$i]['name'] = 'allow_html';
$modversion['config'][$i]['title'] = '_MI_ICALENDAR_HTML';
$modversion['config'][$i]['description'] = '_MI_ICALENDAR_HTML_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;

// Templates
$modversion['templates'][1]['file'] = 'icalendar_year.html';
$modversion['templates'][1]['description'] = '';
$modversion['templates'][2]['file'] = 'icalendar_month.html';
$modversion['templates'][2]['description'] = '';
$modversion['templates'][3]['file'] = 'icalendar_week.html';
$modversion['templates'][3]['description'] = '';
$modversion['templates'][4]['file'] = 'icalendar_day.html';
$modversion['templates'][4]['description'] = '';
$modversion['templates'][5]['file'] = 'icalendar_calendar-month.html';
$modversion['templates'][5]['description'] = '';
$modversion['templates'][6]['file'] = 'icalendar_calendar-week.html';
$modversion['templates'][6]['description'] = '';
$modversion['templates'][7]['file'] = 'icalendar_event.html';
$modversion['templates'][7]['description'] = '';
$modversion['templates'][8]['file'] = 'icalendar_post.html';
$modversion['templates'][8]['description'] = '';
$modversion['templates'][9]['file'] = 'icalendar_rss.html';
$modversion['templates'][9]['description'] = '';
$modversion['templates'][10]['file'] = 'icalendar_navbar.html';
$modversion['templates'][10]['description'] = '';

// Blocks
$i = 1;
$modversion['blocks'][$i]['file'] = "icalendar_blocks.php";
$modversion['blocks'][$i]['name'] = _MI_ICALENDAR_BNAME1;
$modversion['blocks'][$i]['description'] = _MI_ICALENDAR_BNAME1_DESC;
$modversion['blocks'][$i]['show_func'] = "bIcalendarMinicalShow";
$modversion['blocks'][$i]['options'] = "0|0|150|225|1|3|10|0|1|0";
$modversion['blocks'][$i]['edit_func'] = "bIcalendarMinicalEdit";
$modversion['blocks'][$i]['template'] = 'icalendar_block_minical.html';
$i++;
//$modversion['blocks'][$i]['file'] = "icalendar_blocks.php";
//$modversion['blocks'][$i]['name'] = _MI_ICALENDAR_BNAME2;
//$modversion['blocks'][$i]['description'] = _MI_ICALENDAR_BNAME2_DESC;
//$modversion['blocks'][$i]['show_func'] = "bIcalendarSpotlightShow";
//$modversion['blocks'][$i]['options'] = "0|0|0|1|0";
//$modversion['blocks'][$i]['edit_func'] = "bIcalendarSpotlightEdit";
//$modversion['blocks'][$i]['template'] = 'icalendar_block_spotlight.html';
//$i++;
$modversion['blocks'][$i]['file'] = "icalendar_blocks.php";
$modversion['blocks'][$i]['name'] = _MI_ICALENDAR_BNAME3;
$modversion['blocks'][$i]['description'] = _MI_ICALENDAR_BNAME3_DESC;
$modversion['blocks'][$i]['show_func'] = "bIcalendarUpcomingShow";
$modversion['blocks'][$i]['options'] = "5|25|0";
$modversion['blocks'][$i]['edit_func'] = "bIcalendarUpcomingEdit";
$modversion['blocks'][$i]['template'] = 'icalendar_block_upcoming.html';
$i++;
$modversion['blocks'][$i]['file'] = "icalendar_blocks.php";
$modversion['blocks'][$i]['name'] = _MI_ICALENDAR_BNAME4;
$modversion['blocks'][$i]['description'] = _MI_ICALENDAR_BNAME4_DESC;
$modversion['blocks'][$i]['show_func'] = "bIcalendarDayShow";
$modversion['blocks'][$i]['options'] = "5|25|0";
$modversion['blocks'][$i]['edit_func'] = "bIcalendarDayEdit";
$modversion['blocks'][$i]['template'] = 'icalendar_block_day.html';
$i++;
$modversion['blocks'][$i]['file'] = "icalendar_blocks.php";
$modversion['blocks'][$i]['name'] = _MI_ICALENDAR_BNAME5;
$modversion['blocks'][$i]['description'] = _MI_ICALENDAR_BNAME5_DESC;
$modversion['blocks'][$i]['show_func'] = "bIcalendarNewShow";
$modversion['blocks'][$i]['options'] = "5|25|0";
$modversion['blocks'][$i]['edit_func'] = "bIcalendarNewEdit";
$modversion['blocks'][$i]['template'] = 'icalendar_block_new.html';
$i++;
$modversion['blocks'][$i]['file'] = "icalendar_blocks.php";
$modversion['blocks'][$i]['name'] = _MI_ICALENDAR_BNAME6;
$modversion['blocks'][$i]['description'] = _MI_ICALENDAR_BNAME6_DESC;
$modversion['blocks'][$i]['show_func'] = "bIcalendarRandomShow";
$modversion['blocks'][$i]['options'] = "5|25|0";
$modversion['blocks'][$i]['edit_func'] = "bIcalendarRandomEdit";
$modversion['blocks'][$i]['template'] = 'icalendar_block_random.html';
$i++;

// Notifications
$modversion['hasNotification'] = 1;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'icalendar_notify_iteminfo';

$modversion['notification']['category'][1]['name'] = 'global';
$modversion['notification']['category'][1]['title'] = _MI_ICALENDAR_GLOBAL_NOTIFY;
$modversion['notification']['category'][1]['description'] = _MI_ICALENDAR_GLOBAL_NOTIFYDSC;
$modversion['notification']['category'][1]['subscribe_from'] = '*';
$modversion['notification']['category'][1]['item_name'] = '';

$modversion['notification']['category'][2]['name'] = 'cat';
$modversion['notification']['category'][2]['title'] = _MI_ICALENDAR_CAT_NOTIFY;
$modversion['notification']['category'][2]['description'] = _MI_ICALENDAR_CAT_NOTIFYDSC;
$modversion['notification']['category'][2]['subscribe_from'] = array('calendar.php','year.php','day.php');
$modversion['notification']['category'][2]['item_name'] = 'cat';

$modversion['notification']['category'][3]['name'] = 'event';
$modversion['notification']['category'][3]['title'] = _MI_ICALENDAR_EVENT_NOTIFY;
$modversion['notification']['category'][3]['description'] = _MI_ICALENDAR_EVENT_NOTIFYDSC;
$modversion['notification']['category'][3]['subscribe_from'] = 'event.php';
$modversion['notification']['category'][3]['item_name'] = 'event';
$modversion['notification']['category'][3]['allow_bookmark'] = 1;

$modversion['notification']['event'][1]['name'] = 'new_event';
$modversion['notification']['event'][1]['category'] = 'global';
$modversion['notification']['event'][1]['title'] = _MI_ICALENDAR_NEW_EVENT_NOTIFY;
$modversion['notification']['event'][1]['caption'] = _MI_ICALENDAR_NEW_EVENT_NOTIFYCAP;
$modversion['notification']['event'][1]['description'] = _MI_ICALENDAR_NEW_EVENT_NOTIFYDSC;
$modversion['notification']['event'][1]['mail_template'] = 'global_new_event';
$modversion['notification']['event'][1]['mail_subject'] = _MI_ICALENDAR_NEW_EVENT_NOTIFYSBJ;

$modversion['notification']['event'][2]['name'] = 'new_event_pending';
$modversion['notification']['event'][2]['category'] = 'global';
$modversion['notification']['event'][2]['title'] = _MI_ICALENDAR_NEW_EVENT_PENDING_NOTIFY;
$modversion['notification']['event'][2]['caption'] = _MI_ICALENDAR_NEW_EVENT_PENDING_NOTIFYCAP;
$modversion['notification']['event'][2]['description'] = _MI_ICALENDAR_NEW_EVENT_PENDING_NOTIFYDSC;
$modversion['notification']['event'][2]['mail_template'] = 'global_new_event_pending';
$modversion['notification']['event'][2]['mail_subject'] = _MI_ICALENDAR_NEW_EVENT_PENDING_NOTIFYSBJ;
$modversion['notification']['event'][2]['admin_only'] = 1;

$modversion['notification']['event'][3]['name'] = 'new_event_cat';
$modversion['notification']['event'][3]['category'] = 'cat';
$modversion['notification']['event'][3]['title'] = _MI_ICALENDAR_NEW_EVENT_CAT_NOTIFY;
$modversion['notification']['event'][3]['caption'] = _MI_ICALENDAR_NEW_EVENT_CAT_NOTIFYCAP;
$modversion['notification']['event'][3]['description'] = _MI_ICALENDAR_NEW_EVENT_CAT_NOTIFYDSC;
$modversion['notification']['event'][3]['mail_template'] = 'cat_new_event';
$modversion['notification']['event'][3]['mail_subject'] = _MI_ICALENDAR_NEW_EVENT_CAT_NOTIFYSBJ;
?>