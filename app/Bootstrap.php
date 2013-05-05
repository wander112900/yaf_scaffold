<?php

class Bootstrap extends \Yaf\Bootstrap_Abstract {

    protected $_config;

    public function _initErrorHandler(Yaf\Dispatcher $dispatcher) {
        $dispatcher->setErrorHandler(array(get_class($this), 'error_handler'));
    }

    public function _initConfig(Yaf\Dispatcher $dispatcher) {
        $this->_config = Yaf\Application::app()->getConfig();
    }

    public function _initCache(Yaf\Dispatcher $dispatcher) {
        $driver = $this->_config->get('cache.driver');
        Cache::driver($driver);
    }

    public function _initDatabase(Yaf\Dispatcher $dispatcher) {
        $arrConf = $this->_config->get('db')->toArray();
        $db = Db::factory($arrConf);
        \Yaf\Registry::set($arrConf['instance'], $db);
    }

    public function _initPlugins(Yaf\Dispatcher $dispatcher) {
        $dispatcher->registerPlugin(new LogPlugin());

        $this->_config->application->protect_from_csrf &&
                $dispatcher->registerPlugin(new AuthTokenPlugin());
    }

    public function _initRoute(Yaf\Dispatcher $dispatcher) {
        $config = new Yaf\Config\Ini(APP_PATH . '/config/routing.ini');
        $dispatcher->getRouter()->addConfig($config);
    }

    /**
     * Custom init file for modules.
     *
     * Allows to load extra settings per module, like routes etc.
     */
    public function _initModules(Yaf\Dispatcher $dispatcher) {
        $app = $dispatcher->getApplication();

        $modules = $app->getModules();
        foreach ($modules as $module) {
            if ('index' == strtolower($module))
                continue;

            require_once $app->getAppDirectory() . "/modules" . "/$module" . "/_init.php";
        }
    }

    public function _initLayout(Yaf\Dispatcher $dispatcher) {
        $layout = new Layout($this->_config->application->layout->directory);
        $dispatcher->setView($layout);
    }

    /**
     * Custom error handler.
     *
     * Catches all errors (not exceptions) and creates an ErrorException.
     * ErrorException then can caught by Yaf\ErrorController.
     *
     * @param integer $errno   the error number.
     * @param string  $errstr  the error message.
     * @param string  $errfile the file where error occured.
     * @param integer $errline the line of the file where error occured.
     *
     * @throws ErrorException
     */
    public static function error_handler($errno, $errstr, $errfile, $errline) {
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }

}
