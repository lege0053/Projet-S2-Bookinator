<?php
declare(strict_types=1);

require "../autoload.php";

$pdp=Utilisateur::createFromId((int)($_GET['id']));
header("Content-type: image/png");
echo $pdp->getPhotoProfil();