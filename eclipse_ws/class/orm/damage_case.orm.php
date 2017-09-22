<?php
class damage_case_orm
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
	 * @param damage_case $dc_obj
	 */
	public function getDamageCaseById($id){
		
		$dc_obj = new damage_case($id);
		
		return $dc_obj;
	}

	/**
	 * 
	 * @param string $email
	 * @param damage_case $dc_obj
	 */
	public function getDamageCaseByEmail($email){
	
		$result = $this->pdo_single->getResult('damage_case', array('where' => array('email' => $email)));
	
		if($result){
			return new damage_case($result['id']);
		}
		return null;
	}
	
	
}
?>