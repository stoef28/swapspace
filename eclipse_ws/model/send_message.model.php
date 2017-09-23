<?php

class send_message_model extends model
{
	
	protected function init($params){
		
		if(isset($_POST['text']) && isset($_POST['dc_ide'])){
			
			$dc_id 		= $this->function_single->decrypt($_POST['dc_ide'], 'damage_case_id');
			
			$damage_case_obj = new damage_case($dc_id);
			$e_id = $damage_case_obj->getResponsibleId();
			
			$is_inbox 	= (isset($_SESSION['employee_id']) && $_SESSION['employee_id']);
			$text	 	= $_POST['text'];
						
			$success = $this->pdo_single->setInsert('message', array('insert' => array(
					'employee_id' => $e_id,
					'damage_case_id' => $dc_id,
					'is_inbox' => $is_inbox,
					'text' => $text
					)));
			
			die($success);
			
		}
	}
	protected function createContent(){
	
	}
	
	
}
?>