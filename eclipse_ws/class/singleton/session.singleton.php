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
		
		// old
		/*
		if(!isset($_SESSION['user']))
		{	self::resetGuest();	}
	
		if(!isset($_SESSION['status_reports']))
		{	$_SESSION['status_reports'] = array(); }
		*/
	}
	/* END BASIC SET */
	
	private $page;
	private $report_types 	= array('normal', 'success', 'warning', 'info', 'danger');
	private $cover_request	= false;
	private $ajax_request	= false;
	
	private $user_obj;
	
	private function resetGuest()
	{
// 		$_SESSION['user'] = array("user_id" => null,
// 				"type_short" => 'g',
// 				"type_long" => 'Guest',
// 				"first_name" => 'Guest',
// 				"last_name" => '',
// 				"email" => '',
// 				"birthdate" => '',
// 				"fk_company" => null,
// 				"fk_department" => 0,
// 				"fk_function" => 0,
// 				"company" => '-',
// 				"department" => '-',
// 				"function" => '-',
// 				"leader" => false
// 		);
		
		$_SESSION['survey'] = array(
				"started" 			=> 0,
				"finished_1" 		=> 0,
				"finished_2" 		=> 0,
				"finished_3" 		=> 0,
				"finished_4" 		=> 0,
				"finished_5" 		=> 0,
				"finished_6" 		=> 0,
				"finished_7" 		=> 0,
				"finished_8" 		=> 0,
				'submitted'			=> 0,
				'first_unfinished'	=> 1
		);
	}
		
	/**
	 * 
	 * @param array $data
	 * <ul><li>firsst_name => string</li>
	 * <li>first_name => string</li>
	 * <li>email => string</li>
	 * <li>birthdate => date</li>
	 * <li>fk_company => int</li>
	 * <li>department => string</li>
	 * <li>function => string</li>
	 * <li>leader => bool</li>
	 * <li>company_rep => bool. if true login as representive</li>
	 */
	/*
	public function loginByUserDataset($data) 
	{				
		$type_short = 'u';
		$type_long = 'User';
		if(isset($data['email']) && ($data['email'] == "baumgartnerbasil@gmail.com" || $data['email'] == "roger.schlaginhaufen@gmail.com"))
		{	
			$type_short = 'a';
			$type_long = 'Admin';
			
		}elseif(isset($data['company_rep']) && $data['company_rep'])
		{
			$type_short = 'r';
			$type_long = 'Representative';
		}

		$_SESSION['user'] = array("user_id" => $data['id'],
				"type_short" => $type_short,
				"type_long" => $type_long,
				"first_name" => $data["first_name"],
				"last_name" => $data["last_name"],
				"email" => $data["email"],
				"birthdate" => $data["birthdate"],
				"fk_company" => $data["fk_company"],
				"fk_department" => $data["fk_department"],
				"fk_function" => $data["fk_function"],
				"company" => $data["company"],
				"department" => $data["department"],
				"function" => $data["function"],
				"leader" => $data["leader"],
				"vacation" => $data["vacation"],
				"deactivated" => $data["deactivated"]
		);
		
	}
	*/
	
	/**
	 * 
	 * @param user $user_obj
	 */
	/*
	public function loginByUserObj(user $user) 
	{				
		$type_short = 'u';
		$type_long = 'User';
		if($user->getCharacteristic('email') == "baumgartnerbasil@gmail.com" || $user->getCharacteristic('email') == "roger.schlaginhaufen@gmail.com")
		{	
			$type_short = 'a';
			$type_long = 'Admin';
			
		}elseif($user->getCharacteristic('company_rep'))
		{
			$type_short = 'r';
			$type_long = 'Representative';
		}

		$_SESSION['user'] = array("user_id" => $user->getCharacteristic('id'),
				"type_short" => $type_short,
				"type_long" => $type_long,
				"first_name" => $user->getCharacteristic('first_name'),
				"last_name" => $user->getCharacteristic('last_name'),
				"email" => $user->getCharacteristic('email'),
				"birthdate" => $user->getCharacteristic('birthdate'),
				"fk_company" => $user->getCharacteristic('fk_company'),
				"fk_department" => $user->getCharacteristic('fk_department'),
				"fk_function" => $user->getCharacteristic('fk_function'),
				"company" => $user->getCharacteristic('company'),
				"company_since" => $user->getCharacteristic('company_since'),
				"department" => $user->getCharacteristic('department'),
				"function" => $user->getCharacteristic('function'),
				"function_since" => $user->getCharacteristic('function_since'),
				"leader" => $user->getCharacteristic('leader'),
				"vacation" => $user->getCharacteristic('vacation'),
				"deactivated" => $user->getCharacteristic('deactivated')
		);
		
	}
	*/
	
	public function setUserId($user_id)
	{	$_SESSION['user_id'] = $user_id; }
	
	public function login($email, $pw)
	{	$this->getActiveUser()->login($email, $pw); }
	
	public function logout()
	{	unset($_SESSION['user_id']); 
		$this->setUser();
	}
	
	/**
	 * @return user_v2 $user_v2_obj
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
				
		$user_orm 		= new user_orm();
		$user_obj 		= $user_orm->getUserById($user_id);
		$this->user_obj = $user_obj;
	}
	
	/*
	public function setSurveyByDataset($dataset)
	{
		if($dataset)
		{	
			$session_array = array(
					"started" 			=> 1,
					"finished_1" 		=> 0,
					"finished_2" 		=> 0,
					"finished_3" 		=> 0,
					"finished_4" 		=> 0,
					"finished_5" 		=> 0,
					"finished_6" 		=> 0,
					"finished_7" 		=> 0,
					"finished_8" 		=> 0,
					'submitted'			=> 0,
					'first_unfinished'	=> 1
			);
			
			// STEP 8
			if($dataset['s_7_1_status'] && $dataset['s_7_2_status'] && $dataset['s_7_3_status'])
			{	$session_array['finished_7'] 	= 1; 
				$session_array['first_unfinished'] = 8;
			}
			
			// STEP 7
			if($dataset['s_6_1_status'] && $dataset['s_6_2_status'] && $dataset['s_6_3_status'] && $dataset['s_6_4_status'] && $dataset['s_6_5_status'])
			{	$session_array['finished_6'] 	= 1;
				$session_array['first_unfinished'] = 8;
			}
			
			// STEP 6
			if($dataset['s_5_1_status'] && $dataset['s_5_2_status'] && $dataset['s_5_3_status'] && $dataset['s_5_4_status'])
			{	$session_array['finished_5'] 		= 1;
				$session_array['first_unfinished'] 	= 7;
			}
			
			// STEP 5
			if($dataset['s_4_1_status'] && $dataset['s_4_2_status'] && $dataset['s_4_3_status'] && $dataset['s_4_4_status'])
			{	$session_array['finished_5'] 		= 1;
				$session_array['first_unfinished'] 	= 6;
			}
			
			// STEP 4
			if($dataset['s_3_1_status'] && $dataset['s_3_2_status'] && $dataset['s_3_3_status'] && $dataset['s_3_4_status'] && $dataset['s_3_5_status'] && 
					$dataset['s_3_6_status'])
			{	$session_array['finished_4'] 		= 1; 
				$session_array['first_unfinished'] 	= 5;
			}
			
			// STEP 3
			if($dataset['s_2_7_status'] && $dataset['s_2_8_status'] && $dataset['s_2_9_status'] && $dataset['s_2_10_status'] && $dataset['s_2_11_status'] &&
					$dataset['s_2_12_status'])
			{	$session_array['finished_3'] 		= 1;
				$session_array['first_unfinished'] 	= 4;
			}
			
			// STEP 2
			if($dataset['s_2_1_status'] && $dataset['s_2_2_status'] && $dataset['s_2_3_status'] && $dataset['s_2_4_status'] && $dataset['s_2_5_status'] &&
					$dataset['s_2_6_status'])
			{	$session_array['finished_2'] 		= 1;
				$session_array['first_unfinished'] 	= 3;
			}
			
			// STEP 1
			if($dataset['s_1_1_status'] && $dataset['s_1_2_status'] && $dataset['s_1_3_status'] && $dataset['s_1_4_status'] && $dataset['s_1_5_status'] &&
					$dataset['s_1_6_status'] && $dataset['s_1_7_status'])
			{	$session_array['finished_1'] 		= 1;
				$session_array['first_unfinished'] 	= 2;
			}
			
			// SUBMITTED
			if($dataset['submitted'])
			{	$session_array['submitted'] = 1; }
			
			$_SESSION['survey'] = $session_array;
		}
	}
	*/
	
	public function hasStartedSurvey()
	{	return $_SESSION['survey']['started']; }
	
	public function hasFinishedSurveyPage($step_nr)
	{	return $_SESSION['finished_'.$page_nr]['started']; }
	
	public function getFirstUnfisnishedSurvey()
	{	return $_SESSION['survey']['first_unfinished']; }
		
	public function hasSubmittedSurvey()
	{	var_dump($_SESSION['survey']); return $_SESSION['survey']['submitted']; }
		
	/*
	public function isLoggedIn()
	{
		if(isset($_SESSION['user']))
		{	if($_SESSION['user']['type_short'] != 'g')
			{	return true; }
			else 
			{	return false; }
		}else 
		{ 	return null; }
	}
	
	public function isUser()
	{	return ($this->getTypeShort() == 'u' || $this->getTypeShort() == 'a'); }
	
	public function isRep()
	{	return ($this->getTypeShort() == 'r'); }
	
	public function isAdmin()
	{	return ($this->getTypeShort() == 'a'); }
	
	public function getUserData()
	{
		if(isset($_SESSION['user']))
		{	return $_SESSION['user']; }
		else
		{ 	return null; }
	}
	
	
	// wird in navi verwendet atm
	public function getUserItem($key)
	{
		if(isset($_SESSION['user'][$key]))
		{	return $_SESSION['user'][$key]; }
		else
		{ 	return null; }
	}
	
	public function setUserItem($key, $value)
	{
		if(isset($_SESSION['user'][$key]))
		{	return $_SESSION['user'][$key] = $value; }
		else
		{ 	return null; }
	}
	
	
	public function getPermissionLevel()
	{
		return $this->getTypeShort(); 
	}
	
	public function getTypeShort()
	{
		return $_SESSION['user']['type_short'];
	}
	
	public function getTypeLong()
	{
		return $_SESSION['user']['type_long']; 
	}
	
	public function getUserId()
	{
		return $_SESSION['user']['user_id'];
	}
	
	public function getCompanyId()
	{
		return $_SESSION['user']['fk_company'];
	}
	
	public function logout()
	{
		$this->resetGuest();
	}
	*/
	
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