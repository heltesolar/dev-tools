<?php

use Illuminate\Support\Facades\DB;

function defaultCache($key, $value = null){

    $cache = DB::table('default_cache')->where('key', $key)->first();
    
    //Se value não for passado, será tratado como uma consulta da configuração especificada
    if(is_null($value)){
        if(isset($cache)){
            return json_decode($cache->value);
        }
        return null;
    }

    //Se value for passado será salvo o valor na configuração especificada
    
    $c_value = json_encode($value);
    
    DB::table('default_cache')->updateOrInsert(['key'=>$key],['value'=>$c_value]);
    return true;
}
