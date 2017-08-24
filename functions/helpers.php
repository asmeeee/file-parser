<?php

/* Helpers */
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

function get_http_response_code($url) {
    $headers = @get_headers($url);
    return substr($headers[0], 9, 3);
}

function download($url) {
    $curl = curl_init();

    curl_setopt_array($curl, array
    (
        CURLOPT_URL => $url,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/22.0.1207.1 Safari/537.1',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 120,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HEADER => false
    ));

    $data = curl_exec($curl);

    curl_close($curl);

    return $data;
}

function upload($url, $fields) {
    $curl = curl_init();

    curl_setopt_array($curl, array
    (
        CURLOPT_URL => $url,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/22.0.1207.1 Safari/537.1',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => http_build_query($fields)
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    return $response;
}

function uploadThenDownload($postUrl, $getUrl, $postFields) {
    // Upload (post)
    $curl = curl_init();

    curl_setopt_array($curl, array
    (
        CURLOPT_URL => $postUrl,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/22.0.1207.1 Safari/537.1',
        CURLOPT_POST => 1,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => http_build_query($postFields),
        CURLOPT_COOKIEJAR => "cookie.txt"
    ));

    $postRequest = curl_exec($curl);

    // Download (get)
    curl_setopt_array($curl, array
    (
        CURLOPT_URL => $getUrl,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/22.0.1207.1 Safari/537.1'
    ));

    $getRequest = curl_exec($curl);

    curl_close($curl);

    return $getRequest;
}

function getRedirectUrl($url) {
    $curl = curl_init();

    curl_setopt_array($curl, array
    (
        CURLOPT_URL => $url,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/22.0.1207.1 Safari/537.1',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => true,
        CURLOPT_FOLLOWLOCATION => false
    ));

    $response = curl_exec($curl);

    preg_match_all('/^Location:(.*)$/mi', $response, $matches);

    curl_close($curl);

    if (!empty($matches[1])) {
        return trim($matches[1][0]);
    } else {
        return $url;
    }
}
