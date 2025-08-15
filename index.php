<?php

use Src\Core\Core;
use Src\Router\Routes;

require 'vendor/autoload.php';

$core = new Core();
$core->run(Routes::all());