<?php

class chat_messages_model extends model
{
	
	protected function init($params){
		
		$last_id = (isset($_SESSION['last_message_id']) ? $_SESSION['last_message_id'] : 0);
		
		$user = $this->session_single->getActiveUser();
				
		$message_orm = new message_orm();
		$messages = $message_orm->getMessageDatasetsByDamageCaseId($user->getId(), $last_id);
			
		$is_customer = !(isset($_SESSION['employee_id']) && $_SESSION['employee_id']);
		$inverted 	= $is_customer;
	
		/*
		if($is_customer): ?>
		<div class="<?php echo ($is_inbox ? 'left' : 'right'); ?>">
				<span>Haben Sie Fragen, kann ich Ihnen helfen?</span>
		</div>
		<?php endif;
		*/
		
		foreach(array_reverse($messages) as $dataset){
			
			$is_inbox =  ($inverted ? !$dataset['is_inbox'] : $dataset['is_inbox']); 
			?>
			<div class="<?php echo ($is_inbox ? 'left' : 'right'); ?>">
				<span><?php echo $dataset['text']?></span>
			</div>
			<?php 
			$_SESSION['last_message_id'] = $dataset['id'];
		}
	}
	
	protected function createContent(){
	
	}
	
	
}
?>