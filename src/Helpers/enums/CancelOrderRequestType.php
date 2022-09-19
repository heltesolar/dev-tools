<?php

namespace Helte\DevTools\Helpers\enums;

/**
 * Representa o tipo de uma requisição de cancelamento de pedido (não é status de pedido).
 * Ocorre quando o status do pedido é 3 (pagamento já foi feito) e
 * o cancelamento depende de terceiros, não sendo possível cancelar de imediato.
 */
abstract class CancelOrderRequestType extends Enum {
    const PIX = 1;
    const SAC = 2;
}
