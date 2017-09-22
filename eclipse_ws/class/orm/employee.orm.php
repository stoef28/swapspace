<?php
class employee_orm
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
	 * @param employee $e_obj
	 */
	public function getEmployeeById($id){
		
		$dc_obj = new employee($id);
		
		return $dc_obj;
	}
	
	
}
?>