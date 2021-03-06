<?php
class survey_orm
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
	 * @param survey[] $surveys
	 */
	public function getSurveyByDamageCaseId($damage_case_id){
		
		$result = $this->pdo_single->getResult('survey', array('where' => array('damage_case_id' => $damage_case_id)));
		
		if(!$result){
			$result = $this->pdo_single->getResult('damage_case', array('where' => array('id' => $damage_case_id)));
		}
		
		if($result){
			return new damage_case($result['id']);
		}
		
		return null;
	}

	
}
?>