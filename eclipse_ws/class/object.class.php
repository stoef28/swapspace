<?php
abstract class object
{
	protected $deletable = true;
	protected $characteristics = array();
	// entries: array('value' => string, 'db_operations' => boolean, 'type' => string)
	// types: '', 'date', 'datetime'
	
	protected $pdo_single;
	protected $function_single;
// 	protected $dict_single;
	protected $session_single;
	protected $constant_single;


	public function __construct($id)
	{
		$this->pdo_single 		= pdo_singleton::getInstance();
		$this->function_single 	= function_singleton::getInstance();
// 		$this->dict_single 		= dict_singleton::getInstance();
		$this->session_single 	= session_singleton::getInstance();
		$this->constant_single 	= constant_singleton::getInstance();

		if($id != 0)
		{	$this->init($id); }

	}

	abstract protected function init($id);

	public function save()
	{		
		$params = array();
		
		foreach($this->characteristics as $key => $dataset) {
			if(!$dataset['db_operations']) {
				continue;
				
			} else if($dataset['type'] == 'date') {
				if($date = $this->getCharacteristicDate($key, $this->function_single->getDbDateFormat())) {	
					$params[$key] = $date; 
				}
			} else if($dataset['type'] == 'datetime') {
				if($date = $this->getCharacteristicDate($key, $this->function_single->getDbDateAndTimeFormat())) {	
					$params[$key] = $date; 
				}
			} else if($key != 'id' && $dataset['value'] !== null) {	
				$params[$key] = $dataset['value'];
			}
		}
		
		// UPDATE
	 	if($this->getId()) {
	 		
	 		$this->pdo_single->setUpdate($this->getTablename(), array('update' => $params, 'where' => array('id' => $this->getId())));
	 		
	 	// INSERT
	 	} else {
	 		
	 		$id = $this->pdo_single->setInsert($this->getTablename(), array('insert' => $params));
	 		
	 		$this->init($id);
	 	}
	}
	
	protected function setId($id) {
		$this->characteristics['id']['value'] = $id;
	}
	public function getId() {
		return $this->characteristics['id']['value'];
	}
	
	
	
	protected function setCharacteristic($key, $value)
	{
		if(isset($this->characteristics[$key]))
		{	$this->characteristics[$key]['value'] = $value; }
	}
	protected function getCharacteristic($key)
	{
		if(isset($this->characteristics[$key]))
		{	return $this->characteristics[$key]['value']; }
		return NULL;
	}

	
	
	protected function initCharacteristicDate($key, DateTime $datetime)
	{		
		if(!isset($this->characteristics[$key]['value']))
		{	$this->characteristics[$key]['value'] = $datetime; }		
	}
	protected function setCharacteristicDate($key, $day, $month, $year)
	{
		if(isset($this->characteristics[$key]['value']))
		{	$this->characteristics[$key]['value']->setDate($year, $month, $day); }
		else
		{	$this->characteristics[$key]['value'] = new DateTime($year.'.'.$month.'.'.$day); }
	}
	
	/**
	 * 
	 * @param string $key
	 * @param [optional] $format
	 * @return string $value
	 */
	protected function getCharacteristicDate($key, $format='')
	{
		if($format == '' && $this->characteristics[$key]['type'] == 'datetime')
		{	$format = $this->function_single->getUserDateAndTimeFormat(); }
		else if($format == '' && $this->characteristics[$key]['type'] == 'date')
		{	$format = $this->function_single->getUserDateFormat(); }
			
		if(isset($this->characteristics[$key]['value']))
		{	return $this->characteristics[$key]['value']->format($format); }
		return false;
	}
	

	
	protected function delete()
	{	
		if($this->deletable)
		{	$this->pdo_single->setUpdate('company', array('where' => array('id' => $this->getId()), 'update' => array('deleted' => 1)));
			$this->setCharacteristic('deleted', 1);
		}
	}
	
	abstract protected function getTablename();
	
}

