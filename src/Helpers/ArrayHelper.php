<?php

namespace Helte\DevTools\Helpers;

use Illuminate\Support\Arr;

class ArrayHelper {
    /**
     * en-us:
     * Updates data keys according to a given key map.
     * 
     * pt-br:
     * Atualiza chaves do array baseando-se em um mapa de chaves.
     * 
     * Ex: ArrayHelper::swapKeys(['a' => 1, 'b' => 2], ['a' => 'b'], true)  => ['b' => 1]
     * Ex: ArrayHelper::swapKeys(['a' => 1, 'b' => 2], ['a' => 'b'], false) => ['a' => 2, 'b' => 1]
     * 
     * @param array $data
     * @param array $key_map
     * @param bool $overwrite
     * @return array
     */
    public static function swapKeys($data, $key_map, $overwrite = true) {
        foreach ($data as $key => $value) {
            if (!array_key_exists($key, $key_map)) {
                continue;
            }

            $next_key = $key_map[$key];
            $next_value = $data[$next_key] ?? null;
            $data[$next_key] = $value;

            if ($overwrite) {
                unset($data[$key]);
            }
            else {
                if ($next_value === null) {
                    unset($data[$key]);
                }
                else {
                    $data[$key] = $next_value;
                }
            }
        }

        return $data;
    }

    /**
     * Removes all null values from a given array.
     * 
     * @param array $data
     * @return array
     */
    public static function dropNull($data)
    {
        $result = [];

        foreach ($data as $key => $value) {
            if ($value !== null) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * Removes all empty string values from a given array.
     * 
     * @param array $data
     * @return array
     */
    public static function dropEmpty($data)
    {
        $result = [];

        foreach ($data as $key => $value) {
            if ($value !== '') {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * Similar to Arr::only, but requires all keys to be present.
     * Throws exception rather than returning fallback value.
     * 
     * @param array $array
     * @param array $keys
     * @return array
     * @throws Throwable
     */
    public static function safeOnly($array, $keys) {        
        $subset = Arr::only($array, $keys);

        throw_if(count($keys) != count($subset), 'Expected data array keys to be a superset of keys array values');

        return $subset;
    }

    /**
     * Similar to Arr::except, but expects an array with subarrays to be filtered rather than one dimensional array.
     * 
     * @param Array<array> $array
     * @param array $keys
     * @return Array<array>
     */
    public static function exceptMany($array, $keys) {
        $result = [];

        foreach ($array as $sub_key => $sub_array) {
            $result[$sub_key] = Arr::except($sub_array, $keys);
        }

        return $result;
    }

    /**
     * Similar to Arr::only, but expects an array with subarrays to be filtered rather than one dimensional array.
     * 
     * @param Array<array> $array
     * @param array $keys
     * @return Array<array>
     */
    public static function onlyMany($array, $keys) {
        $result = [];

        foreach ($array as $sub_key => $sub_array) {
            $result[$sub_key] = Arr::only($sub_array, $keys);
        }

        return $result;
    }

    /**
     * Map search that rather than finding value by key, finds key by value.
     * 
     * @param array $array
     * @param mixed $target_value
     * @return mixed|null
     */
    public static function findKeyByValue($array, $target_value) {
        foreach ($array as $key => $value) {
            if ($value === $target_value) {
                return $key;
            }
        }

        return null;
    }

    /**
     * Map search that rather than finding value by key, finds key by value. 
     * Throws exception rather than returning fallback value.
     * 
     * @param array $array
     * @param mixed $target_value
     * @return mixed|null
     */
    public static function safeFindKeyByValue($array, $target_value) {
        $result = static::findKeyByValue($array, $target_value);

        throw_if($result === null, "Given value '$target_value' didn't match any value in given array");

        return $result;
    }

    /**
     * Check if two arrays are equal.
     * 
     * @param array $array1
     * @param array $array2
     * @return bool
     */
    public static function areEqual($array1, $array2) {
        if (count($array1) != count($array2)) {
            return false;
        }

        foreach ($array1 as $key1 => $value1) {
            if (!array_key_exists($key1, $array2)) {
                return false;
            }

            $value2 = $array2[$key1];
            if ($value1 !== $value2) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if two arrays have the same values with same count independently from order.
     * 
     * @param array $array1
     * @param array $array2
     * @return bool
     */
    public static function areEqualIgnoreOrder($array1, $array2) {
        if (count($array1) != count($array2)) {
            return false;
        }

        $count_map1 = array_count_values($array1);
        $count_map2 = array_count_values($array2);

        return static::areEqual($count_map1, $count_map2);
    }

    /**
     * Check if two arrays are different.
     * 
     * @param array $array1
     * @param array $array2
     * @return bool
     */
    public static function areDifferent($array1, $array2) {
        return !static::areEqual($array1, $array2);
    }
}
