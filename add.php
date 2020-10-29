<?php
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

require_once('config/db.php');
require_once('sql_functions.php');
require_once('functions.php');
require_once('helpers.php');

$category_description = sql_get_categories($con);

$is_auth = rand(0, 1);
$user_name = 'Олег'; // укажите здесь ваше имя

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_lot = $_POST;
    $new_lot['price'] = $new_lot['start_price'];
    $errors = [];
    $rules = [
        'lot_name' => function() {
            return rules_validateNotEmpty('lot_name');
        },
        'cat_id' => function() {
            return rules_validateNotEmpty('cat_id');
        },
        'description' => function() {
            return rules_validateNotEmpty('description');
        },
        'image' => function() {
            return rules_validateImage('image');
        },
        'start_price' => function() {
            return rules_validatePrice('start_price');
        },
        'bid_increment' => function() {
            return rules_validatePrice('bid_increment');
        }
    ];

    foreach ($new_lot as $key => $value) {
        check_data($new_lot[$key]);
    }

    foreach ($new_lot as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule($value);
        }
    }

    $errors = array_filter($errors);

    if (isset($new_lot['cat_id'])) {
        $new_lot['cat_id'] = sql_get_lot_cat_id($con, $new_lot['cat_id']);
        if ($new_lot['cat_id'] == null) {
            $errors['cat_id'] = "Выбрана неверная категория";
        }
    } else {
        $errors['cat_id'] = "Выбрана неверная категория";
    };

    if (isset($new_lot['dt_end'])) {
        if (!is_date_valid($new_lot['dt_end'])) {
            $errors['dt_end'] = "Указана неверный формат даты";
        }
    } else {
        $errors['dt_end'] = "Дата окончания лота не указана";
    }

    if (!empty($_FILES['image']['name'])) {
        $filename = uniqid() . '.jpg';
        $new_lot['image'] = 'uploads/' . $filename;
        move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $filename);
    } else {
        $errors['image'] = "Вы не загрузили файл";
    }

    if (count($errors)) {
        $page_content = include_template('add-lot.php', [
            'category_description' => $category_description,
            'errors' => $errors
        ]);
        $title = 'Ошибка добавления лота';
    } else {
        $sql = 'INSERT INTO lots (lot_name, cat_id, description, start_price, bid_increment, dt_end, price, image, owner_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 2)';
        $stmt = db_get_prepare_stmt($con, $sql, $new_lot);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
         $new_lot_id = mysqli_insert_id($con);
         header("Location: lot.php?id=" . $new_lot_id);
        } else {
            $page_content = include_template('404.php', [
                'category_description' => $category_description
            ]);
            $title = 'Error 404';
        }
    }
}
else {
    if ($category_description) {
        $page_content = include_template('add-lot.php', [
            'category_description' => $category_description
        ]);
        $title = "Добавление лота";
    } else {
        $page_content = include_template('404.php', [
            'category_description' => $category_description
        ]);
        $title = 'Error 404';
    }
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'user_name' => $user_name,
    'category_description' => $category_description,
    'is_auth' => $is_auth,
    'title' => $title
]);

print($layout_content);
