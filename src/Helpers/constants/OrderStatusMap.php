<?php

namespace Helte\DevTools\Helpers\constants;

class OrderStatusMap {
    // @see app\Helpers\enums\OrderStatus
    const map = [
        0 => 'Cancelado',
        1 => 'Orçamento',
        2 => 'Aguardando pagamento',
        3 => 'Em progresso',
        4 => 'Finalizado',
        5 => 'Aguardando validação',
    ];
}
