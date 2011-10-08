<?php


if (!defined("ICMS_ROOT_PATH")) {
	die("ICMS root path not defined");
}

include_once ICMS_ROOT_PATH.'/modules/'.icms::$module->getVar('dirname').'/class/ExtcalPersistableObjectHandler.php';
include_once ICMS_ROOT_PATH.'/class/uploader.php';

class ExtcalFile extends icms_core_Object {

	function ExtcalFile()
	{
		$this->initVar('file_id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('file_name', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('file_nicename', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('file_mimetype', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('file_size', XOBJ_DTYPE_INT, null, false);
		$this->initVar('file_download', XOBJ_DTYPE_INT, null, false);
		$this->initVar('file_date', XOBJ_DTYPE_INT, null, false);
		$this->initVar('file_approved', XOBJ_DTYPE_INT, null, false);
		$this->initVar('event_id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('uid', XOBJ_DTYPE_INT, null, false);
	}

}

class ExtcalFileHandler extends ExtcalPersistableObjectHandler {

	function ExtcalFileHandler(&$db)
	{
		$this->ExtcalPersistableObjectHandler($db, 'extcal_file', 'ExtcalFile', 'file_id');
	}

	function createFile($eventId) {

		$userId = (icms::$user) ? icms::$user->getVar('uid') : 0;

		$allowedMimeType = array();
		$mimeType = icms_Utils::mimetypes();
		foreach(icms::$module->config['allowed_file_extention'] as $fileExt) {
			$allowedMimeType[] = $mimeType[$fileExt];
		}

		$uploader = new icms_file_MediaUploadHandler(ICMS_ROOT_PATH.'/uploads/calendar', $allowedMimeType, 3145728);
		$uploader->setPrefix($userId.'-'.$eventId.'_');
		if ($uploader->fetchMedia('event_file')) {
			if (!$uploader->upload()) {
				return false;
			}
		} else {
			return false;
		}

		$data = array(
						'file_name'=>$uploader->getSavedFileName(),
						'file_nicename'=>$uploader->getMediaName(),
						'file_mimetype'=>$uploader->getMediaType(),
						'file_size'=>$_FILES['event_file']['size'],
						'file_date'=>time(),
						'file_approved'=>1,
						'event_id'=>$eventId,
						'uid'=>$userId
					);

		$file = $this->create();
		$file->setVars($data);
		return $this->insert($file);
	}

	function deleteFile(&$file) {
		$this->_deleteFile($file);
		$this->delete($file->getVar('file_id'));
	}

	function getEventFiles($eventId) {
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item('file_approved',1));
		$criteria->add(new icms_db_criteria_Item('event_id',$eventId));

		return $this->getObjects($criteria);
	}

	function updateEventFile($eventId) {
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item('file_approved',1));
		$criteria->add(new icms_db_criteria_Item('event_id',$eventId));

		if(isset($_POST['filetokeep'])) {
			if(is_array($_POST['filetokeep'])){
				$count = count($_POST['filetokeep']);
				$in = '('.$_POST['filetokeep'][0];
				array_shift($_POST['filetokeep']);
				foreach($_POST['filetokeep'] as $elmt) {
					$in .= ','.$elmt;
				}
				$in .= ')';
			} else {
				$in = '('.$_POST['filetokeep'].')';
			}
			$criteria->add(new icms_db_criteria_Item('file_id', $in, 'NOT IN'));
		}

		$files = $this->getObjects($criteria);
		foreach($files as $file) {
			$this->deleteFile($file);
		}
	}

	function getFile($fileId) {
		return $this->get($fileId);
	}

	function formatFilesSize(&$files) {
		for($i=0;$i<count($files);$i++) {
			$this->formatFileSize($files[$i]);
		}
	}

	function formatFileSize(&$file) {
		if($file['file_size'] > 1000) {
			$file['formated_file_size'] = round($file['file_size']/1000)."kb";
		} else {
			$file['formated_file_size'] = "1kb";
		}
	}

	function _deleteFile(&$file) {
		if(file_exists(ICMS_ROOT_PATH.'/uploads/calendar/'.$file->getVar('file_name')))
			unlink(ICMS_ROOT_PATH.'/uploads/calendar/'.$file->getVar('file_name'));
	}
}
?>