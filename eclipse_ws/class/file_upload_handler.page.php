<?php

class file_upload_handler_page extends _main_page
{	
	protected function init($params)
	{		
		// file_upload_handler requires:
		// $_SESSION['file_upload_multiple'] => bool, default=false
		// $_SESSION['file_upload_path']
		// $_SESSION['file_upload_type']
		// $_SESSION['file_upload_token']
		// $_GET['file_upload_token']
		
		
// 		$this->title = $this->dict_single->dict('contact_title');
		$this->title = '';
								
		if(
// 				isset($_GET['file_upload_token']) && 
				isset($_SESSION['file_upload_path']) 
				&& isset($_SESSION['file_upload_type']) 
// 				&& $_SESSION['file_upload_token'] == $_GET['file_upload_token']
		)
		{
			
			$type_library 	= $this->constant_single->library('file_upload_type');
			$accepted_types = $type_library[$_SESSION['file_upload_type']];
			$uploaddir 		= $_SESSION['file_upload_path'];
				
			$error = '';
			$files = array();
					
			$filestypes_ok = true;
			foreach($_FILES as $file)
			{
				$type_allowed = false;
				foreach($accepted_types as $filetype)
				{	if(strpos($file['type'], '/'.$filetype) !== FALSE)
					{$type_allowed = true; break; }					
				}
				
				if(!$type_allowed)
				{	$filestypes_ok = false; }
				
				if(!isset($_SESSION['file_upload_multiple']) || !$_SESSION['file_upload_multiple'])
				{	break; }
			}
			
			if($filestypes_ok)
			{ 	
				foreach($_FILES as $file)
				{	
					if(!file_exists($uploaddir.basename($file['name'])))
					{						
						if(move_uploaded_file($file['tmp_name'], $uploaddir .basename($file['name'])))
						{
							$files[] = $file['name'];
						}
						else
						{	$error = 'DICT Error: There was an error uploading your files'; }
						
						if(!isset($_SESSION['file_upload_multiple']) || !$_SESSION['file_upload_multiple'])
						{	break; }
					}else 
					{
						$error = 'DICT Error: Es existiert bereits eine Datei mit diesem Namen.';
					}
				}
			}else 
			{
				// todo baumg: message ausgeben
				// filetype is not allowed
				$error = 'DICT Error: Dateitype nicht erlaubt.';
			}
			
			
			
			if(!$error)
			{	unset($_SESSION['file_upload_path']);
				unset($_SESSION['file_upload_token']);
				unset($_SESSION['file_upload_type']);
			}
						
			$data = ($error) ? array('error' => $error) : array('files' => $files);
			die(json_encode($data));
		}
		
		die(''); 
	}
	
	protected function createContent()
	{
		
	}
	
	
}