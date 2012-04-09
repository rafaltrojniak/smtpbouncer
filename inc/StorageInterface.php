<?php
interface StorageInterface {
	/**
	* Returns open file handle for the token
	* @param string token Token name - make it unique
	* @returns stream Stream handle for the file opened in w mode
	**/
	public function getFileHandle($token);
}
