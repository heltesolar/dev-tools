<?php

namespace Helte\DevTools\Services;

use Exception;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Client;

class HttpApiClient {
    public static function call($endpoint, $method = 'GET', $body = [], $headers = [], $params = [], $http_errors = true, $body_type = 'json') {
        $available_body_types = ['json', 'form_params', 'multipart'];
        if (!in_array($body_type, $available_body_types)) {
            $body_types_string = join(', ', $available_body_types);
            throw new Exception("Body type is not in the available body types (try one of: $body_types_string)");
        }

        $body_map = [
            'json' => 'application/json',
            'multipart' => 'multipart/form-data',
            'form_params' => 'application/x-www-form-urlencoded'
        ];

        $default_headers = [
            'accept' => 'application/json',
            'content-type' => $body_map[$body_type]
        ];

        // Force lowercase headers
        $headers = collect($headers)->mapWithKeys(function ($value, $key) {
            return [strtolower($key) => $value];
        })->toArray();

        // Merge options
        $headers = array_merge($default_headers, $headers);

        $method = strtoupper($method);

        $available_methods = ['HEAD', 'GET', 'POST', 'PUT', 'PATCH', 'DELETE'];
        if (!in_array($method, $available_methods)) {
            $methods_string = join(', ', $available_methods);
            throw new Exception("Method is not in the available methods (try one of: $methods_string)");
        }

        $methods_with_body = ['POST', 'PUT', 'PATCH'];
        $has_body = in_array($method, $methods_with_body);

        $guzzle_options = [
            'headers' => $headers,
            'verify' => Env::isEnvProduction(), // Don't require SSL certificate if .env is local
        ];

        if ($has_body) {
            $guzzle_options[$body_type] = $body;
        }

        if ($http_errors) {
            $guzzle_options['http_errors'] = true;
        }

        $query_string = http_build_query($params);

        if ($query_string != "") {
            $query_string = "?$query_string";
        }

        $debug_log = '';
        $should_debug = Env::isEnvLocal() ? env('LOG_LOCAL_REQUESTS') : false;

        if ($should_debug) {
            $debug_log .= PHP_EOL . '---------- REQUEST ----------' . PHP_EOL . PHP_EOL;
            $debug_log .= urldecode($method . ' ' . $endpoint . $query_string) . PHP_EOL;
            $debug_log .= 'Headers:' . PHP_EOL;
            $debug_log .= Json::encode($headers) . PHP_EOL;

            if ($has_body) {
                $debug_log .= 'Body type:' . PHP_EOL;
                $debug_log .= $body_type . PHP_EOL;
                $debug_log .= 'Body:' . PHP_EOL;
                $debug_log .= Json::encode($body) . PHP_EOL;
            }
        }

        try {
            $client = new Client($guzzle_options);

            $response = $client->request($method, $endpoint . $query_string);

            $response_situation = $response->getStatusCode() < 400 ? 'SUCCESS' : 'ERROR';

            if ($should_debug) {
                $debug_log .= PHP_EOL . "---------- RESPONSE $response_situation ----------" . PHP_EOL . PHP_EOL;
                $debug_log .= 'Status: ' . PHP_EOL;
                $debug_log .= $response->getStatusCode() . PHP_EOL;

                $debug_log .= 'Body: ' . PHP_EOL;
                $response_body = $response->getBody()->getContents();
                $response->getBody()->rewind();
                $debug_log .= (Json::isJson($response_body) ? Json::reencode($response_body) : $response_body);
            }
        }
        catch (BadResponseException $e) {
            if ($should_debug) {
                $debug_log .= PHP_EOL . "---------- RESPONSE ERROR ----------" . PHP_EOL . PHP_EOL;
                $debug_log .= 'Status: ' . PHP_EOL;
                $debug_log .= $e->getResponse()->getStatusCode() . PHP_EOL;

                $debug_log .= 'Body: ' . PHP_EOL;
                $response_body = $e->getResponse()->getBody();
                $debug_log .= (Json::isJson($response_body) ? Json::reencode($response_body) : $response_body);
            }

            throw $e;
        }
        catch (ConnectException $e) {
            $debug_log .= 'Could not connect to host';
        }
        finally {
            if ($should_debug) {
                $debug_log .= PHP_EOL . PHP_EOL . str_repeat('=', 100) . PHP_EOL;
                info($debug_log);
            }
        }

        return $response ?? null;
    }

}