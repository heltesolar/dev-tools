<?php

namespace Helte\DevTools\Exceptions;

use Exception;

class InvalidPalletData extends Exception
{   
    public $pallet_id;
    public $pallet_data;
    
    public function __construct($pallet_id, $pallet_data)
    {
        $this->pallet_id = $pallet_id;
        $this->pallet_data = $pallet_data;
    }

    public function context()
    {
        return [
            'product_id' => $this->product_id,
            'pallet_data' => $this->pallet_data
        ];
    }
}
