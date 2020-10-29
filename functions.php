<?php

function rules_validateNotEmpty ($name) {
    if (empty($_POST[$name])) {
        return "Поле должно быть заполнено";
    }
    return null;
}

function rules_validatePrice ($name) {
    if (!is_numeric($_POST[$name]) && $_POST[$name] <= 0) {
        return "Поле должно содержать число больше нуля";
    }
    return null;
}

function rules_validateImage ($name) {
    if (mime_content_type($_POST[$name]) != "image/png" || mime_content_type($_POST[$name]) != "image/jpeg") {
        return "Картинка должна быть в формате png или jpeg";
    }
    return null;
}

function getPostVal($name) {
    return $_POST[$name] ?? "";
}

function check_data($in_data) {
    $sec_data = htmlspecialchars($in_data);
    return $sec_data;
}

function change_format_price($old_format_price) {
    $round_number = ceil($old_format_price);
    $new_format_price = number_format($round_number, 0, '.', ' ') . " ₽";
    return $new_format_price;
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
