
<div class="col-">
    <div class="alert alert-success btn-block" data-toggle="modal" data-target="#modalTitle" role="alert">
        <h4 class="text-uppercase text-center">Информация по договору</h4>
    </div>
</div>

<?php

    $inn = $_GET['inn'];
    $username = "web";
    $password = "";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL,'http://DC-01/oka_cto/hs/contract/' . $inn);

    curl_setopt($ch, CURLOPT_USERPWD,$username . ":" . $password);

    $content = curl_exec($ch);
    //echo $content . "<br>";

    $stringTable = "";
    $content = json_decode($content, true);

    echo "<div class=\"col-\">";
    foreach ($content as $key => $value) {
        $subKey = substr($key, 0, 10);
        switch ($subKey) {
            case 'Шапка':

                echo "<div class=\"alert  alert-warning btn-block\">";
                echo $value['Контрагент'] . "<br>" . $value['ДоговорКонтрагента'] . ". Сумма: " . $value['СуммаУсловийДоговора'] . " руб.";
                echo "</div>";

                break;
            case 'Строк':
                echo "<div class=\"alert  alert-dark btn-block\">";
                echo "<b>" . $value['Содержание'] . " </b>Сумма: " . $value['Сумма'] . " руб. <b>Адрес: " . $value['АдресИспользования'] . "</b> <i>" . $value['Ответственный'] . "</i>";
                echo "</div>";

                break;
            case 'Ошибк':

                echo "<div class=\"alert  alert-danger btn-block\">";
                echo $value['ОписаниеОшибки'];
                echo "</div>";

                break;

        }
    }
    echo "</div>";

    require 'modalTitle.php'; //Модальное окно с основным меню
?>
