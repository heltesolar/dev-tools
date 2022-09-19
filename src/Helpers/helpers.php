<?php

if (!function_exists('zero_pad')) {
    function zero_pad($string, $length) {
        return str_pad($string, $length, '0', STR_PAD_LEFT);
    }
}