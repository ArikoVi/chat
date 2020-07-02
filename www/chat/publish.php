<?php

require '../vendor/autoload.php';

$dir = '../data/';

$idUser = $_POST['idUser'];

if (!is_dir($dir.md5($_POST['idRoom']))) {
    mkdir($dir.md5($_POST['idRoom']));
}

$config = new \JamesMoss\Flywheel\Config($dir, array(
    'formatter' => new \JamesMoss\Flywheel\Formatter\JSON,
));

$repo = new \JamesMoss\Flywheel\Repository(md5($_POST['idRoom']), $config);

// Store the posted shout data to the data store

if(isset($_POST["name"]) && isset($_POST["comment"])) {

    $name = htmlspecialchars($_POST["name"]);
    $name = str_replace(array("\n", "\r"), '', $name);

    $comment = htmlspecialchars($_POST["comment"]);
    $comment = str_replace(array("\n", "\r"), '', $comment);

    // Storing a new shout

    $shout = new \JamesMoss\Flywheel\Document(array(
        'idUser' => $idUser,
        'text' => $comment,
        'name' => $name,
        'createdAt' => time()
    ));

    $repo->store($shout);

}
