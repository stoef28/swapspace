<?php

class survey_model extends model
{
	private $survey_obj;
	
	protected function init($params)
	{		
		if(isset($_GET['survey_ide'])){
			$survey_ide = $_GET['survey_ide'];
			
		}elseif(isset($_POST['survey_ide'])){
			$survey_ide = $_POST['survey_ide'];
			
		}else{
			die('<script type="text/javascript">window.location = "dashboard";</script>');
		}
		
		$survey_id = $this->function_single->decrypt($survey_ide, 'survey_id');
		
		$survey_obj = new survey($survey_id);
		$this->survey_obj = $survey_obj;
	}
	
	protected function createContent()
	{	
		echo '<div style="text-align: justify">';
		echo $this->survey_obj->generateFormHtml();
		echo '</div>';
	}
	
	
}
?>