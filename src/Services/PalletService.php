<?php

namespace Helte\DevTools\Services;

use Exception;
use Helte\DevTools\Models\Pallet;

class PalletService{

    public function calculatePalletsData($product_id,$pallets_data, $qtd, $is_solo_structure = false){
        if(is_null($pallets_data) || in_array(0, $pallets_data) || in_array(null,$pallets_data)){
            throw new Exception('Pallets Data inválido em produto: '.$product_id);
        }
        $pallets = $this->countByPallet($pallets_data, $qtd);

        $area = $this->sumPalletsArea($pallets, $is_solo_structure, $qtd);

        $data = $this->renderPalletsData($pallets);

        return [
            'area' => $area,
            'data' => $data
        ];
    }

    public function countByPallet($pallets_data, $qtd){
        $pallets = $this->palletsByRatio($pallets_data);
        $total_product = $qtd;

        foreach($pallets as $key => $pallet){
            $amount = 0;
            $fit_number = 0;

            $fit_number = $pallets_data[$pallet->name];
            if($fit_number > $total_product){
                if($pallets->last() == $pallet){
                    $total_product = 0;
                    $amount += 1;
                }
                else{
                    $next_fit_number = $pallets_data[($pallets[$key+1])->name];
                    if($next_fit_number < $total_product && ($pallets[$key+1])->ratio < $pallet->ratio){
                        $amount += 1;
                        $total_product = 0;
                    }
                }  
            }else{
                $amount = (int)($total_product / $fit_number);
                $total_product = $total_product % $fit_number;
                if($total_product > 0){
                    if($pallets->last() == $pallet){
                        $amount += 1;
                        $total_product = 0;
                    }else{
                        $next_fit_number = $pallets_data[($pallets[$key+1])->name];
                        if($next_fit_number < $total_product && (($pallets[$key+1])->ratio < $pallet->ratio)){
                            $amount += 1;
                            $total_product = 0;
                        }
                    }
                }
            }
            $pallet->qtd = $amount;

            if($total_product == 0){
                break;
            }
        }
        
        return $pallets;
    }

    public function palletsByRatio($pallets_data){
        $pallets = Pallet::where('status',1)->whereIn('name',array_keys($pallets_data))->get(); //Todos os pallets do maior para o menor
        
        $pallets =  $pallets->map(function($pallet) use ($pallets_data){
            $pallet->ratio = $pallets_data[$pallet->name] / $pallet->size;
            return $pallet;
        });
        return $pallets->sortByDesc('size');
    }

    public function sumPalletsArea($pallets, $is_solo_structure = false, $qtd = 0){
        $total_pallets = $pallets->sum('qtd');

        $should_stack = true;
        $total_area = 0;

        foreach($pallets as $pallet){
            if(isset($pallet->qtd) && $pallet->qtd){
                if($should_stack && $pallet->stackable){
                    if($pallet->qtd == $total_pallets && ($pallet->qtd % 2 == 0)){
                        $stacked = $pallet->qtd - 2;
                        $total_area = $pallet->size * (((int) ($stacked / 2)) + 2);
                    }else{
                        $total_area += $pallet->size * ((((int) ($pallet->qtd / 2))) + ($pallet->qtd % 2));
                    }
                    $should_stack = false;
                }else{
                    $total_area += $pallet->size * $pallet->qtd;
                }
            }
        }

        $area_in_meters = (float)($total_area/10000);
        
        if($is_solo_structure){
            $additional_meters = $this->calculateSoloStructureMeters($qtd);
            $area_in_meters += $additional_meters;
        }

        return $area_in_meters;
    }

    private function calculateSoloStructureMeters($qtd){
        if($qtd <= 4){
            return 0;
        }
        
        if($qtd > 4 && $qtd <= 40){
            return 4.8;
        }
        
        $multiples = (int)($qtd / 40);
        return $multiples * 4.8;
    }

    private function renderPalletsData($pallets){
        $pallets = $pallets->sortByDesc('size');
        return $pallets->mapWithKeys(function($pallet) {
            return [$pallet->name => $pallet->qtd ?? 0];
        });
    }
}