<?php

if (isset($_POST['dir'])) {
    $uploaddir = '../public/img/users_avatar/';
    $id = md5($_POST['id']);
    $uploadfile = $_POST['dir'];

    if (file_exists($uploaddir.$id.".jpg")) {
        unlink($uploaddir.$id.".jpg");
    }

    rename($uploadfile, $uploaddir.$id.".jpg");

    exit("Аватар успешно добавлен");
}

?>
