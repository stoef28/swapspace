<?php
class damage_case extends object
{
	private $characteristics = array(
			'id' 			=> array('value' => NULL, 'type' => ''),
			'dc_nr' 		=> array('value' => NULL, 'type' => ''),
			'password' 		=> array('value' => NULL, 'type' => ''),
			'phone' 		=> array('value' => NULL, 'type' => ''),
			'first_name' 	=> array('value' => NULL, 'type' => ''),
			'last_name' 	=> array('value' => NULL, 'type' => ''),
			'email' 		=> array('value' => NULL, 'type' => ''),
			'state' 		=> array('value' => NULL, 'type' => ''),
			'responsible_id'=> array('value' => NULL, 'type' => ''),
			'survey_id' 	=> array('value' => NULL, 'type' => ''), // the selected survey for this damage case
			'created' 		=> array('value' => NULL, 'type' => 'date'),
			'last_login' 	=> array('value' => NULL, 'type' => 'date'),
			'deleted' 		=> array('value' => NULL, 'type' => 'date'),
			
	);
	
	
	public function init($id){
		
		$result = $this->pdo_single->getResult('SELECT * FROM damage_case WHERE id=:id', array(':id' => $id));
		
		if(!$result){
			return;
		}
				
		$this->setId($result['id']);
		$this->setCharacteristic('dc_nr', $result['dc_nr']);
		$this->setCharacteristic('password', $result['password']);
		$this->setCharacteristic('phone', $result['phone']);
		$this->setCharacteristic('first_name', $result['first_name']);
		$this->setCharacteristic('last_name', $result['last_name']);
		$this->setCharacteristic('email', $result['email']);
		$this->setCharacteristic('state', $result['state']);
		$this->setCharacteristic('responsible_id', $result['responsible_id']);
		$this->setCharacteristic('survey_id', $result['survey_id']);
		$this->initCharacteristicDate('created', new DateTime($result['created']));
		$this->initCharacteristicDate('submitted', new DateTime($result['submitted']));
		$this->initCharacteristicDate('deleted', new DateTime($result['deleted']));
	}
	
	/**
	 * 
	 * @param string $email
	 * @param string $password
	 * @param int $status - 0 => success, 1 => wrong email or pw
	 */
	public function login($email, $password){
		
		$damage_case_orm = new damage_case_orm();
		
		$dc_obj = $damage_case_orm->getDamageCaseByEmail($email);
		
		if($dc_obj){
			
			if($dc_obj->getPassword() == $password){
				return 1;
			}
		}
		return 0;
	}
	
	public function getDamageCaseNr(){
		return $this->getCharacteristic('dc_nr');
	}
	
	public function getName(){
		return $this->getCharacteristic('first_name').' '.$this->getCharacteristic('lats_name');
	}
	
	public function getEmail(){
		return $this->getCharacteristic('email');
	}
	
	public function getPassword(){
		return $this->getCharacteristic('password');
	}
	
	public function getState(){
		return $this->getCharacteristic('state');
	}
	
	public function getResponsibleId(){
		return $this->getCharacteristic('responsible_id');
	}
	
	public function getSurveyId(){
		return $this->getCharacteristic('survey_id');
	}
	
}
?>