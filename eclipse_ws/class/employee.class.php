<?php
class employee extends object
{
	private $characteristics = array(
			'id' 			=> array('value' => NULL, 'type' => ''),
			'first_name' 	=> array('value' => NULL, 'type' => ''),
			'last_name' 	=> array('value' => NULL, 'type' => ''),
			'e_nr' 			=> array('value' => NULL, 'type' => ''),
			'phone' 		=> array('value' => NULL, 'type' => ''),
			'created' 		=> array('value' => NULL, 'type' => 'date'),
			'last_login' 	=> array('value' => NULL, 'type' => 'date'),
			'deleted' 		=> array('value' => NULL, 'type' => 'date'),
			
	);
	
	
	public function init($id){
		
		$result = $this->pdo_single->getResult('SELECT * FROM employee WHERE id=:id', array(':id' => $id));
		
		if(!$result){
			return;
		}
				
		$this->setId($result['id']);
		$this->setCharacteristic('first_name', $result['first_name']);
		$this->setCharacteristic('last_name', $result['last_name']);
		$this->setCharacteristic('e_nr', $result['e_nr']);
		$this->setCharacteristic('phone', $result['phone']);
		$this->initCharacteristicDate('created', new DateTime($result['created']));
		$this->initCharacteristicDate('submitted', new DateTime($result['submitted']));
		$this->initCharacteristicDate('deleted', new DateTime($result['deleted']));
	}
	
	
	
	public function getName(){
		return $this->getCharacteristic('first_name').' '.$this->getCharacteristic('lats_name');
	}
	
}
?>