<?php

require_once "./model/connection.php";

if (isset($_POST['submit'])) {
    if(!$_POST['login'] == "" && !$_POST['idRoom'] == "") {
        $login = $_POST['login'];
        $login = htmlspecialchars($login);//превращаем весь html код в строку
        $login = trim($login);//удаляем пробелы
        $login = stripslashes($login);//удаляем обратный слэш

        $idRoom = $_POST['idRoom'];
        $idRoom = htmlspecialchars($idRoom);//превращаем весь html код в строку
        $idRoom = trim($idRoom);//удаляем пробелы
        $idRoom = stripslashes($idRoom);//удаляем обратный слэш

        $link = mysqli_connect(HOST, USER, PASS, DB) or die ("не удалось подключиться к серверу");

        $result = mysqli_query($link, "SELECT id FROM users WHERE login='$login'") or die("Ошибка " . mysqli_error($link));
        if ($result) {
            $myrow = mysqli_fetch_array($result);

            $userId = $myrow['id'];

            if (isset($userId)) {
                mysqli_query($link, "DELETE FROM rooms_users WHERE rooms='$idRoom' AND users='$userId'") or die("Ошибка " . mysqli_error($link));
            } else {
                exit ('no');
            }
        }

        mysqli_close($link);

        exit('ok');
    }
}

?>
