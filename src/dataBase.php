<?php
namespace okaCTO;

class dataBase
{
	private $link;
	
	public function __construct()
	{
		$this->connect();
	}
	
	private function connect()
	{
		$config = require_once 'config.php';
		
		$connectString = 'mysql:dbname=' . $config['db_name'] . ';host=' . $config['host'] . ';charset=' . $config['charset'];
		$this->link = new \PDO($connectString, $config['username'], $config['password']);
		return $this;
	}
	
	public function execute($sql)
	{
		$sth = $this->link->prepare($sql);
		return $sth->execute();
	}
	
	public function query($sql)
	{
		$sth = $this->link->prepare($sql);
		$sth->execute();
		
		$result = $sth->fetchAll(\PDO::FETCH_ASSOC);
		
		if ($result === false){
			return[];
		}
		return $result;
	}
}
