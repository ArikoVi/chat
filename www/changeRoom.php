<?php

require_once "./model/connection.php";

if (isset($_POST['submit'])) {
    if(isset($_POST['idRoom']) && !$_POST['idRoom'] == "") {
        $idRoom = $_POST['idRoom'];
        $idRoom = htmlspecialchars($idRoom);//превращаем весь html код в строку
        $idRoom = trim($idRoom);//удаляем пробелы
        $idRoom = stripslashes($idRoom);//удаляем обратный слэш
    }

    if(isset($_POST['title']) && !$_POST['title'] == "") {
        $title = $_POST['title'];
        $title = htmlspecialchars($title);//превращаем весь html код в строку
        $title = trim($title);//удаляем пробелы
        $title = stripslashes($title);//удаляем обратный слэш

        $title = "title='$title',";
    }

     if(isset($_POST['descr']) && !$_POST['descr'] == "") {
        $descr = $_POST['descr'];
        $descr = htmlspecialchars($descr);//превращаем весь html код в строку
        $descr = trim($descr);//удаляем пробелы
        $descr = stripslashes($descr);//удаляем обратный слэш

        $descr = "description='$descr',";
    }

     if(isset($_POST['checkbox'])) {
        $checkbox = $_POST['checkbox'];
        $checkbox = htmlspecialchars($checkbox);//превращаем весь html код в строку
        $checkbox = trim($checkbox);//удаляем пробелы
        $checkbox = stripslashes($checkbox);//удаляем обратный слэш

        $checkbox = "private='$checkbox',";
    }

    $link = mysqli_connect(HOST, USER, PASS, DB) or die ("не удалось подключиться к серверу");

    $set = "";
    if (isset($title) || isset($descr) || isset($checkbox)) {
        $set .= "SET ".$title.$descr.$checkbox;
        $set = substr($set,0,-1);
    }

    $result = mysqli_query($link, "UPDATE rooms ".$set." WHERE id='$idRoom'") or die("Ошибка " . mysqli_error($link));

    mysqli_close($link);

    exit('ok');
}

?>
