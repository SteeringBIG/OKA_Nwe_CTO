
    <?php //echo var_dump($tickets); ?>

<div class="col-">
	<div class="alert alert-success btn-block" role="alert">
		<h4 class="text-uppercase text-center">Текущие заявки</h4>
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
        $status = $tic['prinal'];
        if ($status == '1'){ // Статус заявки
	        echo '<span class="badge badge-pill badge-success btn-block" data-toggle="modal" data-target="#modalTicket-'. $idTicket .'">В работе</span>';
        }else{
	        echo '<span class="badge badge-pill badge-danger btn-block" data-toggle="modal" data-target="#modalTicket-'. $idTicket .'">Ожидание</span>';
        }
        
        echo '<b>' . $tic['data']. ' ' .$tic['datatime']. '</b><br>' . str_ireplace("#", "
                    <br><b>Клиент: </b>", $tic['problema']). "<br><b>" .$tic['time']. " мин. ". "ком: </b>". $tic['comment'];;
        
        //echo var_dump($tickets[$n]);
	
	    echo '</div>';
        echo '</div>';
        
        require 'modalTicket.php'; //Модальное окно с кнопками для каждого тикета
        $n++;
    }
?>
    

   
    