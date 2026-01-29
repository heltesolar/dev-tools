<?php

namespace Helte\DevTools\Traits;

use Helte\DevTools\Services\PalletService;

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

    public function calculatePalletsData(){
        $module = $this->products()->where('category_id',2)->first();
        if($module){
            $service = new PalletService();
            
            $solo_product = empty($this->id) ? $this->products->where('category_id',10)->first() : $this->products()->where('category_id',10)->first();
            $is_solo_structure = $solo_product !== null;       

            return $service->calculatePalletsData($module->id, $module->pallets_data, $module->pivot->quantity, $is_solo_structure);
        }
        return null;
    }
}