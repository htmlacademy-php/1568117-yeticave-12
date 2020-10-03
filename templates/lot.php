
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
        <section class="lot-item container">
            <h2><?=check_data($lots[0]['lot_name'] ?? "");?></h2>
            <div class="lot-item__content">
                <div class="lot-item__left">
                    <div class="lot-item__image">
                        <img src="<?=check_data($lots[0]['image'] ?? "");?>" width="730" height="548" alt="<?=check_data($lots[0]['lot_name'] ?? "");?>">
                    </div>
                    <p class="lot-item__category">Категория: <span><?=check_data($lots[0]['cat_name'] ?? "");?></span></p>
                    <p class="lot-item__description"><?=check_data($lots[0]['description'] ?? "");?></p>
                </div>
                <div class="lot-item__right">
                    <div class="lot-item__state">
                        <?php $time_to_end = check_lot_endtime($lots[0]['dt_end'] ?? "");?>
                        <div class="lot-item__timer timer <?php if ($time_to_end[0] == 0): ?>timer--finishing<?php endif ?>">
                            <?=$lot_end_time = $time_to_end[0] . ":" . $time_to_end[1];?>
                        </div>
                        <div class="lot-item__cost-state">
                            <div class="lot-item__rate">
                                <span class="lot-item__amount">Текущая цена</span>
                                <span class="lot-item__cost"><?=check_data(change_format_price($lots[0]['price'] ?? ""));?></span>
                            </div>
                            <div class="lot-item__min-cost">
                                Мин. ставка <span><?=check_data(change_format_price($lots[0]['price'] + $lots[0]['bid_increment'] ?? ""));?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

