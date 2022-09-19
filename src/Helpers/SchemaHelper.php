<?php

namespace Helte\DevTools\Helpers;

use Illuminate\Support\Facades\Schema;

class SchemaHelper {
    /**
     * Temporariamente desativa constraints do banco.
     * 
     * @param Closure $callback
     * @return mixed
     */
    public static function withoutForeignKeyConstraints($callback) {
        try {
            Schema::disableForeignKeyConstraints();
            return $callback();
        }
        finally {
            Schema::enableForeignKeyConstraints();
        }
    }
}
