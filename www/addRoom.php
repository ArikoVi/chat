<?php

require_once "./model/connection.php";

if (isset($_POST['submit'])) {
    if(!$_POST['title'] == "" && !$_POST['descr'] == "" && isset($_POST['checkbox'])) {
        $title = $_POST['title'];
        $title = htmlspecialchars($title);//превращаем весь html код в строку
        $title = trim($title);//удаляем пробелы
        $title = stripslashes($title);//удаляем обратный слэш

        $descr = $_POST['descr'];
        $descr = htmlspecialchars($descr);//превращаем весь html код в строку
        $descr = trim($descr);//удаляем пробелы
        $descr = stripslashes($descr);//удаляем обратный слэш

        $checkbox = $_POST['checkbox'];
        $checkbox = htmlspecialchars($checkbox);//превращаем весь html код в строку
        $checkbox = trim($checkbox);//удаляем пробелы
        $checkbox = stripslashes($checkbox);//удаляем обратный слэш

        $link = mysqli_connect(HOST, USER, PASS, DB) or die ("не удалось подключиться к серверу");

        $result = mysqli_query($link, "SELECT MAX(id) FROM rooms") or die("Ошибка " . mysqli_error($link));
        if ($result) {
            $myrow = mysqli_fetch_array($result);

            $lastId = $myrow['MAX(id)'] + 1;

            mysqli_query($link, "INSERT INTO rooms VALUES ($lastId, '$title', '$descr', $checkbox)") or die("Ошибка " . mysqli_error($link));
        }

        mysqli_close($link);

        exit('ok');
    }
}

?>
