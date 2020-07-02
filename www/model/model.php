<?php
require_once "connection.php";//подкл БД

if ($_POST['submit']) {
    if(!$_POST['login'] == "" && !$_POST['email'] == "" && !$_POST['pass'] == "") {
        $login = $_POST['login'];
        $login = htmlspecialchars($login);//превращаем весь html код в строку
        $login = trim($login);//удаляем пробелы
        $login = stripslashes($login);//удаляем обратный слэш

        $email = $_POST['email'];
        $email = htmlspecialchars($email);//превращаем весь html код в строку
        $email = trim($email);//удаляем пробелы
        $email = stripslashes($email);//удаляем обратный слэш

        $pass = $_POST['pass'];
        $pass = htmlspecialchars($pass);
        $pass = trim($pass);
        $pass = stripslashes($pass);
        $pass = md5($pass);//шифруем пароль
        $pass = strrev($pass);// для надежности добавим реверс
        $pass = $pass."wwqwq";//добавляем соль
        $pass = md5($pass);

        $link = mysqli_connect(HOST, USER, PASS, DB) or die ("не удалось подключиться к серверу");

        $result = mysqli_query($link, "SELECT id FROM users WHERE login='$login'") or die("Ошибка " . mysqli_error($link));
        if($result) {
            $myrow = mysqli_fetch_array($result);
            if (!empty($myrow['id'])) {
                exit('логин уже существует');
            } else {
                //если такого нет, то сохраняем данные
                $result2 = mysqli_query($link, "SELECT COUNT(*) FROM users");
                if ($result2) {
                    $myrow2 = mysqli_fetch_array($result2);
                    $id = $myrow2['COUNT(*)'] + 1;

                    mysqli_query($link, "INSERT INTO users (id, login, email, password) VALUES('$id', '$login', '$email', '$pass')") or die("Ошибка " . mysqli_error($link));
                }
            }
        }

        mysqli_close($link);
    } else {
        exit('Не все поля заполнены!');
    }
} else {
    exit('Ошибка URL!');
}

exit('ok');

?>
