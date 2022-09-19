<?php

namespace Helte\DevTools\Helpers\enums;

// referente ao campo IdForma (forma de pagamento) do Try
abstract class IdCondicao extends Enum {
    const INVOICE = [
        'INSTALLMENT' => [
            '2X' => 1070,
            '3X' => 1071,
            '4X' => 1072
        ],
        'THREE_DAYS' => 1011 // 3 dias para pagar
    ];
    const SEVEN_DAYS = 1016; // 7 dias para pagar
}
