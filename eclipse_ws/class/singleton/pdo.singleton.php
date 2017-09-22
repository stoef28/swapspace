<?php


class pdo_singleton extends PDO
{
	/* SINGLETON BASIC SET*/
	protected static $_instance;
	
	/**
	 * @return pdo_singleton $pdo_single
	 */
	public static function getInstance()
	{
		if (null === self::$_instance)
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	protected function __clone() {}
   
	public function __construct() 
	{
// 		parent::__construct('mysql:host='.$host.';dbname='.$db, $username, $pw, $driver_options);

		if(strpos($_SERVER['SERVER_NAME'], 'localhost') === false)
		{	
			parent::__construct('mysql:host=localhost:3306;dbname=swapspace;charset=utf8', 'root', '');
// 			$this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);	
// 			$this->query("set character set utf8;");
		}
		else
		{ 	
			parent::__construct('mysql:host=localhost;dbname=swapspace;charset=utf8', 'root', '');
// 			$this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
// 			$this->query("set character set utf8;");
		}
	}
	/* END BASIC SET */
		
	
	private $action_params_allowed = array('select' => array('select', 'where', 'limit', 'order_by', 'params', 'join'),
			'insert' => array('insert', 'params', 'where'),
			'update' => array('update', 'where', 'params'),
			'delete' => array('where', 'params')
	);
	
	private $action_params_required = array('select' => array(),
			'insert' => array('insert'),
			'update' => array('update', 'where'),
			'delete' => array('where')
	);
	
	private $index = 0;
		
	
	/**
	 * 
	 * @param string $sql
	 * @param array $params
	 * @return array $results
	 */
	public function execAssoc($sql, $params=array())
	{
		try {
			$stmt = $this->prepare($sql);
			$stmt->execute($params);
			
			$return = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			return $return;
		}
		catch (Exception $e) {
			throw new Exception(
					__METHOD__ . 'Exception Raised for sql: ' . var_export($sql, true) .
					' Params: ' . var_export($params, true) .
					' Error_Info: ' . var_export($this->errorInfo(), true),
					0,
					$e);
		}
		return false;
	}
	
	/**
	 * 
	 * @param string $table
	 * @param array $params [optional]
	 * @throws Exception
	 * @return string[] $datasets
	 */
	public function getAssoc($table, $params=array())
	{
		$data = $this->buildSql($table, 'select', $params);
						
		return $this->execAssoc($data['sql'], $data['params']);
	}
	
	
	public function getResult($table, $params=array())
	{	
		$datasets = $this->getAssoc($table, $params);
		if(isset($datasets[0]))
		{	return $datasets[0]; }
		return NULL;
	}
	
	
	public function setInsert($table, $params=array())
	{	
		$data = $this->buildSql($table, 'insert', $params);
	
		try {
			$stmt = $this->prepare($data['sql']);
			$stmt->execute($data['params']);
			return $this->lastInsertId();
		}
		catch (Exception $e) {
			throw new Exception(
					__METHOD__ . 'Exception Raised for sql: ' . var_export($sql_string, true) .
					' Params: ' . var_export($params, true) .
					' Error_Info: ' . var_export($this->errorInfo(), true),
					0,
					$e);
		}
		return false;
	}
	
	public function execUpdate($sql, $params=array())
	{
		try {
			$stmt = $this->prepare($sql);
			$stmt->execute($params);
			return true;
		}
		catch (Exception $e) {
			throw new Exception(
					__METHOD__ . 'Exception Raised for sql: ' . var_export($sql_string, true) .
					' Params: ' . var_export($params, true) .
					' Error_Info: ' . var_export($this->errorInfo(), true),
					0,
					$e);
		}
		return false;
	}
	
	
	public function setUpdate($table, $params=array())
	{
		$data = $this->buildSql($table, 'update', $params);
		return $this->execUpdate($data['sql'], $data['params']);
	}
	
	
	public function setDelete($table, $params=array())
	{
		$data = $this->buildSql($table, 'delete', $params);
					
		try	{
			$stmt = $this->prepare($data['sql']);
			$stmt->execute($data['params']);
			return true;
		}
		catch (Exception $e) {
			throw new Exception(
					__METHOD__ . 'Exception Raised for sql: ' . var_export($table, true) .
					' Params: ' . var_export($params, true) .
					' Error_Info: ' . var_export($this->errorInfo(), true),
					0,
					$e);
		}
		return false;
	}
	
	private function validateParams($action, $params)
	{
		foreach($this->action_params_required[$action] as $required_item)
		{	if(!isset($params[$required_item]))
		{	return false; }
		}
	
		foreach($params as $key => $value)
		{
			if(!in_array($key, $this->action_params_allowed[$action]))
			{	return false; }
		}
		return true;
	}
	
	/**
	 *
	 * @param string $table
	 * @param string $action
	 * @param [optional] array $params - valid keys: 'select', 'insert', 'update', 'where', 'order_by', 'limit'
	 * @param array ['sql' => string, 'params' => array]
	 */
	public function buildSql($table, $action, $params=array())
	{
		if(in_array($action, array('select', 'insert', 'update', 'delete')))
		{
			$action_string = strtoupper($action).' ';
			if($action == 'select' && !isset($params['select']))
			{	$action_string .= '* FROM '.$table.' '; }
			elseif($action == 'delete')
			{	$action_string .= 'FROM '.$table.' '; }
		}
		else
		{	die('pdo1'); }
	
		if(!$this->validateParams($action, $params))
		{	var_dump($action);
			var_dump($params);
			die('pdo2'); 
		}
	
	
		$where_string 		= '';
		$join_string 		= '';
		$order_by_string 	= '';
		$limit_string 		= '';
		$sql_string 		= '';
		$prepared_params 	= array();
	
		foreach($params as $key => $value)
		{
			switch($key)
			{
				// SELECT
				case 'select':
					$action_string .= $value.' FROM '.$table.' ';
						
						
					break;
					// INSERT
				case 'insert':
					$into_string 	= '';
					$value_string 	= '';
						
					foreach($value as $col_name => $col_value)
					{	$i = $this->getIndex();
	
						$into_string 					.= $col_name.', ';
						$value_string 					.= ':param'.$i.', ';
						$prepared_params[':param'.$i]	= $col_value;
					}
						
					if($into_string == '' || $value_string == '')
					{	die('rp3'); }
						
					$into_string	= substr($into_string, 	0, strlen($into_string)-2);
					$value_string	= substr($value_string, 0, strlen($value_string)-2);
						
					$action_string .= 'INTO '.$table.' ('.$into_string.') VALUES('.$value_string.')';
						
						
					break;
					// UPDATE
				case 'update':
					$set_string = '';
						
					foreach($value as $col_name => $col_value)
					{	
						if(strtoupper($col_value) == 'NOW()')
						{	$set_string 					.= $col_name.'=NOW(), '; }
						elseif(gettype($col_name) == 'int')
						{	$set_string .= $col_value.', '; }
						else 
						{
							$i = $this->getIndex();
	
							$set_string 					.= $col_name.'=:param'.$i.', ';
							$prepared_params[':param'.$i]	= $col_value;
						}				
					}
						
					if($set_string == '')
					{	die('rp4'); }
						
					$set_string	= substr($set_string, 	0, strlen($set_string)-2);
	
					$action_string .= $table.' SET '.$set_string;
	
						
					break;
					// WHERE
				case 'join':
					if(gettype($value) == 'string')
					{	$join_string = ' '.$value; }
					elseif(gettype($value) == 'array')
					{
						foreach($value as $join_data)
						{
							die('help');
						}
					}
					
					
					break;
				case 'where':
					if(gettype($value) == 'string')
					{	$where_string = ' WHERE '.$value; }
					elseif(gettype($value) == 'array')
					{
						$where_string 	= ' WHERE ';
						$addon 			= '';
						foreach($value as $col_name => $col_value)
						{
							if($col_name == 'addon')
							{	$addon = $col_value; }
							else
							{
								$i 								= $this->getIndex();
								
								if(strlen($col_name) > 3 && strtolower(substr($col_name, 0, 3)) == 'or ')
								{	$where_string 				= substr($where_string, 0, strlen($where_string)-4).'OR '; // replace 'AND ' with 'OR '
									$col_name 					= substr($col_name, 3);	
								}
									
								$where_string 					.= $col_name . '=' . ':param'.($i); 
								$prepared_params[':param'.($i)] = $col_value;
								$where_string 					.= ' AND ';
							}
						}
	
						if($addon && $where_string == ' WHERE ')
						{	$where_string = ' WHERE '.$addon; }
						elseif($addon && $where_string != ' WHERE ')
						{	$where_string .= $addon; }
						else
						{	$where_string = substr($where_string, 0, strlen($where_string)-4); }
	
					}
						
					break;
					// ORDER BY
				case 'order_by':
					if(gettype($value) == 'string')
					{	$order_by_string = ' ORDER BY '.$value.' '; }
					elseif(gettype($value) == 'array')
					{
						$order_by_string 	= ' ORDER BY ';
						$i 					= $this->getIndex();
						$addon 				= '';
						foreach($value as $value_i => $order_data)
						{
							if(gettype($order_data) == 'string')
							{	$order_by_string .= $order_data;
								if(substr(strtoupper($order_data), -3) != 'ASC' && substr(strtoupper($order_data), -4) != 'DESC')
								{	$order_by_string .= ' ASC'; }
							}
							elseif(gettype($order_data) == 'array')
							{
								$order_by_string .= $order_data[0].' ';
	
								if(isset($order_data[1]))
								{	$order_by_string .= $order_data[1]; }
								else
								{	$order_by_string .= 'ASC'; }
							}
							$order_by_string .= ', ';
						}
	
						if($order_by_string == ' ORDER BY ')
						{	$order_by_string = ''; }
						else
						{	$order_by_string = substr($order_by_string, 0, strlen($order_by_string)-2); }
	
					}
						
					break;
					// LIMIT
				case 'limit':
					if(gettype($value) == 'integer')
					{	$limit_string .= ' LIMIT '.$params['limit']; }
					elseif(gettype($value) == 'array')
					{
						$limit_string .= ' LIMIT '.$params['limit'][0];
						if(isset($params['limit'][1]))
						{	$limit_string .= ' OFFSET '.$params['limit'][1]; }
					}
						
						
					break;
				case 'params':
					$prepared_params = array_merge($prepared_params, $value);
						
					break;
			}
	
		}
	
		$sql_string = $action_string . $join_string . $where_string . $order_by_string . $limit_string;
	
		return array('sql' => $sql_string, 'params' => $prepared_params);
	}
	
	private function getIndex()
	{	return $this->index++; }
	
}

?>