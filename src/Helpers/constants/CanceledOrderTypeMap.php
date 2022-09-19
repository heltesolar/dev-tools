<?php

namespace Helte\DevTools\Helpers\constants;

abstract class CanceledOrderTypeMap {
    // @see app\Helpers\enums\CanceledOrderType
    const map = [
        0 => 'Outro motivo',
        1 => 'Dados do cliente final incompletos',
        2 => 'Pedido duplicado',
        3 => 'Mudança de endereço',
        4 => 'Mudança de forma de pagamento',
        5 => 'Troca de equipamento - Módulo',
        6 => 'Troca de equipamento - Inversor',
        7 => 'Troca de equipamento - Transformador',
        8 => 'Estrutura incorreta',
        9 => 'Quantidade de produto incorreta',
        10 => 'Valor da promoção de vendas incorreto',
        11 => 'Venda não confirmada',
        12 => 'Necessidade de triangulação',
        13 => 'Financiamento não aprovado',
        14 => 'Garantia não inclusa',
        15 => 'Validação incompleta/incorreta',
        16 => 'Aumento do projeto'
    ];
}
