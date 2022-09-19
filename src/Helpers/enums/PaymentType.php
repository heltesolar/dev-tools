<?php

namespace Helte\DevTools\Helpers\enums;

abstract class PaymentType extends Enum {
    const FINANCING = 0;
    const BILLET = 1;
    const CREDIT_CARD = 2;
}
