<?php
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

require_once('functions.php');
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$con = mysqli_connect("localhost", "root", "Infosec", "auctiondb");
mysqli_set_charset($con, "utf8");
$sql_req_cat = "SELECT cat_name, cat_code FROM categories";
$sql_data_categories = mysqli_query($con, $sql_req_cat);
$category_description = mysqli_fetch_all($sql_data_categories, MYSQLI_ASSOC);
if (isset($id)) {
    $sql_req_lot = "SELECT lots.lot_name, lots.description, lots.bid_increment, lots.image, lots.price, lots.dt_end, categories.cat_name FROM lots INNER JOIN categories on lots.cat_id = categories.id WHERE lots.id = $id";
    $sql_data_lots = mysqli_query($con, $sql_req_lot);
    $lots = mysqli_fetch_all($sql_data_lots, MYSQLI_ASSOC);
};

$is_auth = rand(0, 1);

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
