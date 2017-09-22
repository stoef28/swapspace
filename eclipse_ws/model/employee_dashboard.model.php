<?php

class employee_dashboard_model extends model
{
	
	protected function init($params){
		
		$user = new damage_case(1);
		$user->login($user->getDamageCaseNr(), 'testpw');
		
		$_SESSION['last_message_id'] = 0;
		$_SESSION['employee_id'] = 1;
		
	}
	protected function createContent(){
	
			$dc_ide = $this->function_single->encrypt($this->session_single->getActiveUser()->getId(), 'damage_case_id');
		?>
		
		<div class="" id="chat_window">
			<div class="" id="message_container">
				<div class="chat_item received"></div>
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