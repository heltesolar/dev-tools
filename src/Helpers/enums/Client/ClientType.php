<?php

namespace Helte\DevTools\Helpers\enums\Client;

use Helte\DevTools\Helpers\enums\Enum;

/**
 * Database reference: app.clients.type
 * 
 * As of 2022-01-21 - BEWARE: database usually holds null as FINAL_CLIENT value.
 */
abstract class ClientType extends Enum {
    const FINAL_CLIENT = 0;
    const INTEGRATOR = 1;
}
