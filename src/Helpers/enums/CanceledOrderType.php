<?php

namespace Helte\DevTools\Helpers\enums;

/**
 * Representa o motivo que levou à um cancelamento de pedido.
 */
abstract class CanceledOrderType extends Enum {
    const OTHER = 0;
    const FINAL_CLIENT_INCOMPLETE_DATA = 1;
    const DUPLICATE_ORDER = 2;
    const ADDRESS_CHANGE = 3;
    const PAYMENT_TYPE_CHANGE = 4;
    const MODULE_CHANGE = 5;
    const INVERTER_CHANGE = 6;
    const TRANSFORMER_CHANGE = 7;
    const WRONG_STRUCTURE = 8;
    const WRONG_PRODUCT_QUANTITY = 9;
    const WRONG_SALE_PROMOTION_VALUE = 10;
    const UNCONFIRMED_SALE = 11;
    const REQUIRES_TRIANGULATION = 12;
    const UNAPPROVED_FINANCING = 13;
    const UNINCLUDED_WARRANTY = 14;
    const BAD_VALIDATION = 15;
    const PROJECT_INCREASE = 16;
}
