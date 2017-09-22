<?php

// Date: 	06.06.2016
// Version:	0.2
// Author:	Basil Baumgartner

class dict_singleton  
{	
	/* START SINGLETON BASIC SET */
	protected static $_instance;
	
	public static function getInstance()
	{	
		if (null === self::$_instance)
		{
			self::$_instance = new self();
		}
		return self::$_instance;
		
	}

	protected function __clone() {}
   
	protected function __construct() {$this->init();}
	/* END SINGLETON BASIC SET */
	
	// permission: g=guest, u=user, r=rep, a=admin
	// filename => array('title' => string, 'permission' => string, 'show_navi' => boolean)
	private $dict= array(); // is used t display text
	private $lang= array();
	private $default_lang = 'de';
	private $edit_dict = array(); // is used for editing dict entries
	private $editable_dicts = array('faq', 'agb', 'impressum');	
	
	public function init($name='')
	{
		if(isset($_COOKIE['lang']))
		{	$this->lang = $_COOKIE['lang']; }
		else 
		{	setcookie('lang', 'de', time()+(60*60*24*30));
			$this->lang = $this->default_lang;
		}
				
		if(empty($this->dict))
		{
			require('local/'.$this->lang.'/basic_dict.php');
			$this->dict = $dict;
		}
		
		if($name)
		{	$filepath = 'local/'.$this->lang.'/'. $this->convertDictfilename($name, true);
			$dict = $this->getDictByPath($filepath);
			
			if($dict)
			{	$this->dict = array_merge ($this->dict, $dict); }
			else
			{
				die('Tried to open Dict with unknown name "'.$name.'"!');
				/*
 				$f_handle = fopen('local/'.$this->lang.'/'. $this->convertDictfilename($name, true), 'w');
 				fwrite($f_handle, '<?php' . "\r\n" . '$dict = array(' . "\r\n" . ');' . "\r\n" . '?>');
 				fclose($f_handle);
 				*/
			}
		}
		// var_dump($_COOKIE);
	}
	
	public function dict($keyword)
	{		
		if(isset($this->dict[$keyword]))
		{	return $this->dict[$keyword]; }
		else 
		{ /* platzhalter instanzieren ?? */ die('Dictionary-Entry "'.$keyword.'" is missing!'); }
	}
	
	/**
	 * dict entry with Upper Case First Letter. 
	 * @param string $keyword
	 */
	public function dictUCF($keyword)
	{
		if(isset($this->dict[$keyword]))
		{	return ucfirst($this->dict[$keyword]); }
		else 
		{ /* platzhalter instanzieren ?? */ die('Dictionary-Entry "'.$keyword.'" is missing!'); }
	}
	
	public function getDictnames()
	{
		$names = array();
		if ($handle = opendir('local/'.$this->lang)) 
		{
	 		while(false !== ($entry = readdir($handle))) 
	 		{	if($entry != '.' && $entry != '..')
	 			{	$names[] = $this->convertDictfilename($entry); }
	 		}
		}
		return $names;
	}
	
	public function isEditable($dictname)
	{	return in_array($dictname, $this->editable_dicts); }
	
	public function getEditableDictnames()
	{
		$names = array();
		if ($handle = opendir('local/'.$this->lang)) 
		{
	 		while(false !== ($entry = readdir($handle))) 
	 		{	if($entry != '.' && $entry != '..' && in_array(str_replace('_dict.php', '', $entry), $this->editable_dicts))
	 			{	$names[] = $this->convertDictfilename($entry); }
	 		}
		}
		return $names;
	}
	
	public function getLangs()
	{
		$langs = array();
		if ($handle = opendir('local'))
		{
			while($entry = readdir($handle)) 
	 		{	if($entry != '.' && $entry != '..')
				{	$langs[] = $this->convertDictfilename($entry); }
			}
		}
		return $langs;
	}

	public function getDictArrayByName($name, $lang = false)
	{
		if(!$lang)
		{	$lang = $this->default_lang; }
		
		$filepath = 'local/'.$lang.'/'. $this->convertDictfilename($name, true);
		
		$dict = $this->getDictByPath($filepath);
		
		if($dict !== null)
		{	return $dict; }
		else
		{ 	return null; }
	}
	
	public function updateDictByPost($type='default')
	{
		
		
		$this->loadEditDict($_POST['dict_name']);
		if($type == 'level_2')
		{	$this->edit_dict = array(); }
		
		foreach($_POST as $keyword => $value)
		{
			$legal_param = false;
			if($type == 'level_2' && isset($_POST['dict_name']) && in_array($_POST['dict_name'], $this->editable_dicts))
			{
				if(!in_array($keyword, array('submit', 'unnamed', 'dict_name')))
				{	$legal_param = true;  }
				
			}elseif(isset($this->edit_dict[$_POST['dict_name']][$keyword]))
			{	$legal_param = true; }
						
			if($legal_param)
			{	$this->edit_dict[$_POST['dict_name']][$keyword] = $value; }
		}
		$this->saveEditedDict();
		$session_obj = session_singleton::getInstance();
		$session_obj->addSuccessStatusReport("Changes were saved!");
	}
	
// 	public function addTitle()
// 	{
// 		if(isset($_GET['dict_name']))
// 		{
// 			self::loadEditDict($_GET['dict_name']);
// 			self::$edit_dict[$_GET['dict_name']]['title'] = '';
// 		}else 
// 		{
// 			// baumg: to do report
// 		}
// 	}
	
// 	public function addSubtitle()
// 	{
// 		if(isset($_GET['dict_name']))
// 		{
// 			self::loadEditDict($_GET['dict_name']);
// 		}else
// 		{
// 			// baumg: to do report
// 		}
// 	}
	
// 	public function addText()
// 	{
// 		if(isset($_GET['dict_name']))
// 		{
// 			self::loadEditDict($_GET['dict_name']);
// 		}else
// 		{
// 			// baumg: to do report
// 		}
// 	}

	private function saveEditedDict()
	{
		foreach($this->edit_dict as $name => $dict) // edit_dict sollte nur einen eintrag haben
		{
			$dict_String = $this->getArrayAsString($dict);
			
			$f_handle = fopen('local/'.$this->lang.'/'. $this->convertDictfilename($name, true), 'w');
			fwrite($f_handle, '<?php' . "\r\n" . $dict_String . "\r\n" . '?>');
			fclose($f_handle);
		}
	}
	
	private function loadEditDict($name)
	{
		$filepath = 'local/'.$this->lang.'/'. $this->convertDictfilename($name, true);
		$dict = $this->getDictByPath($filepath);

		if($dict)
		{
// 			self::$edit_dict[$name] = $dict;
			$this->edit_dict = array($name => $dict);
		}
	}
	
	private function convertDictfilename($filename, $inverted = false)
	{
		if(!$inverted)
		{	return str_replace('_dict.php', '', $filename); }
		else 
		{	return $filename.'_dict.php'; }
	}
	
	
	
	private function getDictByPath($path)
	{
		if(file_exists($path))
		{
			require($path);
			return $dict;
		}
			
		return null;		
	}
	
	private function getArrayAsString($array)
 	{
		$trace = debug_backtrace();
	
		$vLine = file( __FILE__ );
 		$fLine = $vLine[ $trace[0]['line'] - 1 ];
 		preg_match( "/getArrayAsString\((.*)\);/", $fLine, $match );
		
		$string = "";
 		foreach($array as $key => $value)
 		{	$string .= "'" . $key . "' => '" . $value . "',\r\n"; }
	
		$string = $match[1] . " = array(\r\n" . substr($string, 0, -3) . "\r\n);";
	
		return $string;
	}
}	

?>