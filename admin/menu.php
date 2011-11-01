<?php

$admin_dirname = basename( dirname( dirname( __FILE__ ) ) );

global $icmsConfig;

$adminmenu[1]['title'] 	= _MI_EXTCAL_INDEX;
$adminmenu[1]['link']	= 'admin/index.php';
$adminmenu[1]['icon']	= 'images/admin/home_big.png'; // 32x32 px for options bar (tabs) 
$adminmenu[1]['small']	= 'images/admin/home_small.png'; // 16x16 px for drop down

$adminmenu[2]['title'] 	= _MI_EXTCAL_CATEGORY;
$adminmenu[2]['link']	= 'admin/cat.php';
$adminmenu[2]['icon']	= 'images/admin/categories_big.png';
$adminmenu[2]['small']	= 'images/admin/categories_small.png';

$adminmenu[3]['title'] 	= _MI_EXTCAL_EVENT;
$adminmenu[3]['link']	= 'admin/event.php';
$adminmenu[3]['icon']	= 'images/admin/event_big.png';
$adminmenu[3]['small']	= 'images/admin/event_small.png';

$adminmenu[4]['title'] 	= _MI_EXTCAL_PERMISSIONS;
$adminmenu[4]['link']	= 'admin/perm.php';
$adminmenu[4]['icon']	= 'images/admin/permissions_big.png';
$adminmenu[4]['small']	= 'images/admin/permissions_small.png';

//$adminmenu[5]['title'] 	= _MI_EXTCAL_PRUNING;
//$adminmenu[5]['link']	= 'admin/prune.php';
//$adminmenu[5]['icon']	= '';
//$adminmenu[5]['small']	= '';                

if ( isset( icms::$module ) ) {

	icms_loadLanguageFile( $admin_dirname, 'admin' );
	
	if ( file_exists( '../docs/' . $icmsConfig['language'] . '/readme.html') ) {
		$docs = '../docs/' . $icmsConfig['language'] . '/readme.html" target="_blank"'; 
	} elseif ( file_exists( '../docs/english/readme.html') ) { 
		$docs = '../docs/english/readme.html" target="_blank"'; 
	} else {
		$docs = '';
	}
	
	$module = icms::handler("icms_module")->getByDirname(basename(dirname(dirname(__FILE__))), TRUE);

	$i = -1;
	$i++;
	$headermenu[$i]['title'] = _AM_EXTCAL_GO_TO_MODULE;
	$headermenu[$i]['link']  = ICMS_URL . '/modules/' . $admin_dirname;
	$i++;
	$headermenu[$i]['title'] = _PREFERENCES;
	$headermenu[$i]['link']  = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $module -> getVar( 'mid' );
	$i++;
	$headermenu[$i]['title'] = _AM_EXTCAL_UPDATE;
	$headermenu[$i]['link']  = ICMS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=' . $admin_dirname;
	$i++;
	$headermenu[$i]['title'] = _MODABOUT_ABOUT;
	$headermenu[$i]['link']  = ICMS_URL . '/modules/' . $admin_dirname . '/admin/about.php';
}

?>
