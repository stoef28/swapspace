<?php
class employee_orm
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
	 * @param int $damage_case_id
	 * @param my_doc[] $my_docs
	 */
	public function getMyDocsByDamageCaseId($damage_case_id){
		
		$results = $this->pdo_single->getAssoc('my_doc', array('where' => array('damage_case_id' => $damage_case_id)));
		
		$container = array();
		foreach($results as $dataset){
			
			$obj = new my_doc($dataset['id']);
			
			if($obj->getId()){
				$container[] = $obj;
			}
		}
				
		return $container;
	}

	
}
?>