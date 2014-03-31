<?php
/**
 * Description
 *
 * @file Api.php
 * @date 2014-03-31 15:25:05
 * @author FtMan <gianjason@gmail.com>
 * @copyright (c) 2014 Jason Gian
 */

use \Easy;

class ApiController extends Yaf\Controller_Abstract {

    /* {{{ public function init()  */
    public function init() {
        /* Initialize action controller here */
        header("Content-Type: application/json; charset=utf-8");
    }
    /* }}} */

    /* {{{ public function indexAction()  */
    public function indexAction() {

        header("Location: ".\Easy\Util::webroot("/"));
        
    }
    /* }}} */

}

/* vim: set ts=4 sw=4 sts=4 tw=100 et: */
