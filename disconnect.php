<?php
declare(strict_types=1);

require "src/Utils.php";

end_php_session();
header('Location: index.php');