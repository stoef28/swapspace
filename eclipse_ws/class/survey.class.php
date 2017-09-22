<?php
class survey extends object
{
	protected $characteristics = array(
			'id' 				=> array('value' => NULL, 'type' => ''),
			'status_id' 		=> array('value' => NULL, 'type' => ''),
			'survey_id'			=> array('value' => NULL, 'type' => ''), // if 0 it's the template itself
			'name' 				=> array('value' => NULL, 'type' => ''),
			'case_id' 			=> array('value' => NULL, 'type' => ''), // id des schadenfalls
			'created'	 		=> array('value' => NULL, 'type' => 'date'),
			'submitted'	 		=> array('value' => NULL, 'type' => 'date'),
// 			'altered' 			=> array('value' => NULL, 'type' => 'date'),
			'deleted' 			=> array('value' => NULL, 'type' => 'date'),
	);
	
	private $dom_doc = null;
	
	public function init($id){
		
		$result = $this->pdo_single->getResult('SELECT * FROM survey WHERE id=:id', array(':id' => $id));
		
		if(!$result){
			die('500'); // we have to use a template or edit an existing survey
		}
		
		// if we are a template, save as an answered survey with new id. don't change value of the template.
		if(!$result['survey_id']){
			$result['survey_id'] = $result['id'];
			$result['id'] = 0;
		}
		
		$this->setId($result['id']);
		$this->setCharacteristic('status_id', $result['status_id']);
		$this->setCharacteristic('survey_id', $result['survey_id']);
		$this->setCharacteristic('name', $result['name']);
		$this->setCharacteristic('case_id', $result['case_id']);
		$this->initCharacteristicDate('created', new DateTime($result['created']));
		$this->initCharacteristicDate('submitted', new DateTime($result['submitted']));
		$this->initCharacteristicDate('deleted', new DateTime($result['deleted']));

		$this->dom_doc = new DOMDocument();
		$this->dom_doc->load($this->getFilePath());
	}
	
	
	public function generateFormHtml(){

		$html = '';
		
		$survey = $this->dom_doc->getElementById('survey');
		foreach($surveys as $childnode){
			
		}
		
		return $html;
	}
	
	/**
	 * @return string[] $errors
	 */
	public function validateFormData(){
		
		$errors = array();
		
		return $errors;
	}
	
	public function save($submit=false){
		
		$successful = $this->dom_doc->save($this->getFilePath());
		
		if($successful){
			
			parent::save();
			
			if($submit){
				$this->pdo_single->setUpdate('UPDATE survey SET submitted=NOW() WHERE id=:id', array(':id' => $this->getId()));
				$this->initCharacteristicDate('submitted', new DateTime());
			}
		}
	
	}
	
	private function getFilePath(){
		return $this->constant_single->getSurveyFilePath() . $this->function_single->encrypt($this->getId(), 'survey_id') . '.xml';
	}
	
	protected function getTablename(){
		return 'survey';
	}
}
?>