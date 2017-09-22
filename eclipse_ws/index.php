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
	$regular_classes = array('singleton', 'controller', 'class', 'model', 'orm');
	
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
					
				case 'singleton':
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

$pdo_single 	= pdo_singleton::getInstance();
// $dict_single 	= dict_singleton::getInstance();

$requests = array(
		'login'						=> 'default',
		
		
		'dashboard'					=> 'damage_case',
		'file_upload'				=> 'damage_case',
		'survey'					=> 'damage_case',		
		'chat_messages'				=> 'damage_case',		
		'send_message'				=> 'damage_case',		
		
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
	}
	
	if(isset($requests[$page_name]))
	{
		$controller_name 	= $requests[$page_name];
		$requesting_page	= $page_name;
	}else
	{
		$controller_name 	= 'damage_case';
		$requesting_page 	= 'dashboard';
	}
}else 
{
	$controller_name 	= 'default';
	$requesting_page 	= 'login';
}


$session_single->setCoverRequest($cover_request);;
$session_single->setAjaxRequest($ajax_request);;

$controller_name 	.= '_controller';
$page_controller 	= new $controller_name(); 
$page_settings 		= $page_controller->requestingAction($requesting_page);
unset($page_controller);


$session_single->setPage($page_settings['page_name']);

// $dict_single->init($page_settings['page_name']);

$approved_page = $page_settings['page_name'] . '_model';

if(!isset($page_settings['page_params']))
{	$page_settings['page_params'] = array(); }

$my_page = new $approved_page($page_settings['page_params']);


if($cover_request)
{	$my_page->createCover(); }
else
{	$my_page->createPage(); }


?>


