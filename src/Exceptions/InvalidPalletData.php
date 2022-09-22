<?php

namespace Helte\DevTools\Exceptions;

use Exception;

class InvalidPalletData extends Exception
{   
    public function __construct(private $pallet_data)
    {
        
    }

    public function context()
    {
        return [
            'product_id' => $this->product_id,
            'pallet_data' => $this->pallet_data
        ];
    }
}
