<?php

//if (session_id() == '')
//    session_start();
if (is_file('../../vendor/autoload.php')) {
    require_once('../../vendor/autoload.php');
} else {
    require_once('../vendor/autoload.php');
}

if (is_file('../../lib/config.php')) {
    require_once('../../lib/config.php');
} else {
    require_once('../lib/config.php');
}

if (is_file('../../lib/func.global.php')) {
    require_once('../../lib/func.global.php');
} else {
    require_once('../lib/func.global.php');
}
?>