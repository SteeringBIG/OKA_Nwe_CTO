<div class="col-">
	<div class="alert alert-success btn-block" data-toggle="modal" data-target="#modalTitle" role="alert">
		<h5 class="text-uppercase text-center">Информация по ККМ</h5>
	</div>
</div>
<?php
    require 'modalTitle.php'; //Модальное окно с основным меню
    echo var_dump( $getArr);
//    echo var_dump( $getArr['fn_size']) . "\n";
//    echo var_dump( $getArr['fn_protocol']) . "\n";
//$getArr = $getArr[0];

if ($getArr['action'] === 'getInfoKKM') : ?>

    <form method="GET" action="/app">
        <input type="hidden" name="mexcod" value="<?= $_SESSION['mexcod'] ?>">
        <input type="hidden" name="action" value="setInfoKKM">
        <input type="hidden" name="date_upd" value="<?= date('Y-m-d H:i:s') ?>" >

        <div class="form-group">
            <label for="name_org">Название организации</label>
            <input type="text" class="form-control" name="name_org" id="name_org" value="<?= $getArr['name_org'] ?>" placeholder="name_org">
        </div>
        <div class="form-group">
            <label for="inn">ИНН</label>
            <input type="number" class="form-control" name="inn" id="inn" autocomplete="off" value="<?= $getArr['inn'] ?>" placeholder="inn" required>
        </div>
        <div class="form-group">
            <label for="kkm_model">Модель ККМ</label>
            <input type="text" class="form-control" name="kkm_model" id="kkm_model" value="<?= $getArr['kkm_model'] ?>" placeholder="kkm_model">
        </div>
        <div class="form-group">
            <label for="kkm_number">Заводской номер ККМ</label>
            <input type="number" class="form-control" name="kkm_number" id="kkm_number" autocomplete="off" value="<?= $getArr['kkm_number'] ?>" placeholder="kkm_number" required>
        </div>
        <div class="form-group">
            <label for="kkm_sno">Система ноалообложения</label>
            <select multiple class="form-control" name="kkm_sno[]" id="kkm_sno">
				<?php foreach ($arr_kkm_sno  as $key => $value) : ?>
                    <option <?= $value[1] ?>  value="<?= $key ?>"><?= $value[0] ?></option>
				<?php endforeach; ?>
            </select>
        </div>
        <!--
			<div class="form-group">
				<label for="kkm_sno">Система ноалообложения</label>
				<input type="text" class="form-control" name="kkm_sno" id="kkm_sno" value="" placeholder="kkm_sno" required>
			</div>
		-->
        <div class="form-group">
            <label for="kkm_firmware">Прошивка ККМ</label>
            <input type="text" class="form-control" name="kkm_firmware" id="kkm_firmware" value="<?= $getArr['kkm_firmware'] ?>" placeholder="kkm_firmware" required>
        </div>
        <div class="form-group">
            <label for="fn_size">ФН (число месяцев)  </label>
            <div >
                <div class="form-check form-check-inline">
                    <label class="btn btn-secondary active">
                        <input class="form-check-input" type="radio" name="fn_size" id="option1" value="13" <?php echo $getArr['fn_size'] == "13" ? 'checked' : ''; ?> > 13
                    </label>
                    <div class="form-check form-check-inline">
                    </div>
                    <label class="btn btn-secondary">
                        <input class="form-check-input" type="radio" name="fn_size" id="option2" value="15" <?php echo $getArr['fn_size'] == "15" ? 'checked' : ''; ?> > 15
                    </label>
                    <div class="form-check form-check-inline">
                    </div>
                    <label class="btn btn-secondary">
                        <input class="form-check-input" type="radio" name="fn_size" id="option3" value="36" <?php echo $getArr['fn_size'] == "36" ? 'checked' : ''; ?> > 36
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="fn_protocol">Протокол обмена ФН</label>
            <select class="form-control" name="fn_protocol" id="fn_protocol" required>
                <option value="">Нужно выбрать протокол обмена</option>
                <option <?php echo $getArr['fn_protocol'] === '1.0.0' ? 'selected' : ''; ?> value="1.0.0">1.0.0</option>
                <option <?php echo $getArr['fn_protocol'] === '1.0.5' ? 'selected' : ''; ?> value="1.0.5">1.0.5</option>
                <option <?php echo $getArr['fn_protocol'] === '1.1.0' ? 'selected' : ''; ?> value="1.1.0">1.1.0</option>
            </select>
        </div>

        <div class="form-group">
            <label for="sub_firmware">Подписка на обновление прошивки</label>
            <div>
                <input type="date" class="form-control" name="sub_firmware" id="sub_firmware" autocomplete="off" value="<?= $getArr['sub_firmware'] ?>" placeholder="sub_firmware">
            </div>

        </div>

        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="auto_upd_firmware" id="auto_upd_firmware" <?=(empty($getArr['auto_upd_firmware']) ? '' : 'checked') ?>>
            <label for="auto_upd_firmware">Авто-обновление прошивки</label>

        </div>

        <div class="form-group">
            <label for="groups_product">Группы товаров</label>
            <select multiple class="form-control" name="groups_product[]" id="groups_product">
				<?php foreach ($arr_groups_product  as $key => $value) : ?>
                    <option <?= $value[1] ?>  value="<?= $key ?>"><?= $value[0] ?></option>
				<?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Сохранить изменения</button>
        </div>
        <div class="form-group">
            <a href="/app?mexcod=<?= $_SESSION['mexcod'] ?>&action=startInfoKKM" class="btn btn-primary btn-block">Вернуться</a>
        </div>
    </form>

<?php elseif ($getArr['action'] === 'startInfoKKM') : ?>
	
    <form method="GET" action="/app">
        <input type="hidden" name="mexcod" value="<?= $_SESSION['mexcod'] ?>">
        <input type="hidden" name="action" value="getInfoKKM">
        
        <div class="form-group">
            <label for="kkm_number">Заводской номер ККМ</label>
            <input type="number" class="form-control" name="kkm_number" id="kkm_number" autocomplete="off" value="<?= $getArr['kkm_number'] ?>" placeholder="kkm_number" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Посмотреть/добавить информацию</button>
        </div>
        
        
    </form>

    <br>
<?php endif; ?>
