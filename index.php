<?php

require_once('functions.php');

$is_auth = rand(0, 1);
$category_description = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];
$lots = [
    [
      'lot_name' => '2014 Rossignol District Snowboard',
      'lot_category' => 'Доски и лыжи',
      'lot_price' => 10999,
      'lot_url_image' => 'img/lot-1.jpg',
    ],
    [
        'lot_name' => 'DC Ply Mens 2016/2017 Snowboard',
        'lot_category' => 'Доски и лыжи',
        'lot_price' => 159999,
        'lot_url_image' => 'img/lot-2.jpg',
    ],
    [
        'lot_name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'lot_category' => 'Крепления',
        'lot_price' => 8000,
        'lot_url_image' => 'img/lot-3.jpg',
    ],
    [
        'lot_name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'lot_category' => 'Ботинки',
        'lot_price' => 10999,
        'lot_url_image' => 'img/lot-4.jpg',
    ],
    [
        'lot_name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'lot_category' => 'Одежда',
        'lot_price' => 7500,
        'lot_url_image' => 'img/lot-5.jpg',
    ],
    [
        'lot_name' => 'Маска Oakley Canopy',
        'lot_category' => 'Разное',
        'lot_price' => 1400,
        'lot_url_image' => 'img/lot-6.jpg',
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
