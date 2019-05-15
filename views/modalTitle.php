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
                <a href="/app?mexcod=<?= $_SESSION['mexcod'] ?>" class="btn btn-primary btn-block">Текущие заявки</a>
                <hr>
                <form method="GET" action="/app">
                    <input type="hidden" name="mexcod" value="<?= $_SESSION['mexcod'] ?>">
                    <input type="hidden" name="action" value="showHistoryTicket">

                    <label for="time">Период:</label>
                    <div class="form-group">
                        <input type="date" class="form-control" name="dateFrom" id="dateFrom" value="<?= date( "Y-m-01" ) ?>" placeholder="time">
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-control" name="dateTo" id="dateTo" value="<?= date( "Y-m-d" ) ?>" placeholder="time">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Показать историю</button>
                    </div>
                </form>
<!--                Информация по ккм-->
<!--                <hr>-->
<!--                <a href="/app?mexcod=--><?//= $_SESSION['mexcod'] ?><!--&action=startInfoKKM" class="btn btn-primary btn-block">Информация по ККМ</a>-->
                <hr>
<!--                Поиск договора по ИНН-->
                <form method="GET" action="/app">
                    <input type="hidden" name="mexcod" value="<?= $_SESSION['mexcod'] ?>">
                    <input type="hidden" name="action" value="showInfoContract">

                    <div class="form-group">
<!--                        <label for="searchContract">Проверить договор контрагента:</label>-->
                        <div >
                            <div class="form-check form-check-inline">
                                <label class="btn btn-secondary">
                                    <input class="form-check-input" type="radio" name="searchContractBy" id="option2" value="name" checked> Название
                                </label>
                                <div class="form-check form-check-inline">
                                </div>
                                <label class="btn btn-secondary active">
                                    <input class="form-check-input" type="radio" name="searchContractBy" id="option1" value="inn" > ИНН
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="searchString" id="searchString" value="" placeholder="ИНН или часть наименования">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Проверить договор</button>
                    </div>
                </form>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Вернуться</button>
			</div>
		</div>
	</div>
</div>