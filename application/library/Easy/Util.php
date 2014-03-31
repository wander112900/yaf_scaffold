<?php
/**
 * Description
 *
 * @file Util.php
 * @date 2014-03-31 14:58:08
 * @author FtMan <gianjason@gmail.com>
 * @copyright (c) 2014 Jason Gian
 */

namespace Easy;

class Util {

    public static function getClientIP() /* {{{ */
    {
        if( isset($_SERVER['HTTP_X_FORWARDED_FOR']) )
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        elseif( isset($_SERVER['HTTP_CLIENTIP']) )
        {
            $ip = $_SERVER['HTTP_CLIENTIP'];
        }
        elseif( isset($_SERVER['REMOTE_ADDR']) )
        {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        elseif( getenv('HTTP_X_FORWARDED_FOR') )
        {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif( getenv('HTTP_CLIENTIP') )
        {
            $ip = getenv('HTTP_CLIENTIP');
        }
        elseif( getenv('REMOTE_ADDR') )
        {
            $ip = getenv('REMOTE_ADDR');
        }
        else
        {
            $ip = '127.0.0.1';
        }

        $pos = strpos($ip, ',');
        if( $pos > 0 )
        {
            $ip = substr($ip, 0, $pos);
        }

        return trim($ip);
    }
    /* }}} */

    protected static $_webroot = NULL;
    public static function webroot($strUri = "") /* {{{ */
    {
        if (self::$_webroot === NULL) {
            self::$_webroot = \Yaf\Application::app()->getConfig()->get("env.webroot");
            if (empty(self::$_webroot)) self::$_webroot = "http://".$_SERVER["HTTP_HOST"]."/";
        }
        return rtrim(self::$_webroot, "/") . "/" . ltrim($strUri, "/");
    }
    /* }}} */

    protected static $_pubroot = NULL;
    protected static $_version = NULL;
    public static function pubroot($strUri = "") /* {{{ */
    {
        if (self::$_pubroot === NULL) {
            self::$_pubroot = \Yaf\Application::app()->getConfig()->get("env.pubroot");
            if (empty(self::$_pubroot)) {
                self::$_pubroot = rtrim(self::webroot(), "/")."/public";
            }
        }
        if (self::$_version === NULL) {
            self::$_version = \Yaf\Application::app()->getConfig()->get("env.version");
            if (empty(self::$_version)) self::$_version = date("Ymd");
        }
        return rtrim(self::$_pubroot, "/") . "/" . ltrim($strUri, "/") . "?v=" . self::$_version;
    }
    /* }}} */

    /* {{{ public static function explain(Exception $e)  */
    public static function explain(Exception $e) {
        return sprintf("[%s] %s", gettype($e), $e->getMessage());
    }
    /* }}} */

    /* {{{ public static function date($strFormat, $strZone="+00:00", $mixTime="now")  */
    public static function date($strFormat, $strZone="+00:00", $mixTime="now") {

        if (preg_match("/^[+-]\\d\\d:\\d\\d$/", $strZone)) {
            $objTemp = new DateTime($strZone);
            $intOffset = $objTemp->getOffset();
        } else {
            Easy_Log::notice("Bad timezone", $strZone);
            $strZone = "+00:00";
            $intOffset = 0;
        }

        $intTime = is_string($mixTime) ? strtotime($mixTime) : intval($mixTime);
        $intTime += $intOffset;
        $strTime = date("Y-m-d\TH:i:s", $intTime) . $strZone;
        $objTime = new DateTime($strTime);
        return $objTime->format($strFormat);

    }
    /* }}} */

}
