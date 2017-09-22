<?php
class message_orm
{
	protected $pdo_single;
// 	protected $function_single;
// 	protected $dict_single;
// 	protected $session_single;
// 	protected $constant_single;
	
	public function __construct($id)
	{
		$this->pdo_single 		= pdo_singleton::getInstance();
// 		$this->function_single 	= function_singleton::getInstance();
// 		$this->dict_single 		= dict_singleton::getInstance();
// 		$this->session_single 	= session_singleton::getInstance();
// 		$this->constant_single 	= constant_singleton::getInstance();
	
	}
	
	/**
	 * 
	 * @param int $id
	 * @param string[] $message_datasets
	 */
	public function getMessageDatasetsByDamageCaseId($damage_case_id){
		
		$results = $this->pdo_single->getAssoc('message', array('where' => array('damage_case_id' => $damage_case_id)));
		
		return $results;
	}

	
}
?>