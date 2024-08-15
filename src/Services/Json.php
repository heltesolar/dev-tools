<?php

namespace Helte\DevTools\Services;

class Json {
    /**
     * Encodes data in a readable way.
     * 
     * @param array $data
     * @return string
     */
    public static function encode($data) {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Decodes json as an associative array.
     * 
     * @param string $json
     * @return array
     */
    public static function decode($json) {
        return json_decode($json, true);
    }

    /**
     * Shortcut for encoding and decoding data.
     * 
     * @param array $data
     * @return array
     */
    public static function reencode($data) {
        return Json::encode(Json::decode($data));
    }

    /**
     * Shortcut for decoding and encoding json.
     * 
     * @param string $json
     * @return string
     */
    public static function redecode($json) {
        return Json::decode(Json::encode($json));
    }
    
    /**
     * Informs if a given string represents a valid JSON object or array.
     * 
     * @param string $string
     * @return bool
     */
    public static function isJson($string) {
        $value = json_decode($string);
        return json_last_error() === JSON_ERROR_NONE && (is_array($value) || is_object($value));
    }
}
