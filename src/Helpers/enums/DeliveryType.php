<?php

namespace Helte\DevTools\Helpers\enums;

abstract class DeliveryType extends Enum {
    const EXPRESS = 'express';
    const AVAILABLE_FOR_IMEDIATE_DELIVERY = 'available_for_imediate_delivery';
    const PROVISIONED = 'provisioned';
}