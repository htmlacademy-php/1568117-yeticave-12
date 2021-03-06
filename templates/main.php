<main class="container">
<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <!--заполните этот список из массива категорий-->
        <?php foreach ($category_description as $key => $value): ?>
        <li class="promo__item promo__item--<?=check_data($value['cat_code'] ?? "");?>">
            <a class="promo__link" href="pages/all-lots.html"><?=check_data($value['cat_name'] ?? "");?></a>
        </li>
        <?php endforeach; ?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <!--заполните этот список из массива с товарами-->
        <?php foreach ($lots as $key => $val): ?>
        <?php $time_to_end = check_lot_endtime($val['dt_end'] ?? "");?>
        <li class="lots__item lot">
            <div class="lot__image">
                <img src="<?=check_data($val['image'] ?? "");?>" width="350" height="260" alt="<?=check_data($val['lot_name'] ?? "");?>">
            </div>
            <div class="lot__info">
                <span class="lot__category"><?=check_data($val['cat_name'] ?? "");?></span>
                <h3 class="lot__title"><a class="text-link" href="<?="lot.php?id=" . $val['id'];?>"><?=check_data($val['lot_name'] ?? "");?></a></h3>
                <div class="lot__state">
                    <div class="lot__rate">
                        <span class="lot__amount">Стартовая цена</span>
                        <span class="lot__cost"><?=check_data($formated_price = change_format_price($val['price'] ?? ""));?></span>
                    </div>
                    <div class="lot__timer timer <?php if ($time_to_end[0] == 0): ?>timer--finishing<?php endif ?>">
                        <?=$lot_end_time = $time_to_end[0] . ":" . $time_to_end[1];?>
                    </div>
                </div>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
</section>
</main>
