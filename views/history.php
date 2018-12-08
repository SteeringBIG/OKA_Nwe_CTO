
<?php //echo var_dump($tickets); ?>

<div class="col-">
    <div  class="alert alert-success btn-block"  data-toggle="modal" data-target="#modalTitle" role="alert">
        <h5 class="text-uppercase text-center">История заявок</h5>
    </div>
</div>

<?php
    $n = 0;

    foreach($tickets as $key => $value) { // $key - индекс элемента массива, $value - значение элемента массива
        $alert = ( $n & 1 ) ? 'dark' : 'warning'; // Чередуем цвет фона заявки

        echo '<div class="col-">';
        echo '<div class="alert alert-' . $alert . ' btn-block text-center ">';// role="alert"

        //echo var_dump($tickets[$n]['prinal']);
        $tic = $tickets[$n]; // Очередной тикет из массива
        $mexCod = $tic['mexcod']; // код механника. Нужен для модального окна
        $idTicket = $tic['idz']; // id заявки в базе на сайте
        $status = '2';

        echo '<span class="badge badge-pill badge-success btn-block" data-toggle="modal" data-target="#modalTicket-'. $idTicket .'">
                Действия с заявкой <br>' . $tic['data'] . ' ' . $tic['datatime'] . '  
              </span>';

        echo '' . str_ireplace("#", "<br><b>Клиент: </b>",
                $tic['problema']). "<br><b>" .$tic['time']. " мин. ". "ком: </b>". $tic['comment'] . '';

        //echo var_dump($tickets[$n]);

        echo '</div>';
        echo '</div>';
        require 'modalTicket.php';
        $n++;
    }
    require 'modalTitle.php'; //Модальное окно с кнопками для каждого тикета
?>