<?php namespace Cache; use Closure;

class Cache {

    /**
     * All of the active cache drivers.
     *
     * @var array
     */
    public static $drivers = array();

    /**
     * The third-party driver registrar.
     *
     * @var array
     */
    public static $registrar = array();

    /**
     * Get a cache driver instance.
     *
     * If no driver name is specified, the default will be returned.
     *
     * <code>
     *		// Get the default cache driver instance
     *		$driver = Cache::driver();
     *
     *		// Get a specific cache driver instance by name
     *		$driver = Cache::driver('memcached');
     * </code>
     *
     * @param  string        $driver
     * @return Cache\Drivers\Driver
     */
    public static function driver($driver = null)
    {
        if (is_null($driver)) $driver = \Yaf\Application::app()->getConfig()->get('cache.driver');

        if ( ! isset(static::$drivers[$driver]))
        {
            static::$drivers[$driver] = static::factory($driver);
        }

        return static::$drivers[$driver];
    }

    /**
     * Create a new cache driver instance.
     *
     * @param  string  $driver
     * @return Cache\Drivers\Driver
     */
    protected static function factory($driver)
    {
        if (isset(static::$registrar[$driver]))
        {
            $resolver = static::$registrar[$driver];

            return $resolver();
        }

        switch ($driver)
        {
        case 'memcached':
            return new Drivers\Memcached(Memcached::connection(),
            \Yaf\Application::app()->getConfig()->get('cache.key'));
        default:
            throw new \Exception("Cache driver {$driver} is not supported.");
        }
    }

    /**
     * Register a third-party cache driver.
     *
     * @param  string   $driver
     * @param  Closure  $resolver
     * @return void
     */
    public static function extend($driver, Closure $resolver)
    {
        static::$registrar[$driver] = $resolver;
    }

    /**
     * Magic Method for calling the methods on the default cache driver.
     *
     * <code>
     *		// Call the "get" method on the default cache driver
     *		$name = Cache::get('name');
     *
     *		// Call the "put" method on the default cache driver
     *		Cache::put('name', 'Taylor', 15);
     * </code>
     */
    public static function __callStatic($method, $parameters)
    {
        return call_user_func_array(array(static::driver(), $method), $parameters);
    }

}
