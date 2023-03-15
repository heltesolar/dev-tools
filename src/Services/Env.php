<?php

namespace Helte\DevTools\Services;

class Env{
    /**
     * Returns whether or not current environment is production
     *
     * @return bool
     */
    public static function isEnvProduction()
    {
        return !self::isEnvTesting() && !self::isEnvStaging() && !self::isEnvLocal();
    }

    /**
     * Returns whether or not current environment is testing
     *
     * @return bool
     */
    public static function isEnvTesting()
    {
        return app()->environment() === 'testing';
    }
    
    
   
    /**
     * Returns whether or not current environment is staging
     *
     * @return bool
     */
    public static function isEnvStaging()
    {
        return app()->environment() === 'staging';
    }
    
    /**
     * Is Env Local
     *
     * Returns whether or not current environment is local
     *
     * @return bool
     */
    public static function isEnvLocal()
    {
        return in_array(app()->environment(), ["local", "dev"]);
    }
    
}
