<?php
session_start();//запускаем сессию
require_once "connection.php";//подкл БД

if ($_POST['signin']) {//если нажата кнопка
    if (!$_POST['login'] == "" && !$_POST['pass'] == "") {
        $login = $_POST['login'];
        $login = htmlspecialchars($login);//превращаем весь html код в строку
        $login = trim($login);//удаляем пробелы
        $login = stripslashes($login);//удаляем обратный слэш

        $pass = $_POST['pass'];
        $pass = htmlspecialchars($pass);
        $pass = trim($pass);
        $pass = stripslashes($pass);

        $pass = md5($pass);//шифруем пароль
        $pass = strrev($pass);// для надежности добавим реверс
        $pass = $pass."wwqwq";//добавляем соль
        $pass = md5($pass);

        $link = mysqli_connect(HOST, USER, PASS, DB) or die ("не удалось подключиться к серверу");

        $result = mysqli_query($link, "SELECT id, COUNT(*) FROM users WHERE login = '$login' && password = '$pass'") or die (mysqli_error());
        if($result) {
            $myrow = mysqli_fetch_array($result);
            if ($myrow['COUNT(*)'] == 0) {
                exit('no');
            } else {
                $_SESSION['id'] = $myrow['id'];//создаем сессию
                $_SESSION['login'] = $login;

                if ($login == 'admin') {
                    $_SESSION['admin'] = 1;
                }

                exit('yes');
            }
        } else {//если нет такого логина
            exit('Проблемы на сервере.');
        }
        mysqli_close($link);
    }
} else {//иначе
    if ($_POST['signin_exit']) {//если нажата кнопка назад
        unset($_SESSION['id']);//удаляем сессию
        unset($_SESSION['login']);
        unset($_SESSION['admin']);
        exit('exit');
    } else {//если не нажал но как то попал на стр
        exit('Проверьте URL');
    }
}
?>
