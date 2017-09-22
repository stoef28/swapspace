<?php 

class session_singleton 
{
	/* SINGLETON BASIC SET*/
	protected static $_instance;
	
	/**
	 * @return session_singleton $session_single
	 */
	public static function getInstance()
	{
		if (null === self::$_instance)
		{
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}

	protected function __clone() {}
   
	protected function __construct() 
	{

		if(!isset($_SESSION['user_id']))
		{	self::resetGuest();	}
	
	}
	/* END BASIC SET */
	
	private $page;
	private $report_types 	= array('normal', 'success', 'warning', 'info', 'danger');
	private $cover_request	= false;
	private $ajax_request	= false;
	
	private $user_obj;
	
	private function resetGuest()
	{		
	}
		
	
	
	/**
	 * @return damage_case $damage_case
	 */
	public function getActiveUser()
	{	if(!$this->user_obj)
		{	$this->setUser(); }
	
		return $this->user_obj; 
	}

	private function setUser()
	{
		$user_id = 0;
		if(isset($_SESSION['user_id']))
		{	$user_id = $_SESSION['user_id']; }
				
		$this->user_obj = new damage_case($user_id);
	}
	
	public function isLoggedIn(){
		return ($this->getActiveUser()->getId());
	}
	
	public function hasStartedSurvey()
	{	return $_SESSION['survey']['started']; }
	
	public function hasFinishedSurveyPage($step_nr)
	{	return $_SESSION['finished_'.$page_nr]['started']; }
	
	public function getFirstUnfisnishedSurvey()
	{	return $_SESSION['survey']['first_unfinished']; }
		
	public function hasSubmittedSurvey()
	{	var_dump($_SESSION['survey']); return $_SESSION['survey']['submitted']; }
		
	
	/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
_ _ _ _ _ _ _ _ _ _ PAGE _ _ _ _ _ */
	public function setCoverRequest($is_cover)
	{	$this->cover_request = $is_cover; }
	
	public function isCoverRequest()
	{	return $this->cover_request; }
	
	public function setAjaxRequest($is_ajax)
	{	$this->ajax_request = $is_ajax; }
	
	public function isAjaxRequest()
	{	return $this->ajax_request; }
	
	public function setPage($page)
	{	$this->page = $page; }
	
	/**
	 * returns the effective pagename, not the called page.
	 * @return string $page
	 */
	public function getPage()
	{	return $this->page; }
	
	/**
	 * Returns the get string without page. Example: index&user_id=123 => &user_id=123
	 * @return string $get_string;
	 */
	public function getGetString()
	{	
		$get_array = $_GET;
		unset($get_array['page']);
		$get_string = '';
		foreach($get_array as $key => $value)
		{	$get_string .= '&'.$key.'='.$value; }
		
		return $get_string;	
	}
	
	public function redirectTo($page_name)
	{	die('<script language="JavaScript">window.location="'.$page_name.'";</script>'); }
	
	public function reloadPage()
	{	die('<script language="JavaScript">location.reload();</script>'); }
	
	
	/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
_ _ _ _ _ _ _ _ _ _ REPORTING _ _ _ _ _ */
	public function addStatusReport($string, $type = '')
	{	
		$type = ($type == 'error' ? 'danger' : $type);
		
		if(!in_array($type, $this->report_types))
		{	$type = 'normal'; }
		
		if(!isset($this->reports[$type]))
		{	$_SESSION['status_reports'][$type] = array(); }
		
		$_SESSION['status_reports'][$type][] = $string;
	}
	
	public function addErrorStatusReport($string)
	{	$this->addStatusReport($string, 'danger'); }
	
	public function addDangerStatusReport($string)
	{	$this->addStatusReport($string, 'danger'); }
	
	
	public function addSuccessStatusReport($string)
	{	$this->addStatusReport($string, 'success'); }
	
	public function addInfoStatusReport($string)
	{	$this->addStatusReport($string, 'info'); }
	
	public function addWarningStatusReport($string)
	{	$this->addStatusReport($string, 'warning'); }
	
	
	public function getStatusReports()
	{	$status_reports = (isset($_SESSION['status_reports']) ? $_SESSION['status_reports'] : array());
		$_SESSION['status_reports'] = array();
		return $status_reports;
	}
	
	public function hasErrorStatusReports()
	{	return (isset($_SESSION['status_reports']['danger']) && $_SESSION['status_reports']['danger'] ? true : false); }
	
}


?>