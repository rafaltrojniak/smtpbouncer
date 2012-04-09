<?php
require_once(dirname(__FILE__).'/StorageInterface.php');
class FileHash implements StorageInterface {
	private $parentDir;
	private $hashLength=2;
	function setConfig($config){
		$this->parentDir=$config->parentDir;
		$this->hashLength=$config->hashLength;
	}
	/**
	* Returns open file handle for the token
	* @param string token Token name - make it unique
	* @returns stream Stream handle for the file opened in w mode
	**/
	public function getFileHandle($token){
		$hash=substr(sha1($token),0,$this->hashLength);
		$dirName=$this->parentDir.'/'.$hash;
		if(!is_dir($dirName)){
			if(!mkdir($dirName)){
				syslog(LOG_CRIT,"Cannot create new directory $dirName");
				exit();
			}
		}
		$fileName=$dirName."/".$token;
		$fileHandle=fopen($fileName,'w');
		if($fileHandle===false){
			syslog(LOG_CRIT,"Cannot open new file $fileName");
			exit();
		}
		flock($out);
		return $fileHandle;

	}
}
