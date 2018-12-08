<div class="modal fade"  id="modalTitle" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle">Основное меню</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <form method="GET" action="/app">
                    <input type="hidden" name="mexcod" value="<?= $_SESSION['mexcod'] ?>">
                    <input type="hidden" name="action" value="showHistoryTicket">

                    <div class="form-group">
                        <label for="time">Начиная с:</label>
                        <input type="date" class="form-control" name="dateFrom" id="dateFrom" value="<?= date( "Y-m-01" ) ?>" placeholder="time">
                    </div>
                    <div class="form-group">
                        <label for="time">заканчивая:</label>
                        <input type="date" class="form-control" name="dateTo" id="dateTo" value="<?= date( "Y-m-d" ) ?>" placeholder="time">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Показать историю</button>
                    </div>
                </form>
                <a href="/app?mexcod=<?= $_SESSION['mexcod'] ?>" class="btn btn-primary btn-block">Текущие заявки</a>
                <a href="/app?mexcod=<?= $_SESSION['mexcod'] ?>&action=infoKKM" class="btn btn-primary btn-block">Информация по ККМ</a>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Вернуться</button>
			</div>
		</div>
	</div>
</div>