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
    $new_user = $_POST;
    $errors = [];
    $rules = [
        'email' => function() {
            return rules_validateNotEmpty('email');
        },
        'username' => function() {
            return rules_validateNotEmpty('username');
        },
        'password' => function() {
            return rules_validateNotEmpty('password');
        },
        'contact' => function() {
            return rules_validateNotEmpty('contact');
        }
    ];

    foreach ($new_user as $key => $value) {
        check_data($new_user[$key]);
    }

    foreach ($new_user as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule($value);
        }
    }

    $errors = array_filter($errors);
    $new_user['email'] = filter_var($new_user['email'], FILTER_SANITIZE_EMAIL);

    if (!filter_var($new_user['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Укажите верный email';
    }

    if (empty($errors)) {
        $email = mysqli_real_escape_string($con, $new_user['email']);
        $sql = "SELECT id FROM users WHERE email = '$email'";
        $res = mysqli_query($con, $sql);

        if (mysqli_num_rows($res) > 0) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        }
    }

//    if (isset($new_lot['cat_id'])) {
//        $new_lot['cat_id'] = sql_get_lot_cat_id($con, $new_lot['cat_id']);
//        if ($new_lot['cat_id'] == null) {
//            $errors['cat_id'] = "Выбрана неверная категория";
//        }
//    } else {
//        $errors['cat_id'] = "Выбрана неверная категория";
//    };
//
//    if (isset($new_lot['dt_end'])) {
//        if (!is_date_valid($new_lot['dt_end'])) {
//            $errors['dt_end'] = "Указана неверный формат даты";
//        }
//    } else {
//        $errors['dt_end'] = "Дата окончания лота не указана";
//    }
//
//    if (!empty($_FILES['image']['name'])) {
//        $filename = uniqid() . '.jpg';
//        $new_lot['image'] = 'uploads/' . $filename;
//        move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $filename);
//    } else {
//        $errors['image'] = "Вы не загрузили файл";
//    }

    if (count($errors)) {
        $page_content = include_template('sign-up.php', [
            'category_description' => $category_description,
            'errors' => $errors
        ]);
        $title = 'Ошибка добавления пользователя';
    } else {
        $new_user['password'] = password_hash($new_user['password'], PASSWORD_DEFAULT);
        var_dump($new_user);

        $sql = 'INSERT INTO users (email, username, password, contact, dt_registration) VALUES (?, ?, ?, ?, NOW())';
        $stmt = db_get_prepare_stmt($con, $sql, $new_user);
        $res = mysqli_stmt_execute($stmt);

        if ($res && empty($errors)) {
            header("Location: /enter.php");
            exit();
        }
    }

}
else {
    if ($category_description) {
        $page_content = include_template('sign-up.php', [
            'category_description' => $category_description
        ]);
        $title = "Добавление нового пользователя";
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
