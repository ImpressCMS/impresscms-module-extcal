<?php
/**
* Calendar - a calendar and events management module for ImpressCMS
*
* Based upon eXtCal 2.22
*
* File: download_attachment.php
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

if(!isset($_GET['file'])) {
	$fileId = 0;
} else {
	$fileId = intval($_GET['file']);
}

$fileHandler = icms_getModuleHandler('file', 'extcal');

$file = $fileHandler->getFile($fileId);

header("Content-Type: ".$file->getVar('file_mimetype')."");
header("Content-Disposition: attachment; filename=\"".$file->getVar('file_name')."\"");

readfile(ICMS_ROOT_PATH.'/uploads/extcal/'.$file->getVar('file_name'));
?>