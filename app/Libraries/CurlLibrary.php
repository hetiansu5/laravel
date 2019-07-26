<?php

namespace App\Libraries;

/**
 * Curl请求
 */
class CurlLibrary
{
    /**
     * GET请求
     *
     * @param $url
     * @param $params
     * @param array $options
     * @throws \Exception
     * @return mixed
     */
    public static function get($url, $params = [], $options = [])
    {
        $timeout = isset($options['timeout']) ? $options['timeout'] : 10;
        $connectTimeout = isset($options['connect_timeout']) ? $options['connect_timeout'] : 10;
        $headers = isset($options['headers']) ? $options['headers'] : [];

        if ($params) {
            $queryString = http_build_query($params);
            if (strpos($url, '?') === false) {
                $url .= '?' . $queryString;
            } else {
                $url .= '&' . $queryString;
            }
        }

        $opts = self::_initOpts($url, $timeout, $connectTimeout);
        $opts[CURLOPT_FOLLOWLOCATION] = 1;
        if ($headers) {
            $opts[CURLOPT_HTTPHEADER] = $headers;
        }

        return self::_curlExec($opts);
    }

    /**
     * POST请求 -- 表单模式
     *
     * @param $url
     * @param $params
     * @param array $options
     * @throws \Exception
     * @return mixed
     */
    public static function post($url, $params, $options = [])
    {
        $timeout = isset($options['timeout']) ? $options['timeout'] : 10;
        $connectTimeout = isset($options['connect_timeout']) ? $options['connect_timeout'] : 10;
        $headers = isset($options['headers']) ? $options['headers'] : [];
        $params = http_build_query($params);

        $opts = self::_initOpts($url, $timeout, $connectTimeout);
        $opts[CURLOPT_POST] = 1;
        $opts[CURLOPT_POSTFIELDS] = $params;
        if ($headers) {
            $opts[CURLOPT_HTTPHEADER] = $headers;
        }

        return self::_curlExec($opts);
    }

    /**
     * POST请求 -- application/json
     *
     * @param $url
     * @param $params
     * @param array $options
     * @throws \Exception
     * @return mixed
     */
    public static function postJsonData($url, $params, $options = [])
    {
        $timeout = isset($options['timeout']) ? $options['timeout'] : 10;
        $connectTimeout = isset($options['connect_timeout']) ? $options['connect_timeout'] : 10;
        $headers = isset($options['headers']) ? $options['headers'] : [];

        $params = json_encode($params);

        $opts = self::_initOpts($url, $timeout, $connectTimeout);
        $opts[CURLOPT_POST] = 1;
        $opts[CURLOPT_POSTFIELDS] = $params;
        $headers[] = 'Content-Type: application/json';
        $opts[CURLOPT_HTTPHEADER] = $headers;

        return self::_curlExec($opts);
    }

    /**
     * @param $url
     * @param $timeout
     * @param $connectTimeout
     * @return array
     */
    private static function _initOpts($url, $timeout = null, $connectTimeout = null)
    {
        $opts = [
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => 1,
        ];
        if (isset($connectTimeout)) {
            $opts[CURLOPT_CONNECTTIMEOUT] = $connectTimeout;
        }
        if (isset($timeout)) {
            $opts[CURLOPT_TIMEOUT] = $timeout;
        }
        return $opts;
    }

    /**
     * @param $opts
     * @throws \Exception
     * @return mixed
     */
    private static function _curlExec($opts)
    {
        $curlHandle = curl_init();
        curl_setopt_array($curlHandle, $opts);
        $result = curl_exec($curlHandle);
        $curlInfo = curl_getinfo($curlHandle);
        $httpCode = isset($curlInfo['http_code']) ? $curlInfo['http_code'] : null;
        $errorNo = curl_errno($curlHandle);
        if ($errorNo) {
            throw new \Exception(curl_error($curlHandle), $errorNo);
        }
        if ($httpCode != 200) {
            throw new \Exception(json_encode($curlInfo));
        }
        curl_close($curlHandle);
        return $result;
    }

}