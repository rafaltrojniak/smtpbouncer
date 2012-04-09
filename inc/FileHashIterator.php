<?php
class FileHashIterator extends FilterIterator
{

	public function accept()
	{
		return parent::current()->isFile();
	}

}
