<?php
declare(strict_types=1);

require "../autoload.php";

$couverture=Couverture::createFromId((int)($_GET['id']));
header("Content-type: image/png");
echo $couverture->getPng();