<?php
/**
 * Description
 *
 * @file Home.php
 * @date 2014-03-31 16:39:44
 * @author FtMan <gianjason@gmail.com>
 * @copyright (c) 2014 Jason Gian
 */
use \Easy;
class HomeController extends ApiController {

    public function IndexAction() {
        $mdl = new ParamModel();
        $arrData = $mdl->sql("select * from select_param where 1");
        $arrRet = array();
        echo \Easy\Ajax::ajax($arrData);
    }
}

/* vim: set ts=4 sw=4 sts=4 tw=100 et: */
