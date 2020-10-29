
    <main>
        <nav class="nav">
            <ul class="nav__list container">
                <!--заполните этот список из массива категорий-->
                <?php foreach ($category_description as $value): ?>
                    <li class="nav__item">
                        <a href="pages/all-lots.html"><?=check_data($value['cat_name'] ?? "");?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <?php $classname = isset($errors) ? "form--invalid" : "";?>
        <form class="form form--add-lot container <?=$classname;?>" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
            <h2>Добавление лота</h2>
            <div class="form__container-two">
                <?php $classname = isset($errors['lot_name']) ? "form__item--invalid" : "";?>
                <div class="form__item <?=$classname;?>"> <!-- form__item--invalid -->
                    <label for="lot_name">Наименование <sup>*</sup></label>
                    <input id="lot_name" type="text" name="lot_name" placeholder="Введите наименование лота" value="<?=getPostVal('lot_name') ?? "";?>">
                    <span class="form__error"><?=$errors['lot_name'] ?? "";?></span>
                </div>
                <?php $classname = isset($errors['cat_id']) ? "form__item--invalid" : "";?>
                <div class="form__item <?=$classname;?>">
                    <label for="cat_id">Категория <sup>*</sup></label>
                    <select id="cat_id" name="cat_id">
                        <option>Выберите категорию</option>
                        <?php foreach ($category_description as $value): ?>
                            <option><?=check_data($value['cat_name'] ?? "");?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="form__error"><?=$errors['cat_id'] ?? "";?></span>
                </div>
            </div>
            <?php $classname = isset($errors['description']) ? "form__item--invalid" : "";?>
            <div class="form__item form__item--wide <?=$classname;?>">
                <label for="description">Описание <sup>*</sup></label>
                <textarea id="description" name="description" placeholder="Напишите описание лота"><?=getPostVal('description') ?? "";?></textarea>
                <span class="form__error"><?=$errors['description'] ?? "";?></span>
            </div>
            <?php $classname = isset($errors['image']) ? "form__item--invalid" : "";?>
            <div class="form__item form__item--file <?=$classname;?>">
                <label>Изображение <sup>*</sup></label>
                <div class="form__input-file">
                    <input class="visually-hidden" type="file" name="image" id="image" value="">
                    <label for="image">
                        Добавить
                    </label>
                </div>
                <span class="form__error"><?=$errors['image'] ?? "";?></span>
            </div>
            <div class="form__container-three">
                <?php $classname = isset($errors['start_price']) ? "form__item--invalid" : "";?>
                <div class="form__item form__item--small <?=$classname;?>">
                    <label for="start_price">Начальная цена <sup>*</sup></label>
                    <input id="start_price" type="text" name="start_price" placeholder="0" value="<?=getPostVal('start_price') ?? "";?>">
                    <span class="form__error"><?=$errors['start_price'] ?? "";?></span>
                </div>
                <?php $classname = isset($errors['bid_increment']) ? "form__item--invalid" : "";?>
                <div class="form__item form__item--small <?=$classname;?>">
                    <label for="bid_increment">Шаг ставки <sup>*</sup></label>
                    <input id="bid_increment" type="text" name="bid_increment" placeholder="0" value="<?=getPostVal('bid_increment') ?? "";?>">
                    <span class="form__error"><?=$errors['bid_increment'] ?? "";?></span>
                </div>
                <?php $classname = isset($errors['dt_end']) ? "form__item--invalid" : "";?>
                <div class="form__item <?=$classname;?>">
                    <label for="dt_end">Дата окончания торгов <sup>*</sup></label>
                    <input class="form__input-date" id="dt_end" type="text" name="dt_end" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?=getPostVal('dt_end') ?? "";?>">
                    <span class="form__error"><?=$errors['dt_end'] ?? "";?></span>
                </div>
            </div>
            <?php $classname = isset($errors) ? "Пожалуйста, исправьте ошибки в форме" : "";?>
            <span class="form__error form__error--bottom"><?=$classname;?></span>
            <button type="submit" class="button">Добавить лот</button>
        </form>
    </main>
