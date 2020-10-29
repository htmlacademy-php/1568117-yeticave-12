<?php
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

require_once('config/db.php');
require_once('sql_functions.php');
require_once('functions.php');
require_once('helpers.php');

$category_description = sql_get_categories($con);
$lots = sql_get_lots($con);

$is_auth = rand(0, 1);
$user_name = 'Олег'; // укажите здесь ваше имя

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
