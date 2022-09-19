<?php

namespace Helte\DevTools\Helpers\enums;

abstract class OrderStatus extends Enum {
    const CANCELED = 0;
    const BUDGET = 1;
    const WAITING_PAYMENT = 2;
    const IN_PROGRESS = 3;
    const FINISHED = 4;
    const WAITING_VALIDATION = 5;
}
