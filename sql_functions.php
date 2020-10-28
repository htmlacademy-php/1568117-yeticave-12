<?php

/**
 * функция создает двумерный массив категорий из базы данных
 *
 * @param $connect mysqli Ресурс имя базы данных
 *
 * @return array массив категориий
 */
function sql_get_categories($connect) {
    $categories = <<<SQL
    SELECT cat_name, cat_code FROM categories 
SQL;
    $sql_cut_result = mysqli_query($connect, $categories);
    if(!$sql_cut_result) {
        $error = mysqli_error($connect);
        exit('Ошибка mySQL: ' . $error);
    }
    else {
        return mysqli_fetch_all($sql_cut_result, MYSQLI_ASSOC);
    }
};

/**
 * функция создает двумерный массив с лотами из базы данных
 *
 * @param $connect mysqli Ресурс имя базы данных
 *
 * @return array массив с лотами
 */
function sql_get_lots($connect) {
    $lots = <<<SQL
    SELECT lots.lot_name, lots.image, lots.id, lots.price, lots.dt_end, categories.cat_name FROM lots INNER JOIN categories on lots.cat_id = categories.id WHERE lots.dt_create > DATE_SUB(NOW(), INTERVAL 24 DAY) ORDER BY lots.id
SQL;
    $sql_lots_result = mysqli_query($connect, $lots);
    if(!$sql_lots_result) {
        $error = mysqli_error($connect);
        exit('Ошибка mySQL: ' . $error);
    }
    else {
        return mysqli_fetch_all($sql_lots_result, MYSQLI_ASSOC);
    }
};

/**
 * функция проверяет существование лот ID
 *
 * @param $connect mysqli Ресурс имя базы данных
 * @param int $lot_id число означающиее id лота
 *
 * @return array массив с найденным лотом
 */
function sql_isset_lot_id ($connect, $lot_id) {
    mysqli_set_charset($connect, 'utf8');
    $whereCondition = ($lot_id ?  "WHERE lots.id = $lot_id" : '');
    $lots = <<<SQL
    SELECT lots.lot_name, lots.description, lots.bid_increment, lots.image, lots.price, lots.dt_end, categories.cat_name FROM lots INNER JOIN categories on lots.cat_id = categories.id
    $whereCondition
SQL;
    $sql_lots_result = mysqli_query($connect, $lots);
    if(!$sql_lots_result) {
        $error = mysqli_error($connect);
        exit('Ошибка mySQL: ' . $error);
    }
    else {
        return mysqli_fetch_all($sql_lots_result, MYSQLI_ASSOC);
    }
};

/**
 * функция переводит текстовое значение категории лота в цифровое значение для сохранения в БД
 *
 * @param $connect mysqli Ресурс имя базы данных
 * @param string $cat_name Наименование категории
 *
 * @return array массив с ID найденной категории
 */
function sql_get_lot_cat_id($connect, $cat_name) {
    mysqli_set_charset($connect, 'utf8');
    $whereCondition = ($cat_name ?  "WHERE categories.cat_name = '{$cat_name}'" : '');
    $lots = <<<SQL
    SELECT categories.id FROM categories
    $whereCondition
SQL;
    $sql_lots_result = mysqli_query($connect, $lots);
    if(!$sql_lots_result) {
        $error = mysqli_error($connect);
        exit('Ошибка mySQL (неверная категория лота): ' . $error);
    }
    else {
        $cat_id = mysqli_fetch_all($sql_lots_result, MYSQLI_ASSOC);
        if ($cat_id) {
            return $cat_id[0]['id'];
        }
        else {
            return $cat_id[0]['id'] = null;
        }
    }
}
