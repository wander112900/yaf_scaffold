# A base application for Yaf framework

Base on [Yaf](https://github.com/laruence/php-yaf)

Base on [yaf_base_application](https://github.com/akDeveloper/yaf_base_application)

## Requirements

* Yaf php extension. Download and install from [Pecl](http://pecl.php.net/package/yaf)
* PHP 5.3+
* Mysql server
* Apache, Nginx or Lighttpd web server.
* mod_rewrite and .htaccess enabled for Apache web server.
* Cache Server now just for Memcached,(redis,apc etc. will be supported soon), if you use cache lib;

## Configuration

* Info about setting up a server for Yaf can be found [here](http://www.php.net/manual/en/yaf.examples.php)
* Rename `config/application.ini.default` to `config/application.ini`
* If you have PHP 5.4 you can use the internal web server to test the project.
 * `cd yaf_base_application/public`
 * `php -S localhost:8000`
* This project uses PHP 5.3 namespaces so `yaf.use_namespace` should be turned on.
 
## Additions

* Validation library `lib/Validations` from [another project](https://github.com/akDeveloper/Lycan) of andreas or validating classes.
* A Layout class that allows to render views inside a base html layout `lib/Layout.php`. Layouts directory can be defined in application.ini
* A Logger class `lib/Logger.php` and a `LoggerPlugin` to log info about requests and database queries. (Make sure that log directory is readable.)
* A custom Request class `lib/Request.php` that extends `Yaf\Request\Http` and offers input filter for request params, posts and queries.
* An Authenticity token plugin `AuthTokenPlugin`to prevent Cross-site request forgery (csrf). Can be turned on/off from application.ini
* A base `ApplicationController` which adds some base functionality like 404 not found page.
* A `RestfullController` to make easy crud (create, read, update, delete) actions.
* An `ErrorController` to catch all exceptions and display a page with error info and bugtrace.
* Custom error_handler to catch errors and throws Exceptions.
* Custom _init.php file for modules for extra configuration.
* Some base helper classes `lib/Helper`
