<?php
/**
 * Description
 *
 * @file Index.php
 * @date 2014-03-31 15:25:05
 * @author FtMan <gianjason@gmail.com>
 * @copyright (c) 2014 Jason Gian
 */
use Easy;

class IndexController extends ApiController {

    public function IndexAction() {
        \Easy\Log::trace("New thread");
        header("Location: ".\Easy\Util::pubroot("/index.html"));
    }

    public function TestAction() {
    
    }
    
}

/* vim: set ts=4 sw=4 sts=4 tw=100 et: */
