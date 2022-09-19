<?php

namespace Helte\DevTools\Helpers\constants;

class VehicleRequestRequirements {
    private const STATE_INITIALS_TO_REQUIREMENTS_MAP = [
        'AC' => ['uf', 'plate', 'renavam'],
        'AL' => ['uf', 'plate', 'renavam'],
        'AM' => ['uf', 'renavam'],
        'AP' => ['uf', 'plate', 'renavam'],
        'BA' => ['uf', 'renavam'],
        'CE' => ['uf', 'plate', 'renavam'],
        'DF' => ['uf', 'plate', 'renavam'],
        'ES' => ['uf', 'plate', 'renavam'],
        'GO' => ['uf', 'plate', 'renavam'],
        'MA' => [],
        'MG' => [],
        'MS' => ['uf', 'plate'],
        'MT' => ['uf', 'plate', 'renavam'],
        'PA' => ['uf', 'plate', 'renavam'],
        'PB' => ['uf', 'plate'],
        'PE' => ['uf', 'plate'],
        'PI' => [],
        'PR' => ['uf', 'renavam'],
        'RJ' => ['uf', 'plate'],
        'RN' => ['uf', 'plate', 'renavam'],
        'RO' => ['uf', 'plate', 'renavam'],
        'RR' => [],
        'RS' => ['uf', 'plate', 'renavam'],
        'SC' => [],
        'SE' => [],
        'SP' => [],
        'TO' => ['uf', 'plate', 'renavam'],
    ];

    public static function getRequestBody($uf) {
        return self::STATE_INITIALS_TO_REQUIREMENTS_MAP[strtoupper($uf)];
    }
} 