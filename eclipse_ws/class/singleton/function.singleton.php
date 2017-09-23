<?php
// Owner:	Firmenradar GmbH
// Date: 	04.08.2016
// Version:	1.0
// Author:	Basil Baumgartner

/*
 * Change Log:
 * 
 *
 */

class function_singleton  
{	
	/* START SINGLETON BASIC SET */
	protected static $_instance;
	
	/**
	 * @return function_singleton $function_single
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
   
	protected function __construct() {}
	/* END SINGLETON BASIC SET */
	
// 	public function init($name){}
	
	private $user_date_array 		= array('delimiter' => '.', 'day' => '', 'month' => '', 'year' => '');
	private $user_date_format 		= 'd.m.Y';
	private $user_time_format 		= 'H:i:s';
	private $datepicker_date_format = 'm/d/Y';
	private $db_date_format 		= 'Y-m-d';
	private $db_time_format 		= 'H:i:s';
	
	public function getUserDateFormat()
	{	return $this->user_date_format; }
	public function getUserTimeFormat()
	{	return $this->user_time_format; }
	public function getUserDateAndTimeFormat()
	{	return $this->user_date_format.' '.$this->user_time_format; }
	
	public function getDatepickerDateFormat()
	{	return $this->datepicker_date_format; }
	public function getDbDateFormat()
	{	return $this->db_date_format; }
	public function getDbTimeFormat()
	{	return $this->db_time_format; }
	public function getDbDateAndTimeFormat()
	{	return $this->db_date_format.' '.$this->db_time_format; }
	
	public function convertUserDateToDbDate($input_date)
	{	return preg_replace($_SESSION['date_userformat_search'], $_SESSION['date_dbformat_replace'], $input_date); }
	
	public function convertUserDateToArray($input_date)
	{	$return_array = explode($this->user_date_array['delimiter'], $input_date);
		$i = 0;
		foreach($this->user_date_array as $key => $value) {
			if($key != 'delimiter') {
				$return_array[$key] = $return_array[$i];
				unset($return_array[$i]);
				$i++;
			}
		}
		return $return_array; 
	}
	
	public function convertDbDateToUserDate($input_date)
	{	return preg_replace($_SESSION['date_dbformat_search'], $_SESSION['date_userformat_replace'], $input_date); }
	
	
	public function createSessionId()
	{	return $this->getHash(microtime() . uniqid(mt_rand(), true)); }
	
	public function generateSalt()
	{	return rand(99,1000); }
	
	public function getSaltedHash($value, $salt)
	{	return $this->getHash($salt . $value. $salt); }
	
	public function encrypt($string, $cypher)
	{
		if (trim($string)=='') {die('encrypt error'); }	
		return str_replace('.', '_hdsp_', $this->urlsafe_b64encode($this->my_encode($string, $cypher))); 
	}
	
	public function decrypt($string, $cypher)
	{
		if (trim($string)=='') {die('dycrypt error'); }
		return $this->my_decode($this->urlsafe_b64decode(str_replace('_hdsp_', '.', $string)), $cypher);	
	}
	
	private function my_encode($string, $key) 
	{
		$key = $this->repairKeySize($key);
	  	$iv = md5('cUtmYfROGGiNTOpIECES');
	   	return mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $this->urlsafe_b64encode($string), MCRYPT_MODE_ECB, $iv); 
	}
	
	private function my_decode($string, $key) 
	{
		$key = $this->repairKeySize($key);
		$iv = md5('cUtmYfROGGiNTOpIECES');
	   	return $this->urlsafe_b64decode(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key,$string, MCRYPT_MODE_ECB, $iv)); 
	}
	
	private function repairKeySize($key)
	{
		if(strlen($key) < 33)
		{
			$key = str_pad($key, 32, "tHISiSmYlASTrESORT", STR_PAD_LEFT);
		}else
		{
			while(strlen($key) > 32)
			{	$key = substr($key, 1); }
		}
		return $key;
	}
	
	private function urlsafe_b64encode($string)
	{	return str_replace(array('+','/','='),array('.','_','-'),base64_encode($string)); }
	
	private function urlsafe_b64decode($data) 
	{
		$data = str_replace(array('.','_','-'),array('+','/','='),$data);
		$mod4 = strlen($data) % 4;
		if ($mod4)
		{  	$data .= substr('====', $mod4); }
	  	return base64_decode($data);
	}
	
	private function getHash($value) 
	{	return hash("sha256", hash("sha1", $value)); }
	
	
	/* STATIC FUNCTIONS */
	
	public static function cutString($string, $cut_after_x_chars){
		
		$pure_string 	= html_entity_decode($string);
		$string_array 	= explode(' ', $pure_string);
		
		$return_string 	= '';
		$length_counter = 0;
		foreach($string_array as $string_part){
			
			$length_counter += strlen($string_part);
			
			if($length_counter > $cut_after_x_chars){
				break;
			}
			
			$return_string .= ' '.$string_part;
		}
		
		return htmlentities($return_string);
	}
}	

?>