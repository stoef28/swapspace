<?php

header('Content-Type: text/html; charset=utf-8');
// echo "<br>internal encoding: ".mb_internal_encoding();
mb_internal_encoding('UTF-8');
// echo "<br>internal encoding: ".mb_internal_encoding().'<br>';

session_start();
error_reporting(-1);
// var_dump($_SESSION);
// var_dump($_POST);
// var_dump($_GET);
// var_dump($_SERVER);

$_SESSION['date_format'] 	= "dd.mm.yy";
$_SESSION['date_regex'] 	= "/[0-9]{1,2}[\/\-\.][0-9]{1,2}[\/\-\.][0-9]{4}/";

$_SESSION['date_userformat_search'] 	= "/([0-9]{1,2})[\/\-\.]([0-9]{1,2})[\/\-\.]([0-9]{4})/";
$_SESSION['date_dbformat_replace'] 		= "$3-$2-$1";
$_SESSION['date_dbformat_search'] 		= "/([0-9]{4})[\/\-\.]([0-9]{1,2})[\/\-\.]([0-9]{1,2})/";
$_SESSION['date_userformat_replace'] 	= "$3.$2.$1";

function __autoload($class_name)
{
	$regular_classes = array('singleton', 'controller', 'page', 'class', 'template', 'module', 'orm');
	
	foreach($regular_classes as $identifier)
	{	
		if(substr($class_name, -(strlen($identifier)+1)) == '_'.$identifier)
		{	
			$path = '';
			
			switch($identifier)
			{
// 				case 'template':
// 					$path = 'page/template/';
// 					break;
					
// 				case 'module':
// 					$path = 'class/module/';
// 					break;
					
				case 'orm':
					$path = 'class/orm/';
					break;
					
				case 'signleton':
					$path = 'class/singleton/';
					break;
					
				default:
					$path = $identifier;
					break;
			}
			
			include $path.'/'.str_replace('_'.$identifier, '.'.$identifier, $class_name) . '.php'; 
			return;
		} 
	}
	
	include 'class/' . $class_name . '.class.php';
	
//	if(file_exists('class/'.$class_name . '.class.php'))
//	{	include 'class/'.$class_name . '.class.php'; }
//	else
//	{	die("error: index.php: __autload(): unknown class '".$class_name."' / file couldn't be found 'class/".$class_name . ".class.php'"); }
}

foreach($_POST as $key => $post_item)
{
	$_POST[$key] = htmlspecialchars(trim($post_item));
}


$session_single = session_singleton::getInstance();

$pdo_single = pdo_singleton::getInstance();
// if(strpos($_SERVER['SERVER_NAME'], 'localhost') === false)
// {	$pdo_single->init('localhost:3306', 	'firmenradar'	, 'php'		, '12php4ME!'); }
// else 
// { 	$pdo_single->init('localhost', 		'firmenradar'	, 'root'	, ''); }

$dict_single = dict_singleton::getInstance();

$requests = array(
		'login'						=> 'default',
		
		
		'damage_case'				=> 'damage_case',
		'file_upload'				=> 'damage_case',
		'survey'					=> 'damage_case',
		
		// offline pages
		'welcome' 					=> 'default',
		'about_team'				=> 'default',
		'launch_phases'				=> 'default',
		'agb' 						=> 'default',
		'faq' 						=> 'default',	// editable dict
		'impressum' 				=> 'default',	// editable dict
		'contact'	 				=> 'default',	// editable dict
		
		'file_upload_handler'		=> 'default',
		'active_dropdown'			=> 'default',
		'verify_email' 				=> 'login',
		'login' 					=> 'login',
		'blog_overview' 			=> 'blog',
		'blog_entry'				=> 'blog',
		'blog_entry_edit'			=> 'blog',
		'user_profile'				=> 'user',
		'image_gallery'				=> 'admin',
		'register'					=> 'register',
		
		'manage_locals_overview'	=> 'admin',
		'manage_locals'				=> 'admin',
		'edit_dropdowns_overview'	=> 'admin',
		'edit_dropdowns'			=> 'admin',
		'report_overview'			=> 'admin',
		'report_entry'				=> 'admin',
		'report_entry_create'		=> 'admin',
		'company_search'			=> 'admin',
		'company_edit'				=> 'admin',
		'company_show'				=> 'admin',
		
		
		'survey_overview'			=> 'survey',
		'survey_start'				=> 'survey',
		'survey'					=> 'survey',
		'survey_end'				=> 'survey',
		
		'csv_parser'				=> 'default',
		
		'city_select_json'			=> 'default',
		
		// active dropdowns
		'search_city'				=> 'default',
		
);


$cover_request 	= false;
$ajax_request 	= false;
if(isset($_GET['page']))
{
	$page_name = $_GET['page'];
	if(substr($_GET['page'], strlen($_GET['page'])-6) == '_cover')
	{	$page_name = substr($_GET['page'], 0, strlen($_GET['page'])-6); 
		$cover_request 	= true;
	
	}elseif(substr($_GET['page'], strlen($_GET['page'])-5) == '_ajax')
	{	$page_name = substr($_GET['page'], 0, strlen($_GET['page'])-5); 
		$ajax_request 	= true;
		
	}elseif(substr($_GET['page'], strlen($_GET['page'])-5) == '_json')
	{	$ajax_request 	= true;
	
	}else 
	{
// 		var_dump($page_name);
// 		var_dump($_POST);
	}
	
	if(isset($requests[$page_name]))
	{
		$controller_name 	= $requests[$page_name];
		$requesting_page	= $page_name;
	}else
	{
		$controller_name 	= 'user';
		$requesting_page 	= 'user_home';
	}
}else 
{
	$controller_name 	= 'default';
	$requesting_page 	= 'welcome';
}

// var_dump($controller_name);
// var_dump($requesting_page);
// var_dump($page_name);
// var_dump($cover_request);
// var_dump($ajax_request);
// die("ASDF");

$session_single->setCoverRequest($cover_request);;
$session_single->setAjaxRequest($ajax_request);;

// var_dump($session_single->getUserData());
// var_dump($requesting_page);

$controller_name 	.= '_controller';
$page_controller 	= new $controller_name(); 
$page_settings 		= $page_controller->requestingAction($requesting_page);
unset($page_controller);

// var_dump($page_settings);
// var_dump($page_settings);

$session_single->setPage($page_settings['page_name']);

// $dict_single->init($page_settings['page_name']);

$approved_page = $page_settings['page_name'] . '_page';

if(!isset($page_settings['page_params']))
{	$page_settings['page_params'] = array(); }

// die($approved_page);
$my_page = new $approved_page($page_settings['page_params']);


if($cover_request)
{	$my_page->createCover(); }
else
{	$my_page->createPage(); }


?>


