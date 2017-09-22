<?php
class default_controller extends _main_controller
{
	protected function init()
	{
		
	}
	
	public function requestingAction($action) 
	{	
		
		return array('page_name' => $action); 
	}
	
}
?>