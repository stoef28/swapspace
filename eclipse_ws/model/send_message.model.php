<?php

class send_message_model extends model
{
	
	protected function init($params){
		
		if(isset($_POST['text']) && isset($_POST['dc_ide']) && isset($_POST['e_ide']) && isset($_POST['is_inbox'])){
			
			$e_id 		= $this->function_single->decrypt($_POST['e_ide'], 'employee_id');
			$dc_id 		= $this->function_single->decrypt($_POST['dc_ide'], 'damage_case_id');
			$is_inbox 	= $this->function_single->decrypt($_POST['is_inbox'], 'is_inbox');
			$text	 	= $_POST['text'];
			
			$this->pdo_single->setInsert('message', array('insert' => array(
					'employee_id' => $e_id,
					'damage_case_id' => $dc_id,
					'is_inbox' => $is_inbox,
					'text' => $text
					)));
			
		}
	}
	protected function createContent(){
	
	}
	
	
}
?>