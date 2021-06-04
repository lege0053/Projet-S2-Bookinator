<?php
declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";
init_php_session();



$webPage = new WebPage("Bookinator");

$content = <<<HTML

HTML;


$webPage->appendCssUrl("src/style.css");
$webPage->appendContent(getIndexHeader());
$webPage->appendContent($content);
$webPage->appendContent(getFooter());

echo $webPage->toHTML();