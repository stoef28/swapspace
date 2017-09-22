<?php

class dashboard_model extends model
{
	
	protected function init($params){
		
		unset($_SESSION['employee_id']);
		
	}
	protected function createContent(){
	
		$dc_ide = $this->function_single->encrypt($this->session_single->getActiveUser()->getId(), 'damage_case_id');
		?>
		
		<div class="show_chat" id="chat_window">
			<div class="" id="message_container">
				<div class="chat_item received">Wie kann ich Ihnen weiterhelfen?</div>
			</div>
			<input type="text" value="" name="chat_message" id="chat_message" /><button type="button" onclick="sendMessage('<?php echo $dc_ide; ?>');">Senden</button>
		</div>
		<script type="text/javascript">
		chat_is_running = true;
		</script>
		<?php 
		
	}
	
	
}
?>