<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

function notifadz_adrenalead_download_resource($url)
{
    $response = wp_remote_get($url);
    return wp_remote_retrieve_body($response);
}

function notifadz_adrenalead_http_get($url, $tokenFromPost = false)
{
    $headers = notifadz_get_api_header($tokenFromPost);
    $request = wp_remote_get($url, array('headers' => $headers));
    return notifadz_return_response($request);
}

function notifadz_adrenalead_http_get_basic_authorization($url, $username, $password)
{
    $headers = notifadz_get_api_header_with_basic_authorization($username, $password);
    $request = wp_remote_get($url, ['headers' => $headers]);
    return notifadz_return_response($request);
}

function notifadz_adrenalead_http_post($url, $params, $token = false)
{
    $headers = notifadz_get_api_header($token);
    return notifadz_send_request_and_return_response('POST', $headers, $params, $url);
}

function notifadz_adrenalead_http_post_basic_authorization($url, $params, $username, $password)
{
    $headers = notifadz_get_api_header_with_basic_authorization($username, $password);
    return notifadz_send_request_and_return_response('POST', $headers, $params, $url);
}

function notifadz_adrenalead_http_patch_basic_authorization($url, $params, $username, $password)
{
    $headers = notifadz_get_api_header_with_basic_authorization($username, $password);
    return notifadz_send_request_and_return_response('PATCH', $headers, $params, $url);
}

function notifadz_send_request_and_return_response($method, $headers, $params, $url): array
{
    $body = notifadz_get_api_body($method, $headers, $params);
    $request = wp_remote_post($url, $body);
    return notifadz_return_response($request);
}

function notifadz_get_api_header($tokenFromPost = false)
{
    return [
        'Cache-Control' => 'no-cache',
        'Content-Type' => 'application/json; charset=utf-8',
        'token' => empty($tokenFromPost) ? get_option('adrenalead_notifadz_token') : $tokenFromPost
    ];
}

function notifadz_get_api_header_with_basic_authorization($username, $password)
{
    return [
        'Cache-Control' => 'no-cache',
        'Content-Type' => 'application/json; charset=utf-8',
        'Authorization' => 'Basic ' . base64_encode(sprintf('%s:%s', $username, $password))
    ];
}

function notifadz_get_api_body($method, $headers, $params)
{
    return [
        'method' => $method,
        'timeout' => 45,
        'redirection' => 5,
        'headers' => $headers,
        'body' => wp_json_encode($params),
    ];
}

function notifadz_return_response($request)
{
    $success = true;
    $statusCode = wp_remote_retrieve_response_code($request);
    if (is_wp_error($request) || (int)substr($statusCode, 0, 1) != 2) {
        $success = false;
    }
    return ['success' => $success, 'body' => json_decode(wp_remote_retrieve_body($request)), 'statusCode' => $statusCode];
}

function notifadz_verify_nonce()
{
    if (!wp_verify_nonce(sanitize_post($_POST['nonce']), 'ajax-nonce')) {
        exit;
    }
}

function notifadz_get_domain_name()
{
    $url = get_site_url();
    $parsedUrl = parse_url($url);
    return str_replace($parsedUrl['scheme'] . '://', '', $url);
}

function notifadz_get_website_id_according_to_domain()
{
    $domain = notifadz_get_domain_name();
    $profile = get_option('adrenalead_notifadz_profil');
    // todo: for tests purpose
    if (str_contains($profile->users[0]->email, '@test.com')) {
        $domain = explode('@', $profile->users[0]->email)[0] . '.com';
    }
    if (!isset($profile->websites)) {
        throw new Exception("Your profile doesn't contain any website, please contact us.");
    }

    foreach ($profile->websites as $website) {
        if ($domain === $website->domain) {
            return (int)$website->id;
        }
    }
    throw new Exception("Your website list doesn't contain the domain of your website, please contact us.");
}

function notifadz_is_woocommerce_activated()
{
    return class_exists('woocommerce');
}

function notifadz_is_advertiser($profile = false)
{
    if (false === $profile) {
        $profile = get_option('adrenalead_notifadz_profil');
    }
    return isset($profile->account) && $profile->account->clientType === 'ADVERTISER';
}

function notifadz_is_publisher($profile = false)
{
    if (false === $profile) {
        $profile = get_option('adrenalead_notifadz_profil');
    }
    return isset($profile->account) && $profile->account->clientType === 'PUBLISHER';
}

function notifadz_update_script($ids)
{
    $script = file_get_contents(__DIR__ . '/scripts/footer.js.txt');
    $script = str_replace('{scriptId}', $ids, $script);
    notifadz_add_or_update_option('adrenalead_notifadz_script', $script);
}

function notifadz_update_script_triggers($ids)
{
    $scriptTriggers = file_get_contents(__DIR__ . '/scripts/footer_triggers.js.txt');
    $scriptTriggers = str_replace('{scriptId}', $ids, $scriptTriggers);
    notifadz_add_or_update_option('adrenalead_notifadz_script_triggers', $scriptTriggers);
}

function notifadz_add_or_update_option($option_name, $value)
{
    if (false === get_option($option_name)) {
        add_option($option_name, $value);
    } else {
        update_option($option_name, $value);
    }
}

function notifadz_get_user_ip()
{
    if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') > 0) {
            $addr = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($addr[0]);
        } else {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    return $_SERVER['REMOTE_ADDR'];
}