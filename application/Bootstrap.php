<?php
/**
 * Description
 *
 * @file Bootstrap.php
 * @date 2014-03-31 14:33:25
 * @author FtMan <gianjason@gmail.com>
 * @copyright (c) 2014 Jason Gian
 */
use \Easy;

class Bootstrap extends Yaf\Bootstrap_Abstract {

    /* {{{ function _initLog(Yaf_Dispatcher $dispatcher)  */
    function _initLog(Yaf\Dispatcher $dispatcher) {
        \Easy\Log::token(mt_rand());
        $objReq = $dispatcher->getRequest();
        \Easy\Log::trace("Incoming Request", array(
                        $objReq->getMethod() => $objReq->getRequestUri(),
                        "_GET" => $objReq->getQuery(),
                        "_POST" => $objReq->getPost(),
                        ));
    }
    /* }}} */

    /* {{{ function _initDatabase(Yaf_Dispatcher $dispatcher)  */
    function _initDatabase(Yaf\Dispatcher $dispatcher) {

        $arrConf = Yaf\Application::app()->getConfig()->get("db")->toArray();
        $db = Db::factory($arrConf);
        \Yaf\Registry::set($arrConf['instance'], $db);
    }
    /* }}} */

    /* {{{ function _initView(Yaf_Dispatcher $dispatcher)  */
    function _initView(Yaf\Dispatcher $dispatcher) {
        $dispatcher->disableView();
    }
    /* }}} */

}

/* vim: set ts=4 sw=4 sts=4 tw=100 et: */
