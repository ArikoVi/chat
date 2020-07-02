<?php

if (isset($_FILES['userfile'])) {
    $uploaddir = '../public/img/users_avatar/';
    $apend = date('YmdHis').rand(100,1000).'.jpg';
    $uploadfile = "$uploaddir$apend";

    if(($_FILES['userfile']['type'] == 'image/gif' || $_FILES['userfile']['type'] == 'image/jpeg' || $_FILES['userfile']['type'] == 'image/png')
    && ($_FILES['userfile']['size'] != 0 and $_FILES['userfile']['size'] <= 512000))
    {
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) { //Здесь идет процесс загрузки изображения
            $size = getimagesize($uploadfile); // с помощью этой функции мы можем получить размер пикселей изображения
            if ($size[0] < 501 && $size[1] < 1501) {
                exit($uploadfile);
            } else {
                unlink($uploadfile); // удаление файла
                exit("Загружаемое изображение превышает допустимые нормы (ширина не более - 500; высота не более 1500)");
            }
        } else {
            exit("Файл не загружен, вернитеcь и попробуйте еще раз");
        }
    } else {
        exit("Размер файла не должен превышать 512Кб");
    }
}

?>
