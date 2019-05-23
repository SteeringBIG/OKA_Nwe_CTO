<div class="modal fade"  id="modalTicket-<?= $idTicket ?>" tabindex="-1" role="dialog" aria-labelledby="modalTicket-<?= $idTicket ?>-Title" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTicket-<?= $idTicket ?>-Title">Заявка № <?= $nomerTicket ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <?php if ($status == '1'): // Статус заявки ?>
                    <a href="/app?mexcod=<?= $mexCod ?>&action=closeTicket&idTicket=<?= $idTicket ?>" class="btn btn-primary btn-block">Завершить</a>
                    <a href="/app?mexcod=<?= $mexCod ?>&action=changeTicketAndClose&idTicket=<?= $idTicket ?>" class="btn btn-primary btn-block">Завершить с комментарием</a>
                <?php elseif ($status == '2'): // Вернуть в работу ?>
                    <a href="/app?mexcod=<?= $mexCod ?>&action=returnTicketToWork&idTicket=<?= $idTicket ?>" class="btn btn-primary btn-block">Вернуть в работу</a>
                <?php else: // Подтвердить ?>
                    <a href="/app?mexcod=<?= $mexCod ?>&action=takeTicket&idTicket=<?= $idTicket ?>" class="btn btn-primary btn-block">Принять в работу</a>
                    <a href="/app?mexcod=<?= $mexCod ?>&action=changeTicketAndClose&idTicket=<?= $idTicket ?>" class="btn btn-primary btn-block">Завершить с комментарием</a>
                <?php endif; ?>
                    <a href="/app?mexcod=<?= $mexCod ?>&action=changeTicketNoClose&idTicket=<?= $idTicket ?>" class="btn btn-primary btn-block">Написать комментарий</a>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Вернуться</button>
			</div>
		</div>
	</div>
</div>