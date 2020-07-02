<?php

require_once "./model/connection.php";

if (isset($_GET['idRoom'])) {
    $link = mysqli_connect(HOST, USER, PASS, DB) or die ("не удалось подключиться к серверу");

    $idRoom = $_GET['idRoom'];

    mysqli_query($link, "DELETE FROM rooms WHERE id='$idRoom'") or die("Ошибка " . mysqli_error($link));
    mysqli_query($link, "DELETE FROM rooms_users WHERE rooms='$idRoom'") or die("Ошибка " . mysqli_error($link));

    if (is_dir("data/" . md5($idRoom))) {
        removeDirectory("data/" . md5($idRoom));
    }

    mysqli_close($link);

    exit("ok");
} else {
    exit("Ошибка удаления!");
}

function removeDirectory($dir) {
    if ($objs = glob($dir."/*")) {
       foreach($objs as $obj) {
         is_dir($obj) ? removeDirectory($obj) : unlink($obj);
       }
    }
    rmdir($dir);
  }

?>
