<?php 

class constant_singleton 
{
	/* SINGLETON BASIC SET*/
	protected static $_instance;
	
	/**
	 * @return constant_singleton $constant_single
	 */
	public static function getInstance()
	{
		if (null === self::$_instance)
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	protected function __clone() {}
   
	protected function __construct() 
	{
		
		
	}
	/* END BASIC SET */
	
	public function getSurveyFilePath(){
		return 'files/surveys/';
	}
	
	public function getMyDocsFilePath(){
		return 'files/my_docs/';
	}
}


?>