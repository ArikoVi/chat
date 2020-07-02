<?php

require './vendor/autoload.php';

// Setting up the data store
$dir = './data/';

$config = new \JamesMoss\Flywheel\Config($dir, array(
    'formatter' => new \JamesMoss\Flywheel\Formatter\JSON,
));

$repo = new \JamesMoss\Flywheel\Repository(md5($_REQUEST['idRoom']), $config);

$shouts = $repo->query()
            ->where('id', '==', $_REQUEST['idMess'])
            ->execute();

$i = 0;
foreach($shouts as $old) {
    $repo->delete($old->id);
}

exit('ok');

?>
