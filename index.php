<?php
session_start(); //Начинаем сессию
require 'vendor/autoload.php';

use okaCTO\main;
use okaCTO\dataBase;
use okaCTO\apiCTO;

$main = new main();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
//echo $uri;
if ('/' === $uri) {

	$main->showHome();
	
} elseif ('/app' === $uri) {
	if (empty($_GET)){
		$main->showHome();
		return;
	} else {
		$db = new dataBase();
		$mexcod = $_GET['mexcod']; // код механника
		$_SESSION['mexcod'] = $mexcod;
		$idTicket = $_GET['idTicket']; // id заявки в базе на сайте
		$action = $_GET['action'];
	}
	
	// завершение заявки без указания времени и комментария
	if (!empty($idTicket) AND !empty($mexcod) AND ($action === 'closeTicket'))
	{
		$sql = 'UPDATE zayavki SET vipolnil=1, vipolnilpc=0, prinal=1, prinalpc=1 WHERE idz=' . $idTicket;
		$db->query($sql);
		//Header( 'Location: /app?mexcod=' . $mexcod );
	}
	
	// Сохраняем изменения в заявке или закрываем с сохранением
	if (!empty($idTicket) AND ($action === 'changeTicketWithBase'))
	{
		if ($_GET['closeTicket'] === '1')
		{
			$sql = 'UPDATE zayavki
					SET vipolnil=1, vipolnilpc=0, prinal=1, prinalpc=1, time=' . $_GET['time'] . ', comment=\'' . $_GET['comment'] . '\'
					WHERE idz=' . $idTicket;
		} else {
			$sql = 'UPDATE zayavki
					SET time=' . $_GET['time'] . ', comment=\''. $_GET['comment'] .'\'
					WHERE idz=' . $idTicket;
		}
		
		$db->query($sql);
		//Header( 'Location: /app?mexcod=' . $_SESSION['mexcod'] );
	}
	
	// принять заявку к исполнению
	if (!empty($idTicket) AND !empty($mexcod) AND ($action === 'takeTicket'))
	{
		$sql = 'UPDATE zayavki SET vipolnil=0, vipolnilpc=0, prinal=1, prinalpc=0 WHERE idz=' . $idTicket;
		$db->query($sql);
		//Header( 'Location: /app?mexcod=' . $mexcod );
	}
	
	// Страница изменения заявки. Написать комментарий и время. БЕЗ закрытия
	if (!empty($idTicket) AND !empty($mexcod) AND ($action === 'changeTicketNoClose'))
	{
		$sql = 'SELECT * FROM zayavki WHERE idz=' . $idTicket . ' ORDER BY datasort, idz';
		$main->showChangeTicket($db->query($sql), 0);
		return;
	}
	
	// Страница завершения заявки С указанием времени и комментария
	if (!empty($idTicket) AND !empty($mexcod) AND ($action === 'changeTicketAndClose'))
	{
		$sql = 'SELECT * FROM zayavki WHERE idz=' . $idTicket . ' ORDER BY datasort, idz';
		$main->showChangeTicket($db->query($sql), 1);
		return;
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
//$db = new dataBase();
//
//$sql = "SELECT * FROM zayavki WHERE mexcod=60 AND vipolnil=0";
//
//$z = $db->query($sql);
//echo var_dump($z);

//
//$main = new main();
//$auth = new auth();
//
//$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
//if ('/' === $uri) {
//	$main->show_menu();
//	echo '<h1>Нужно выбрать пункт меню</h1>';
//
//} elseif ('/home' === $uri) {
//	$main->show_menu();
//	$main->show_home();
//
//} elseif('/login' === $uri) {
//
//	if (empty($_SESSION['username'])) {
//		$userName = $_POST['username'];
//		if (!empty($userName)) {
//			if (!is_null($auth->checkUserName($userName))) {
//				if (!is_null($auth->checkUserPass($userName, $_POST['pass']))) {
//					$auth->setUserInfo($userName);
//				}else {
//					$errorAuth = 'Пароль не соответствует логину';
//				}
//			} else {
//				$errorAuth = 'Пользователь с именем ' . $userName . ' не зарегистрирован в системе';
//				$userName = null;
//			}
//		}
//	}
//	$main->show_menu();
//	$main->show_login($userName, $errorAuth);
//
//} elseif('/balance' === $uri) {
//	if (empty($_SESSION['username'])) {
//		$auth->exitSession();
//	} else {
//		$main->show_menu();
//		$main->show_balance();
//	}
//
//} elseif('/exit' === $uri) {
//    $auth->exitSession();
//
//} else {
//	header('HTTP/1.1 404 Not Found');
//	$main->show_menu();
//	echo '<h1 style="color: blue">404 Page Not Found.</h1> ';
//
//}
//
//// Серверная информация по рабоботе страницы
//$main->show_info($_POST['showServerInfo']);