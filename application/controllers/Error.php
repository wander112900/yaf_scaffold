<?php
/**
 * Description
 *
 * @file Error.php
 * @date 2014-03-31 15:46:30
 * @author FtMan <gianjason@gmail.com>
 * @copyright (c) 2014 Jason Gian
 */
use \Easy;
class ErrorController extends Yaf\Controller_Abstract {

    /* {{{ public function init()  */
    public function init() {
        Yaf\Dispatcher::getInstance()->disableView();
    }
    /* }}} */

    /* {{{ protected function _redirect(Exception_RedirectModel $e)  */
    protected function _redirect(Exception_RedirectModel $e) {
        $strRedirect = $e->redirect ? $e->redirect : Easy_Util::webroot();
        header("Location: {$strRedirect}");
        echo <<<HTML
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>Redirect</title>
</head><body>
<h1>Redirecting ...</h1>
<p>If your browser is not responding, please click <a href="{$strRedirect}">here</a>.</p>
</body></html>
HTML;
    }
    /* }}} */

    /* {{{ protected function _404()  */
    protected function _404() {
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
        echo <<<HTML
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL {$_SERVER["REQUEST_URI"]} was not found on this server.</p>
</body></html>
HTML;
    }
    /* }}} */

    /* {{{ protected function _500()  */
    protected function _500() {
        header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error");
        echo <<<HTML
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>500 Internal Server Error</title>
</head><body>
<h1>Internal Server Error</h1>
<p>The server encountered an internal error or
misconfiguration and was unable to complete
your request.</p>
<p>Please contact the server administrator, 
 and inform them of the time the error occurred,
and anything you might have done that may have
caused the error.</p>
<p>More information about this error may be available
in the server error log.</p>
</body></html>
HTML;
    }
    /* }}} */

    /* {{{ public function errorAction($exception)  */
    public function errorAction($exception) {
        switch($exception->getCode()) {
            case YAF\ERR\NOTFOUND\MODULE:
            case YAF\ERR\NOTFOUND\CONTROLLER:
            case YAF\ERR\NOTFOUND\ACTION:
            case YAF\ERR\NOTFOUND\VIEW:
                \Easy\Log::debug("HTTP404 on Uncaught exception", $exception->getMessage());
                //404
                $this->_404();
                return ;
            default:
                Easy_Log::fatal("[FIXME] HTTP500 on Uncaught exception", $exception->getMessage());
                $this->_500();
                return;
        }
    }
    /* }}} */

}

/* vim: set ts=4 sw=4 sts=4 tw=100 et: */
