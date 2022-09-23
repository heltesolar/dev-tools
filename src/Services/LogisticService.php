<?php

namespace Helte\DevTools\Services;

use Exception;
use Helte\DevTools\Traits\HasPalletsData;

class LogisticService {

    private $logistic_object;
    private $should_save;

    public function __construct($logistic_object = null, $should_save = false)
    {
        $this->logistic_object = $logistic_object;
        $this->should_save = $should_save;
    }

    private function checkPalletsTrait(){
        if(!in_array(HasPalletsData::class, class_uses_recursive($this->logistic_object))){
            throw new Exception('Model não possui o TRAIT necessário para cálculo de pallets!');
        }
    }

    public function calculatePalletsData(){
        $this->checkPalletsTrait();

        $data = $this->logistic_object->calculatePalletsData();
        if($data){
            if($this->should_save){
                $this->logistic_object->pallets_data = $data['data'];
                $this->logistic_object->area_pallets = $data['area'];
                $this->logistic_object->save();
            }
    
            return $data;
        }
        
        return null;
    }

    public function calculateWeight(){
        $products = $this->logistic_object->products;

        if($products){
            $total_weight = 0;
            foreach ($products as $product){
                if($product->weight)
                {
                    $total_weight += $product->weight*$product->pivot->quantity;
                }
            }

            if($this->should_save){
                $this->logistic_object->weight = $total_weight;
                $this->logistic_object->save();
            }

            return $total_weight;
        }

        return null;
    }

    public function calculateVolumes(){
        $products = $this->logistic_object->products;

        if($products){
            $total_volume = 0;
            foreach($products as $product){
                $amount = $product->pivot->quantity;
                $limit = $product->fit_pallet_full;
                $volume = $limit ? ceil($amount/$limit) : 0;
                $total_volume += $volume;
            }

            if($this->should_save){
                $this->logistic_object->volumes = $total_volume;
                $this->logistic_object->save();
            }

            return $total_volume;
        }

        return null;
    }
}