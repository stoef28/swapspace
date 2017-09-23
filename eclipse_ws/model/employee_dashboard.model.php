<?php

class employee_dashboard_model extends model
{
	
	protected function init($params){
		
		$this->showChat();
		
		$user = new damage_case(1);
		$user->login($user->getDamageCaseNr(), 'testpw');
		
		$_SESSION['last_message_id'] = 0;
		$_SESSION['employee_id'] = 1;
		
	}
	protected function createContent(){
	 
	}
	
	
}
?>