<?php
/**
 * Created by PhpStorm.
 * User: guoyexuan
 * Date: 2019/1/10
 * Time: 9:20 PM
 */

define('BASE_PATH',str_replace('\\','/',realpath(dirname(__FILE__).'/'))."/");

define('APP_DEBUG', true);

$config = require(BASE_PATH . '/Pengine/Core/Pengine.php');

Pengine::run();