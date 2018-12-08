<?php
namespace okaCTO;

class apiCTO
{
    public $text;
    private $token;

    /**
     *  $text - полученный текст запроса
     *  $token - false: токена нет или он не верный.
     */
    public function inputMessage()
    {

        //$text = implode("", file('php://input'));
        //$text = $text . '}';
        //echo var_dump($this->text);
        //echo var_dump('Обработка строки JSON');

        $this->token = false;
        $obj = json_decode($this->text, true);
        //$obj = $obj->{'vip'};
        //echo var_dump($obj);

        if ((empty($obj)) or (!is_array($obj))) {
            echo 'Ошибка в запросе или запрос пуст.';
            return; // Вернуть ответ с ошибкой
        }

        $count = count($obj);

        for ($i = 0; $i <> $count; $i++){
            //echo "\n";
            foreach ($obj[$i] as $key => $value){
                switch ($key) {
                    case 'token':
                        if($value == 'ut11-4_crm_cto'){
                            //echo '[ токен получен ] ' . $value . "\n";
                            $this->token = true;
                        }else{
                            echo '[ получен не верный токен ] ' . $value . "\n";
                            return;
                        }
                        break;
                    case 'command':
                        if ($this->token){
                            //echo '[ команда получена ] ' . $value . "\n";
                            return $this->commandProcessing($value);
                            break;
                        }
                }

            }
        }

    }

    /*
     * проверяем полученную в запросе команду.
     */
    private function commandProcessing($value){
        //echo '[ Команда ] ' . $value . "\n";
        switch ($value) {
            case 'getChangedTickets':
                $this->getChangedTickets();
                //return $value;
            case 'setChangedTickets':
                //$this->commandProcessing($value);
                break;
            case 'setNewTicket':
                $this->setNewTicket();
                break;
        }
    }

    /*
     * Запись нового тикета в базу из 1С
     */
    private function setNewTicket(){
        //$db = new dataBase();
        //$sql = 'SELECT * FROM zayavki WHERE ((vipolnil=1 AND vipolnilpc=0) OR (prinal=1 AND prinalpc=0))';
        //$arrTickets = $db->query($sql);
        echo '=|';
        //echo $arrTickets;
        echo '|=';
        //echo $strTickets = json_encode($arrTickets);
        //echo var_dump($strTickets);
    }

    /*
     * все тикеты не отосланные в 1С
     */
    private function getChangedTickets(){
        $db = new dataBase();
        $sql = 'SELECT * FROM zayavki WHERE ((vipolnil=1 AND vipolnilpc=0) OR (prinal=1 AND prinalpc=0))';
        $arrTickets = $db->query($sql);
        //echo '=|';
        //echo $arrTickets;
        //echo '|=';
        echo $strTickets = json_encode($arrTickets);
        //echo var_dump($strTickets);
    }
}
