<?php
class message_orm
{
	protected $pdo_single;
// 	protected $function_single;
// 	protected $dict_single;
// 	protected $session_single;
// 	protected $constant_single;
	
	public function __construct()
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
	 * @param int $last_id
	 * @param string[] $message_datasets
	 */
	public function getMessageDatasetsByDamageCaseId($damage_case_id, $last_id){
		
		$results = $this->pdo_single->execAssoc('
				SELECT * 
				FROM message 
				WHERE damage_case_id = :dc_id 
				AND id > :last_id 
				ORDER BY ID DESC', 
				array('dc_id' => $damage_case_id, ':last_id' => $last_id));
		
		return $results;
	}

	
}
?>