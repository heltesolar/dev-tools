<?php

namespace Helte\DevTools\Helpers\enums;

// referente ao campo IdForma (forma de pagamento) do Try
abstract class IdForma extends Enum {
    const INVOICE = [
        'TRIANGULATION' => 27,
        'INSTALLMENT' => [
            '2X' => 29,
            '3X' => 30,
            '4X' => 31
        ],
        'DEFAULT' => 7
    ];
    const FINANCING = 13;
    const REDISTRIBUTOR = 28;
}
