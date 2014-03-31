<?php
/**
 * Description
 *
 * @file index.php
 * @date 2014-03-31 17:31:45
 * @author FtMan <gianjason@gmail.com>
 * @copyright (c) 2014 Jason Gian
 */

define('APPLICATION_PATH', dirname(__FILE__));

$application = new \Yaf\Application( APPLICATION_PATH . "/conf/application.ini");

$application->bootstrap()->run();

/* vim: set ts=4 sw=4 sts=4 tw=100 et: */
