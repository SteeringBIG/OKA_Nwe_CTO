<?php
namespace okaCTO;

class dataBase
{
	private $link;
	public $arrInfoKKM;
	
	public function __construct()
	{
	    //echo 'Перед коннектом';
		$this->connect();
	}
	
	private function connect()
	{
		$config = require_once 'config.php';
		
		$connectString = 'mysql:dbname=' . $config['db_name'] . ';host=' . $config['host'] . ';charset=' . $config['charset'];
		$this->link = new \PDO($connectString, $config['username'], $config['password']);

		return $this;
	}

    /**
     * @param $allowed - массив с именами переменных для запроса
     * @param $values - значения переменных
     * @param array $source - массив с данными для запроса
     * @return bool|string - готовая строка с частью запроса с переменными
     */
    private function pdoSet($allowed, &$values, $source = array()) {
        $set = '';
        $values = array();
        if (!$source) $source = $this->arrInfoKKM;
        foreach ($allowed as $field) {
            if (isset($source[$field])) {
                $set.="`".str_replace("`","``",$field)."`". "=:$field, ";
                $values[$field] = $source[$field];
            }
        }
        return substr($set, 0, -2);
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

	public function insertInfoKKM($arrInfoKKM)
    {
        $this->arrInfoKKM = $arrInfoKKM;
        //echo 'Перед запросом в функуции = ' . var_dump($arrInfoKKM);

        $allowed = array("date_upd", "mex_code", "name_org", "inn", "kkm_model", "kkm_number",
            "kkm_sno", "kkm_firmware", "fn_size", "fn_protocol", "sub_firmware", "auto_upd_firmware", "groups_product"); // allowed fields

        $sql = "INSERT INTO kkm_info SET ".$this->pdoSet($allowed,$values);
        $sth= $this->link->prepare($sql);
        //echo '$values = ' . var_dump($values);
        $result = $sth->execute($values);

        if ($result === false){
            return[];
        }
        return $result;
    }

    public function updateInfoKKM($arrInfoKKM)
    {
        $this->arrInfoKKM = $arrInfoKKM;

        $allowed = array("date_upd", "mex_code", "name_org", "inn", "kkm_model", "kkm_number",
            "kkm_sno", "kkm_firmware", "fn_size", "fn_protocol", "sub_firmware", "auto_upd_firmware", "groups_product"); // allowed fields

        //$_POST['password'] = MD5($_POST['login'].$_POST['password']);
        $sql = "UPDATE users SET " . $this->pdoSet($allowed, $values) . " WHERE id = :kkm_number";
        $stm = $this->link->prepare($sql);
        $values["kkm_number"] = $_POST['id'];
        $stm->execute($values);
    }
}