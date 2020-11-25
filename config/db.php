<?php

/**
 * Инициализация подключения к БД
 */

$con = mysqli_connect("localhost", "root", "Infosec", "auctiondb");
mysqli_set_charset($con, "utf8");

if (!$con) {
    echo "Ошибка доступа к БД";
    exit();
};
