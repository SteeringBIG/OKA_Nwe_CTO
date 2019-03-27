<div class="col-">
    <div class="alert alert-success btn-block" data-toggle="modal" data-target="#modalTitle" role="alert">
        <h4 class="text-uppercase text-center">Изменение заявки</h4>
    </div>
</div>

<div class="col-">
	<div class="alert alert-dark btn-block">
		<form method="GET" action="/app">
            <input type="hidden" name="mexcod" value="<?= $_SESSION['mexcod'] ?>">
            <input type="hidden" name="action" value="changeTicketWithBase">
            <input type="hidden" name="idTicket" value="<?= $ticket[0]['idz'] ?>">

            <div class="form-group">
                <p><b>Описание заявки:</b> <?= $ticket[0]['problema'] ?></p>
            </div>
            <div class="form-group">
                <label for="time"><b>Затраченное время в минутах</b></label>
				<input type="number" class="form-control" name="time" id="time" value="<?= $ticket[0]['time'] ?>" placeholder="time" step="5">
			</div>
			<div class="form-group">
                <label for="comment"><b>Комментарий к заявке</b></label>
                <textarea class="form-control" name="comment" id="comment" placeholder="Комментарий" rows="3"><?= $ticket[0]['comment'] ?></textarea>
			</div>

            <input type="hidden" name="closeTicket" value="<?= $closeTicket ?>">

            <div class="form-group">
                <?php if ($closeTicket === 1): // Закрыть заявку или сохранить изменения ?>
                    <button type="submit" class="btn btn-primary btn-block">Закрыть заявку</button>
                <?php else: ?>
                    <button type="submit" class="btn btn-primary btn-block">Сохранить изменения</button>
                <?php endif; ?>
            </div>
		</form>
	</div>
</div>

<?php
require 'modalTitle.php'; //Модальное окно с основным меню

//
//echo var_dump($ticket);
//echo $time . "\n";
//echo $comment . "\n";
?>