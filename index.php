<?php
session_start(); //Начинаем сессию
require 'vendor/autoload.php';

use okaCTO\main;
use okaCTO\dataBase;
use okaCTO\apiCTO;

date_default_timezone_set('Asia/Barnaul');
$main = new main();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
//echo $uri;
if ('/' === $uri) {

	$main->showHome();
	
} elseif ('/app' === $uri) {
    if (empty($_GET['mexcod'])) {
        $main->showHome();
        return;
    } else {
        $db = new dataBase();
        $mexcod = $_GET['mexcod']; // код механника
        $_SESSION['mexcod'] = $mexcod;
    }

    if (!empty($_GET['action']))
    {
        $action = $_GET['action']; // Команда для выполнения

        //Показать историю заявок в диапазоне дат
        if ($action === 'showHistoryTicket')
        {
            if (empty($_GET['dateTo']))
            {
                $dateTo = date('ymd');
            } else {
                $dateTo = date('ymd', $main->getData($_GET['dateTo']));
            };

            if (empty($_GET['dateFrom']))
            {
                $dateFrom = date('ym01');
            } else {
                $dateFrom = date('ymd', $main->getData($_GET['dateFrom']));
            };

            $sql = 'SELECT * FROM zayavki 
                    WHERE mexcod=' . $mexcod . ' 
                        AND vipolnil=1 
                        AND datasort<=' . $dateTo . ' 
                        AND datasort>=' . $dateFrom . ' 
                    ORDER BY idz DESC';

            //echo $sql;
            $main->showHistory($db->query($sql));
            return;
        }
	
        //Главная страница информации по ККМ
	    if ($action === 'startInfoKKM')
	    {
	        $main->showInfoKKM($_GET);
		    return;
	    }
	    
	    //Добавить информацию по ККМ
	    if ($action === 'getInfoKKM')
	    {
		    $sql = 'SELECT * FROM kkm_info WHERE kkm_number=' . $_GET['kkm_number'];
		    $info = $db->query($sql);
		    if (!empty($info))
            {
                $info = array_merge($main->arr_info_kkm, $info[0]);
            }else{
                $info = $main->arr_info_kkm;
            }

		    $info['action'] = 'getInfoKKM';
		    $info['kkm_number'] = $_GET['kkm_number'];

            if ((!empty($info['kkm_sno'])) AND (!empty($info['groups_product'])))
            {
                foreach (explode("#", $info['kkm_sno']) as $value)
                {
                    $main->arr_kkm_sno[$value][1] = 'selected';
                    //echo var_dump($main->arr_kkm_sno[$value]) . "\n";
                }

                foreach (explode("#", $info['groups_product']) as $value)
                {
                    $main->arr_groups_product[$value][1] = 'selected';
                    //echo var_dump($main->groups_product[$value]) . "\n";
                }
            }

		    $main->showInfoKKM($info);
		    return;
	    }
	    
	    //Запись информации по ККМ в базу
	    if ($action === 'setInfoKKM')
	    {
            if ((!empty($_GET['kkm_sno'])) AND (!empty($_GET['groups_product']))) {
                $kkm_sno = implode("#", $_GET['kkm_sno']);
                $groups_product = implode("#", $_GET['groups_product']);
            } else {
                $kkm_sno = '';
                $groups_product = '';
            }

            $auto_upd_firmware = (empty($_GET['auto_upd_firmware']) ? '0' : '1');

            $db->arrInfoKKM = [
                'date_upd' => $_GET['date_upd'],
                'mexcod' => $_SESSION['mexcod'],
                'name_org' => $_GET['name_org'],
                'inn' => $_GET['inn'],
                'kkm_model' => $_GET['kkm_model'],
                'kkm_number' => $_GET['kkm_number'],
                'kkm_sno' => $kkm_sno,
                'kkm_firmware' => $_GET['kkm_firmware'],
                'fn_size' => $_GET['fn_size'],
                'fn_protocol' => $_GET['fn_protocol'],
                'sub_firmware' => $_GET['sub_firmware'],
                'auto_upd_firmware' => $auto_upd_firmware,
                'groups_product' => $groups_product,
            ];

            //echo var_dump($db->arrInfoKKM) . "\n";
            $result = $db->insertInfoKKM($db->arrInfoKKM);

		    //return;
		    //Header( 'Location: /app?mexcod=' . $_SESSION['mexcod'] . '&action=startInfoKKM' );
	    }

        if (!empty($_GET['idTicket']))
        {
            $idTicket = $_GET['idTicket']; // id заявки в базе на сайте

            // завершение заявки без указания времени и комментария
            if (!empty($idTicket) AND ($action === 'closeTicket')) {
                $sql = 'UPDATE zayavki SET vipolnil=1, vipolnilpc=0, prinal=1, prinalpc=1 WHERE idz=' . $idTicket;
                $db->query($sql);
                Header( 'Location: /app?mexcod=' . $mexcod );
            }

            // Сохраняем изменения в заявке или закрываем с сохранением
            if (!empty($idTicket) AND ($action === 'changeTicketWithBase')) {
                if ($_GET['closeTicket'] === '1') {
                    $sql = 'UPDATE zayavki
                                SET vipolnil=1, vipolnilpc=0, prinal=1, prinalpc=1, time=' . $_GET['time'] . ', comment=\'' . $_GET['comment'] . '\'
                                WHERE idz=' . $idTicket;
                } else {
                    $sql = 'UPDATE zayavki
                                SET prinal=1, prinalpc=0, time=' . $_GET['time'] . ', comment=\'' . $_GET['comment'] . '\'
                                WHERE idz=' . $idTicket;
                }
                $db->query($sql);
                Header( 'Location: /app?mexcod=' . $_SESSION['mexcod'] );
            }

            // принять заявку к исполнению
            if (!empty($idTicket) AND (($action === 'takeTicket') OR ($action === 'returnTicketToWork'))) {
                $sql = 'UPDATE zayavki SET vipolnil=0, vipolnilpc=0, prinal=1, prinalpc=0 WHERE idz=' . $idTicket;
                $db->query($sql);
                Header( 'Location: /app?mexcod=' . $mexcod );
            }

            // Страница изменения заявки. Написать комментарий и время. БЕЗ закрытия
            if (!empty($idTicket) AND ($action === 'changeTicketNoClose')) {
                $sql = 'SELECT * FROM zayavki WHERE idz=' . $idTicket . ' ORDER BY datasort, idz';
                $main->showChangeTicket($db->query($sql), 0);
                return;
            }

            // Страница завершения заявки С указанием времени и комментария
            if (!empty($idTicket) AND ($action === 'changeTicketAndClose')) {
                $sql = 'SELECT * FROM zayavki WHERE idz=' . $idTicket . ' ORDER BY datasort, idz';
                $main->showChangeTicket($db->query($sql), 1);
                return;
            }
        }
	}

    //Показать все открытые заявки механника
	if (!empty($mexcod))
	{
		$sql = 'SELECT * FROM zayavki WHERE mexcod=' . $mexcod . ' AND vipolnil=0  ORDER BY datasort, idz';
		$main->showTickets($db->query($sql));
	};
	
} elseif ('/api' === $uri) {
	//echo var_dump(file_get_contents("php://input"));
    $text =  file_get_contents("php://input");
    //echo $text;

    if(empty($text)){
        echo 'Пустой запрос api';
        return;
    }

    $apiCTO = new apiCTO();
    $apiCTO->text = $text;
    $apiCTO->inputMessage();

//    $db = new dataBase();
//    $sql = 'SELECT * FROM zayavki WHERE vipolnil=0 AND prinal=1';
//    $arrTickets = $db->query($sql);
//    echo var_dump($arrTickets);
//    echo $apiCTO->getChangedTickets();

} else {
	header('HTTP/1.1 404 Not Found');
	$main->show404();
}

//// Серверная информация по рабоботе страницы
//$main->show_info($_POST['showServerInfo']);