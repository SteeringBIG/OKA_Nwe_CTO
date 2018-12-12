<?php
namespace okaCTO;

class dataBase
{
	private $link;
	public $arrInfoKKM;
	
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

	public function insertInfoKKM()
    {
        $sql = "INSERT INTO kkm_info (date_upd, mex_code, name_org, inn, kkm_model, kkm_number, 
                                          kkm_sno, kkm_firmware, fn_size, fn_protocol, sub_firmware, auto_upd_firmware, groups_product)
					VALUES (
						:date_upd,
						:mexcod,
						:name_org,
						:inn,
						:kkm_model,
						:kkm_number,
						:kkm_sno,
						:kkm_firmware,
						:fn_size,
						:fn_protocol,
						:sub_firmware,
						:auto_upd_firmware,
						:groups_product
						)";

        $sth= $this->link->prepare($sql);
        $result = $sth->execute($this->arrInfoKKM);

        if ($result === false){
            return[];
        }
        return $result;
    }
}