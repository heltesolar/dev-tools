<?php

namespace Helte\DevTools\Traits;

trait HasPalletsData
{
    public function getFitPalletFullAttribute($value){
        return isset($this->pallets_data["fit_pallet_full"]) ? $this->pallets_data["fit_pallet_full"] : $value;
    }

    public function getFitPalletHalfAttribute($value){
        return isset($this->pallets_data["fit_pallet_half"]) ? $this->pallets_data["fit_pallet_half"] : $value;
    }
    
    public function getFitPalletTruncatedAttribute($value){
        return isset($this->pallets_data["fit_pallet_truncated"]) ? $this->pallets_data["fit_pallet_truncated"] : $value;
    }
}