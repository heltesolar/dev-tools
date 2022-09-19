<?php

namespace Helte\DevTools\Helpers\enums;

use ReflectionClass;

abstract class Enum
{
    /**
     * Returns all constants, meant to be inherited by enum classes.
     *
     * @author Henrique Frederico Trentini
     * @date 14/12/2021
     * @return array
     * @throws \ReflectionException
     */
    public static function getValues() {
        return array_values((new ReflectionClass(get_called_class()))->getConstants());
    }
}
