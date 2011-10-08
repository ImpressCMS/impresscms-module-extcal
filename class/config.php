<?php

if (!defined('ICMS_ROOT_PATH')) {
	die('ICMS root path not defined');
}

class ExtcalConfig {

	function &getHandler()
	{
		static $configHandler;
		if(!isset($configHandler[0])) {
			$configHandler[0] = new ExtcalConfig();
		}
		return $configHandler[0];
	}
	
	function getModuleConfig()
	{
		static $moduleConfig;
		$dirname = (isset(icms::$module) ? icms::$module->getVar('dirname') :'system');
		if($dirname == 'extcal') {
			$moduleConfig = icms::$module->config;
		} else {
			if(!isset($moduleConfig)) {
				$moduleHandler = icms::handler( 'icms_module' );
				$module = $moduleHandler->getByDirname('extcal');
				$config_handler = icms::$config;
				$moduleConfig = $config_handler->getConfigList($module->getVar('mid'));
			}
		}
		return $moduleConfig;
	}
}
?>