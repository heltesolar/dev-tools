<?php

namespace Helte\DevTools\Helpers\enums;

/**
 * Representa o status de uma requisição de cancelamento de pedido (não é status de pedido).
 * Ocorre quando o status do pedido é 3 (pagamento já foi feito) e
 * o cancelamento depende de terceiros, não sendo possível cancelar de imediato.
 */
abstract class CancelOrderRequestStatus extends Enum {
    const REJECTED = 0;
    const IN_PROGRESS = 1;
    const FINISHED = 2;
}
