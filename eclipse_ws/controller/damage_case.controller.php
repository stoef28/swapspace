<?php
class damage_case_controller extends _main_controller
{
	protected function init()
	{
		
	}
	
	public function requestingAction($action) 
	{	
		if(!$this->session_single->isLoggedIn()){
			
			return array('page_name' => 'login');
		}
		return array('page_name' => $action); 
	}
	
}
?>