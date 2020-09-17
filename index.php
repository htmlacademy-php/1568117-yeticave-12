<?php
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

require_once('functions.php');
$con = mysqli_connect("localhost", "root", "Infosec", "auctiondb");
mysqli_set_charset($con, "utf8");
$sql_req_cat = "SELECT cat_name, cat_code FROM categories";
$sql_data_categories = mysqli_query($con, $sql_req_cat);
$category_description = mysqli_fetch_all($sql_data_categories, MYSQLI_ASSOC);
$sql_req_lot = "SELECT lots.lot_name, lots.image, lots.price, lots.dt_end, categories.cat_name FROM lots INNER JOIN categories on lots.cat_id = categories.id WHERE lots.dt_create > DATE_SUB(NOW(), INTERVAL 1 DAY)";
$sql_data_lots = mysqli_query($con, $sql_req_lot);
$lots = mysqli_fetch_all($sql_data_lots, MYSQLI_ASSOC);

$is_auth = rand(0, 1);
$category_description_old = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];
$lots_old = [
    [
      'lot_name' => '2014 Rossignol District Snowboard',
      'lot_category' => 'Доски и лыжи',
      'lot_price' => 10999,
      'lot_url_image' => 'img/lot-1.jpg',
      'lot_data_end' => '2020-09-09',
    ],
    [
        'lot_name' => 'DC Ply Mens 2016/2017 Snowboard',
        'lot_category' => 'Доски и лыжи',
        'lot_price' => 159999,
        'lot_url_image' => 'img/lot-2.jpg',
        'lot_data_end' => '2020-09-16',
    ],
    [
        'lot_name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'lot_category' => 'Крепления',
        'lot_price' => 8000,
        'lot_url_image' => 'img/lot-3.jpg',
        'lot_data_end' => '2020-09-17',
    ],
    [
        'lot_name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'lot_category' => 'Ботинки',
        'lot_price' => 10999,
        'lot_url_image' => 'img/lot-4.jpg',
        'lot_data_end' => '2020-09-18',
    ],
    [
        'lot_name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'lot_category' => 'Одежда',
        'lot_price' => 7500,
        'lot_url_image' => 'img/lot-5.jpg',
        'lot_data_end' => '2020-09-19',
    ],
    [
        'lot_name' => 'Маска Oakley Canopy',
        'lot_category' => 'Разное',
        'lot_price' => 1400,
        'lot_url_image' => 'img/lot-6.jpg',
        'lot_data_end' => '2020-09-20',
    ],
];
$user_name = 'Олег'; // укажите здесь ваше имя

function change_format_price($old_format_price) {
    $round_number = ceil($old_format_price);
    $new_format_price = number_format($round_number, 0, '.', ' ') . " ₽";
    return $new_format_price;
}

function check_data($in_data) {
    $sec_data = htmlspecialchars($in_data);
    return $sec_data;
}

function check_lot_endtime($in_end_time) {
    $dt_end = date_create($in_end_time);
    $dt_now = date_create("now");
    $dt_diff = date_diff($dt_end, $dt_now);
    $days_temp = date_interval_format($dt_diff, "%a");
    $days_count[] = date_interval_format($dt_diff, "%H");
    $days_count[] = date_interval_format($dt_diff, "%I");
    if($days_temp > 0){
        $days_count[0] += $days_temp * 24;
    }
    return $days_count;
}

$page_content = include_template('main.php', [
    'category_description' => $category_description,
    'lots' => $lots
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'user_name' => $user_name,
    'category_description' => $category_description,
    'is_auth' => $is_auth,
    'title' => 'Аукцион Yeti Cave'
]);

print($layout_content);
