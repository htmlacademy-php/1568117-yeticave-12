<?php
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

require_once('config/db.php');
require_once('sql_functions.php');
require_once('functions.php');
require_once('helpers.php');

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$category_description = sql_get_categories($con);
if (isset($id)) {
    $lots = sql_isset_lot_id($con, $id);
};

$is_auth = rand(0, 1);

$user_name = 'Олег'; // укажите здесь ваше имя

if ($lots) {
    $page_content = include_template('lot.php', [
        'category_description' => $category_description,
        'lots' => $lots
    ]);
    $title = $lots[0]['lot_name'] ?? "";
} else {
    $page_content = include_template('404.php', [
        'category_description' => $category_description,
        'lots' => $lots
    ]);
    $title = 'Error 404';
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'user_name' => $user_name,
    'category_description' => $category_description,
    'is_auth' => $is_auth,
    'title' => $title
]);

print($layout_content);
