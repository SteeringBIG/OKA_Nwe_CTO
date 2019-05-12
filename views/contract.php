
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
    curl_setopt($ch, CURLOPT_URL,'http://vpn.oe22.ru:8000/oka_cto/hs/contract/' . $inn);
    curl_setopt($ch, CURLOPT_USERPWD,$username . ":" . $password);

    $content = curl_exec($ch);

?>


<div class="col-">
    <div class="alert  alert-info text-center btn-block">
        <br>
        <br><?= $content ?>
        <br>
    </div>
</div>


<?php
    require 'modalTitle.php'; //Модальное окно с основным меню
?>
