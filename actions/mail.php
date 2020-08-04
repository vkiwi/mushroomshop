<?php
session_start();
require_once '../db/db.php'; //подключение БД

if (isset($_POST['order'])) {
    $id = 2;
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $connect->query("INSERT INTO `orderss` (username, phone, email) VALUES ('$username', '$phone', '$email')");

    $lastId = $connect->query("SELECT MAX(id) FROM `orderss` WHERE email='$email'");
    $lastId = $lastId->fetch(PDO::FETCH_ASSOC);
    $lastId = $lastId['MAX(id)'];

    $message = "<h2>Здравствуйте, ваш заказ под номером $lastId принят</h2>";
    $message .= "<h3>Состав заказа:</h3>";
    foreach ($_SESSION['cart'] as $product) {
        $message .= "<div>{$product['rus_name']} в количестве {$product['quantity']} шт.</div>";
    }
    $message .= "<p>Сумма заказа: {$_SESSION['totalPrice']} рублей</p>";

//    echo $message;

    // Для отправки HTML-письма должен быть установлен заголовок Content-type
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    //тема письма
    $subject = "Ваш заказ под номером $lastId принят";

//    mail($email, $subject, $message, $headers);

    unset($_SESSION['totalPrice']);
    unset($_SESSION['totalQuantity']);
    unset($_SESSION['cart']);
    $_SESSION['order'] = $lastId;

}

header("Location: {$_SERVER['HTTP_REFERER']}");