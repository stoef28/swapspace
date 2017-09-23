<?php
class survey extends object
{
	protected $characteristics = array(
			'id' 				=> array('value' => NULL, 'type' => ''),
			'status_id' 		=> array('value' => NULL, 'type' => ''),
			'survey_id'			=> array('value' => NULL, 'type' => ''), // if 0 it's the template itself
			'name' 				=> array('value' => NULL, 'type' => ''),
			'damage_case_id'	=> array('value' => NULL, 'type' => ''), // id des schadenfalls
			'created'	 		=> array('value' => NULL, 'type' => 'date'),
			'submitted'	 		=> array('value' => NULL, 'type' => 'date'),
// 			'altered' 			=> array('value' => NULL, 'type' => 'date'),
			'deleted' 			=> array('value' => NULL, 'type' => 'date'),
	);
	
	private $dom_doc = null;
	static private $node_depth = 0;
	static private $question_counter = 1;
	
	public function init($id){
		
		$id = 1;
		
		$result = $this->pdo_single->getResult('survey', array('where' => array('id' => $id)));
		
		if(!$result){
			die('500'); // we have to use a template or edit an existing survey
		}
		
		$load_id = $result['id'];
		// if we are a template, save as an answered survey with new id. don't change value of the template.
		if(!$result['survey_id']){
			$result['survey_id'] = $result['id'];
			$result['id'] = 0;
		}
		
		$this->setId($result['id']);
		$this->setCharacteristic('status_id', $result['status_id']);
		$this->setCharacteristic('survey_id', $result['survey_id']);
		$this->setCharacteristic('name', $result['name']);
		$this->setCharacteristic('damage_case_id', $result['damage_case_id']);
		$this->initCharacteristicDate('created', new DateTime($result['created']));
		$this->initCharacteristicDate('submitted', new DateTime($result['submitted']));
		$this->initCharacteristicDate('deleted', new DateTime($result['deleted']));

		$this->dom_doc = new DOMDocument();
		
		$this->dom_doc->load($this->getFilePath($load_id));
	}
	
	
	public function generateFormHtml(){

		$html = '<form method="dashboard" action="post">';
		
		// doesn't work for some reason
// 		$survey = $this->dom_doc->getElementById('survey');

		// fix:
		$survey_array = $this->dom_doc->getElementsByTagName('survey');
		foreach($survey_array as $node){
			$survey = $node;
			break;				
		}
		
		$this->iterateDomDoc($survey, $html);
		
		$html .= '<button type="submit">Absenden</button></form>';
		return $html;
	}
	
	private function iterateDomDoc(DOMNode $mother_node, &$html){
		
		self::$node_depth++;
		
		if(!$mother_node->hasChildNodes()){
			return;
		}
		
		$mother_name = $this->getAttribute($mother_node, 'name');
		$mother_type = $this->getAttribute($mother_node, 'type');
		
	
		foreach($mother_node->childNodes as $child_node){
// 			var_dump($child_node->nodeName);
			
			if($child_node->nodeName == '#text' && trim($child_node->textContent) == ''){
				// ignore
			}else if($child_node->nodeName == 'container'){
				
				$hidden = $this->getAttribute($child_node, 'hidden');
				$id 	= $this->getAttribute($child_node, 'id');

				$html .= '<div id="'.$id.'" style="'.($hidden ? 'display: none;' : '').'">';
					$this->iterateDomDoc($child_node, $html);
				$html .= '</div>';
				
			}else if($child_node->nodeName == 'description'){
				$html .= '<div class="description">'.$child_node->textContent.'</div>';
				
			}else if($child_node->nodeName == 'question'){
				
				
				$this->iterateDomDoc($child_node, $html);
				
			}else if($child_node->nodeName == 'title'){				
				$html .= '<span class="title">'.(self::$node_depth == 3 ? self::$question_counter++.'. ' : '').$child_node->nodeValue.'</span><br>';
				
			}else if($child_node->nodeName == 'option'){	
				
				$has_toggle = $this->getAttribute($child_node, 'show');
				$toggle_string = '';
				
				if($has_toggle){
					$toggle_string = 'onchange="toggleDiv(this, \''.$has_toggle.'\', event);"';
				}
				
				$html .= '<input type="radio" value="" name="'.$mother_name.'" '.$toggle_string.'>&nbsp;'.$child_node->nodeValue.'</input>&nbsp;';

			}else if($child_node->nodeName == 'answer'){
				
				if($mother_type == 'textarea'){
					$html .= '<textarea>';
				}
				
				$html .= $child_node->nodeValue;
				
				if($mother_type == 'textarea'){
					$html .= '</textarea><br>';
				}
			}
			
			
		}
		
		self::$node_depth--;
	}
	
	private function getAttribute(DOMNode $node, $searching){
		foreach($node->attributes as $attribute){			
			if($attribute->name == $searching){
				return $attribute->value;
			}	
		}
		return '';
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
	
	private function getFilePath($id=''){
				
		if(!$id){
			$id = $this->getId();
		}
		
		$ide = $this->function_single->encrypt($id, 'survey_id');
		
		return $this->constant_single->getSurveyFilePath() . $ide . '.xml';
	}
	
	protected function getTablename(){
		return 'survey';
	}
}
?>