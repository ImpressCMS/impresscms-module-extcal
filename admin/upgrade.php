<?php

if(isset($_POST['step'])) {
	$step = $_POST['step'];
} else {
	$step = 'default';
}

include '../../../include/cp_header.php';

// Change this variable if you use a cloned version of eXtGallery
$localModuleDir = 'icalendar';

$moduleName = 'icalendar';
$versionFile = 'http://www.zoullou.net/icalendar.version';
$downloadServer = 'http://downloads.sourceforge.net/zoullou/';

$lastVersion = @file_get_contents($versionFile);
$lastVersionString = substr($lastVersion,0,1).'.'.substr($lastVersion,1,1).'.'.substr($lastVersion,2,1);
$moduleFileName = $moduleName.'-'.$lastVersionString.'.tar.gz';
$langFileName = $moduleName.'-lang-'.$lastVersionString.'_'.$icmsConfig['language'].'.tar.gz';

switch($step) {

	case 'download':

		icms_cp_header();
		adminMenu();

		if(icms::$module->getVar('version') >= $lastVersion) {

			echo _AM_ICALENDAR_UPDATE_OK;
			icms_cp_footer();
			break;
		}

		if(!$handle = @fopen($downloadServer.$moduleFileName, 'r')) {
			printf(_AM_ICALENDAR_MD_FILE_DONT_EXIST, $downloadServer, $moduleFileName);
			icms_cp_footer();
			break;
		}
		$localHandle = @fopen(ICMS_ROOT_PATH.'/uploads/'.$moduleFileName, 'w+');

		// Downlad module archive
		if ($handle) {
		    while (!feof($handle)) {
		        $buffer = fread($handle, 8192);
		        fwrite($localHandle, $buffer);
		    }
		    fclose($localHandle);
		    fclose($handle);
		}

		// English file are included on module package
		if($icmsConfig['language'] != "english") {
			if(!$handle = @fopen($downloadServer.$langFileName, 'r')) {
				printf(_AM_ICALENDAR_LG_FILE_DONT_EXIST, $downloadServer, $langFileName);
			} else {
				$localHandle = @fopen(ICMS_ROOT_PATH.'/uploads/'.$langFileName, 'w+');
				// Download language archive
				if ($handle) {
				    while (!feof($handle)) {
				        $buffer = fread($handle, 8192);
				        fwrite($localHandle, $buffer);
				    }
				    fclose($localHandle);
				    fclose($handle);
				}
			}
		}

		icms_core_Message::confirm(array('step' => 'install'), 'upgrade.php', _AM_ICALENDAR_DOWN_DONE, _AM_ICALENDAR_INSTALL);

		icms_cp_footer();

		break;

	case 'install':

		icms_cp_header();
		adminMenu();

		if(!file_exists(ICMS_ROOT_PATH."/uploads/".$moduleFileName)) {

			echo _AM_ICALENDAR_MD_FILE_DONT_EXIST_SHORT;
			icms_cp_footer();

			break;
		}

		$g_pcltar_lib_dir = ICMS_ROOT_PATH.'/modules/'.$localModuleDir.'/class';
		include "../class/pcltar.lib.php";

		//TrOn(5);

		// Extract module files
		PclTarExtract(ICMS_ROOT_PATH."/uploads/".$moduleFileName,ICMS_ROOT_PATH."/modules/".$localModuleDir."/","modules/".$moduleName."/");
		// Delete downloaded module's files
		unlink(ICMS_ROOT_PATH."/uploads/".$moduleFileName);

		if(file_exists(ICMS_ROOT_PATH."/uploads/".$langFileName)) {
			// Extract language files
			PclTarExtract(ICMS_ROOT_PATH."/uploads/".$langFileName,ICMS_ROOT_PATH."/modules/".$localModuleDir."/","modules/".$moduleName."/");
			// Delete downloaded module's files
			unlink(ICMS_ROOT_PATH."/uploads/".$langFileName);
		}

		// Delete template_c file
		if ($handle = opendir(ICMS_ROOT_PATH.'/templates_c')) {

		    while (false !== ($file = readdir($handle))) {
		        if($file != '.' && $file != '..' && $file != 'index.html') {
					unlink(ICMS_ROOT_PATH.'/templates_c/'.$file);
				}
		    }

		    closedir($handle);
		}
		//TrDisplay();

		icms_core_Message::confirm(array('dirname' => $localModuleDir, 'op' => 'update_ok', 'fct' => 'modulesadmin'), ICMS_URL.'/modules/system/admin.php', _AM_ICALENDAR_INSTALL_DONE, _AM_ICALENDAR_UPDATE);

		icms_cp_footer();

		break;

	default:
	case 'default':

		redirect_header('index.php', 3, '');

		break;
}

?>