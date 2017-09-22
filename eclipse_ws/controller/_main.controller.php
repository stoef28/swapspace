<?php 

abstract class _main_controller
{
	
	protected $pdo_single;
// 	protected $dict_single;
	protected $session_single;
	protected $function_single;
	protected $constant_single;
	
	public function __construct()
	{
		$this->pdo_single 		= pdo_singleton::getInstance();
// 		$this->dict_single 		= dict_singleton::getInstance();
		$this->session_single 	= session_singleton::getInstance();
		$this->function_single 	= function_singleton::getInstance();
		$this->constant_single 	= constant_singleton::getInstance();
		
		if(isset($_POST['submit']) && $_POST['submit'] == 'login' && isset($_POST['email']) && isset($_POST['pw']))
		{	
			$this->session_single->login($_POST['email'], $_POST['pw']);
// 			$userObj = new user_class();
// 			$status = $userObj->loginByPost();
		}
		
		if(isset($_POST['submit']) && $_POST['submit'] == 'logout')
		{	
			$this->session_single->logout();
// 			$this->session_single->logout(); 
// 			$this->session_single->addSuccessStatusReport('DICT Sie wurden erfolgreich ausgeloggt.');
		}
		
		$this->init();
	}
	
	abstract protected function init();
	
	abstract public function requestingAction($page);
//	{ 	return page }

	
	protected function redirectTo($page)
	{
		die('<script language="JavaScript">window.location="'.$page.'";</script>');
	}
	
}
?>