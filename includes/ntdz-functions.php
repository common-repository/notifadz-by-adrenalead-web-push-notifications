<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

require_once plugin_dir_path(__FILE__) . 'ntdz-utils.php';

class Notifadz
{
    /**
     * To handle deprecation of dynamic properties in PHP 8.2 and later
     */
    public $plugin;

    public const API_BASE_URL = 'https://apis.notifadz.com/api/v1/';
    public const API_BASE_URL_V2 = 'https://secure-apis.notifadz.com/notifadz-v2/';

    public function __construct()
    {
        // Plugin Details
        $this->plugin = new stdClass;
        $this->plugin->name = 'Notifadz by Adrenalead - Web Push Notifications'; // Plugin Folder
        $this->plugin->displayName = 'Notifadz by Adrenalead - Web Push Notifications'; // Plugin Name
        $this->plugin->version = '3.0.18';
        $this->plugin->folder = plugin_dir_path(__FILE__);
        $this->plugin->url = plugin_dir_url(__FILE__);

        // Hooks
        load_plugin_textdomain(
            'notifadz-by-adrenalead-web-push-notifications',
            false,
            dirname(plugin_basename(__FILE__)) . '/languages/'
        );

        add_action('admin_print_scripts', 'notifadz_adrenalead_script');
        add_action('admin_print_styles', 'notifadz_adrenalead_stylesheet');
        add_action('admin_menu', 'notifadz_adrenalead_admin_link');
        add_action('wp_footer', 'notifadz_adrenalead_footer_script');
        add_action('wp_ajax_ntdz', 'notifadz_adrenalead_token');
        add_action('wp_ajax_login_email', 'notifadz_adrenalead_login_email');
        add_action('wp_ajax_get_cgv', 'notifadz_get_cgv');
        add_action('wp_ajax_add_user', 'notifadz_add_user');
        add_action('wp_ajax_add_template', 'notifadz_add_template');
        add_action('wp_ajax_update_template', 'notifadz_update_template');
        add_action('wp_ajax_confirm_template', 'notifadz_confirm_template');
        add_action('wp_ajax_activate_scripts_triggers', 'notifadz_activate_scripts_triggers');
        add_action('wp_ajax_check_ads', 'notifadz_check_ads');
        add_action('wp_ajax_get_ads_txt', 'notifadz_get_ads_txt');

        add_filter('query_vars', 'notifadz_adrenalead_query_vars');
        add_action('parse_request', 'notifadz_adrenalead_parse_request');

        add_action('wp_loaded', 'notifadz_adrenalead_rewrite_rules');

        add_action('wp', 'notifadz_adrenalead_setup_schedule');
        add_action('notifadz_adrenalead_hourly_event', 'notifadz_adrenalead_update_resources');

        add_action('wp_insert_post', 'notifadz_adrenalead_publish_post', 10, 3);
        add_action('publish_post', 'notifadz_adrenalead_publish_post', 10, 2);
        add_action('add_meta_boxes', 'notifadz_adrenalead_register_meta_boxes');
        add_action('save_post', 'notifadz_adrenalead_save_meta_box');

        add_action('admin_enqueue_scripts', 'notifadz_enqueue_color_picker');
        // add_action('plugins_loaded', 'check_translation_files');
        // error_log('Attempting to load translation files.');
    }
}

function check_translation_files()
{
    if (is_textdomain_loaded('notifadz-by-adrenalead-web-push-notifications')) {
        error_log('Translation files are loaded.');
    } else {
        error_log('Translation files are NOT loaded.');
    }
    $mo_file = plugin_dir_path(__FILE__) . 'languages/notifadz-by-adrenalead-web-push-notifications-en_US.mo';
    $po_file = plugin_dir_path(__FILE__) . 'languages/notifadz-by-adrenalead-web-push-notifications-en_US.po';

    error_log('MO File Path: ' . $mo_file);
    error_log('PO File Path: ' . $po_file);

    if (file_exists($mo_file) && file_exists($po_file)) {
        error_log('Translation files exist.');
    } else {
        error_log('Translation files NOT found.');
    }
    $result = load_plugin_textdomain(
        'notifadz-by-adrenalead-web-push-notifications',
        false,
        dirname(plugin_basename(__FILE__)) . '/languages/'
    );
    error_log('Translation load result: ' . var_export($result, true));
}

function notifadz_adrenalead_register_meta_boxes()
{
    add_meta_box(
        'notifadz_adrenalead_post',
        __('Notifadz by Adrenalead', 'notifadz-by-adrenalead-web-push-notifications'),
        'notifadz_adrenalead_display_meta_box_post',
        'post'
    );
}

function notifadz_adrenalead_display_meta_box_post($post)
{
    $checked = $post->post_status == 'auto-draft' || get_post_meta($post->ID, 'notifadz_adrenalead_send_push', true);
    $device = 'both';
    if (get_post_meta($post->ID, 'notifadz_adrenalead_push_device', true)) {
        $device = get_post_meta($post->ID, 'notifadz_adrenalead_push_device', true);
    }

    ?>
    <p>
        <label><?php
        esc_html_e(
            'Send push notification on post publication?',
            'notifadz-by-adrenalead-web-push-notifications'
        ); ?>&nbsp;&nbsp;</label>

        <label><input type="radio" name="notifadz_adrenalead_send_push" value="1" autocomplete="off" <?php
        echo $checked ? esc_attr('checked') : esc_attr('') ?> />
            <?php
            esc_html_e('Yes', 'notifadz-by-adrenalead-web-push-notifications'); ?></label>&nbsp;&nbsp;
        <label><input type="radio" name="notifadz_adrenalead_send_push" value="0" autocomplete="off" <?php
        echo !$checked ? esc_attr('checked') : esc_attr('') ?> />
            <?php
            esc_html_e('No', 'notifadz-by-adrenalead-web-push-notifications'); ?></label>
    </p>
    <p>
        <label><?php
        esc_html_e('Target device?', 'notifadz-by-adrenalead-web-push-notifications'); ?>&nbsp;&nbsp;</label>

        <label><input type="radio" name="notifadz_adrenalead_push_device" value="desktop" autocomplete="off" <?php
        echo $device == 'desktop' ? esc_attr('checked') : esc_attr('') ?> />
            <?php
            esc_html_e('Desktop', 'notifadz-by-adrenalead-web-push-notifications'); ?></label>&nbsp;&nbsp;
        <label><input type="radio" name="notifadz_adrenalead_push_device" value="mobile" autocomplete="off" <?php
        echo $device == 'mobile' ? esc_attr('checked') : esc_attr('') ?> />
            <?php
            esc_html_e('Mobile', 'notifadz-by-adrenalead-web-push-notifications'); ?></label>&nbsp;&nbsp;
        <label><input type="radio" name="notifadz_adrenalead_push_device" value="both" autocomplete="off" <?php
        echo $device == 'both' ? esc_attr('checked') : esc_attr('') ?> />
            <?php
            esc_html_e('Both', 'notifadz-by-adrenalead-web-push-notifications'); ?></label>
    </p>

    <?php
}

function notifadz_adrenalead_save_meta_box($post_id)
{
    if (
        !array_key_exists('notifadz_adrenalead_send_push', $_POST)
        || !array_key_exists('notifadz_adrenalead_push_device', $_POST)
    ) {
        return;
    }
    update_post_meta(
        $post_id,
        'notifadz_adrenalead_send_push',
        sanitize_text_field($_POST['notifadz_adrenalead_send_push'])
    );
    update_post_meta(
        $post_id,
        'notifadz_adrenalead_push_device',
        sanitize_text_field($_POST['notifadz_adrenalead_push_device'])
    );
}

function notifadz_adrenalead_publish_post($post_id, $post, $update = false)
{
    $sent = get_post_meta($post->ID, 'notifadz_adrenalead_sent_push', true);

    if (
        !$sent && $post->post_status == 'publish'
        && get_option('adrenalead_notifadz_ids')
        && get_option('adrenalead_notifadz_token')
        && get_post_meta($post->ID, 'notifadz_adrenalead_send_push', true)
    ) {
        update_post_meta($post_id, 'notifadz_adrenalead_sent_push', 1);
        $device = get_post_meta($post->ID, 'notifadz_adrenalead_push_device', true);

        if ($device == 'mobile' || $device == 'both') {
            notifadz_adrenalead_planned_campaign($post, 'mobile');
        }
        if ($device == 'desktop' || $device == 'both') {
            notifadz_adrenalead_planned_campaign($post, 'desktop');
        }
    }
}

function notifadz_adrenalead_planned_campaign($post, $device)
{
    $url = Notifadz::API_BASE_URL_V2 . '/campaign/planned';
    $chars = $device == 'desktop' ? 105 : 40;

    if (has_excerpt()) {
        $excerpt = wp_strip_all_tags(get_the_excerpt($post));
    } else {
        $excerpt = wp_strip_all_tags(get_the_content(null, false, $post));
    }

    $excerpt = substr($excerpt, 0, $chars);
    $params = [
        'campaign' => [
            'name' => $post->post_title,
            'title' => substr($post->post_title, 0, 40),
            'body' => $excerpt,
            'icon' => '',
            'image' => get_the_post_thumbnail_url($post),
            'urlRedirection' => get_permalink($post),
            'sendingDate' => str_replace(' ', 'T', $post->post_date_gmt) . 'Z',
            'ciblage' => [
                'device' => $device,
                'ids' => [
                    get_option('adrenalead_notifadz_ids')
                ]
            ]
        ]
    ];

    notifadz_adrenalead_http_post($url, $params, get_option('adrenalead_notifadz_token'));
}

function notifadz_enqueue_color_picker()
{
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_script(
        'wp-color-picker-script-handle',
        plugins_url('../res/js/color-picker.js', __FILE__),
        ['wp-color-picker'],
        false,
        true
    );
}

function notifadz_adrenalead_setup_schedule()
{
    if (!wp_next_scheduled('notifadz_adrenalead_hourly_event')) {
        wp_schedule_event(time(), 'hourly', 'notifadz_adrenalead_hourly_event');
    }
}

function notifadz_adrenalead_query_vars($query_vars)
{
    $query_vars[] = 'notifadz_file';
    return $query_vars;
}

function notifadz_adrenalead_rewrite_rules()
{
    add_rewrite_rule(
        '^serviceworker.js$',
        'index.php?notifadz_file=worker',
        'top'
    );
}

function notifadz_adrenalead_parse_request(&$wp)
{
    if (array_key_exists('notifadz_file', $wp->query_vars)) {
        $file = $wp->query_vars['notifadz_file'];
        if ($file === 'worker') {
            header('Content-Type: application/javascript;  charset=utf-8');
        }
        echo wp_kses_post(get_option('adrenalead_notifadz_' . $file));

        exit;
    }
}

function notifadz_adrenalead_script()
{
    wp_enqueue_script(
        'notifadz_script',
        plugins_url('../res/js/ntdz.js', __FILE__),
        ['jquery', 'wp-i18n'],
        '1.1',
        true
    );
    wp_enqueue_script(
        'notifadz_script_prismjs',
        plugins_url('../res/js/prism.js', __FILE__),
        ['jquery'],
        '1.1',
        true
    );
    wp_enqueue_script('password-strength-meter');
    wp_localize_script('notifadz_script', 'ajax_var', [
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ajax-nonce')
    ]);
    wp_set_script_translations('notifadz_script', 'notifadz-by-adrenalead-web-push-notifications');
}

function notifadz_adrenalead_stylesheet()
{
    wp_enqueue_style('notifadz_css_prismjs', plugins_url('../res/css/prism.css', __FILE__));
    wp_enqueue_style('notifadz_css', plugins_url('../res/css/ntdz-styles.css', __FILE__));
}

function notifadz_adrenalead_admin_link()
{
    add_menu_page(
        'Notifadz Push',
        'Notifadz Push',
        'manage_options',
        'notifadz_settings',
        'notifadz_adrenalead_admin'
    );
}

function notifadz_adrenalead_admin()
{
    require_once plugin_dir_path(__FILE__) . 'ntdz-admin.php';
}

function notifadz_add_template()
{
    notifadz_verify_nonce();
    try {
        $websiteId = notifadz_get_website_id_according_to_domain();
    } catch (Exception $exception) {
        echo wp_json_encode(['success' => false, 'body' => $exception->getMessage()]);
        exit;
    }
    $type = sanitize_text_field($_POST['params']['type']);
    $body = notifdaz_get_body_for_template($type);
    $uri = 'templates';
    $body['websiteId'] = $websiteId;
    if ($type == 'perso') {
        $body['params']['color'] = sanitize_text_field($_POST['params']['colorsCatchMessage']);
    }
    $profile = get_option('adrenalead_notifadz_profil');
    $body = stripslashes_deep($body);
    $response = notifadz_adrenalead_http_post_basic_authorization(
        Notifadz::API_BASE_URL . $uri,
        $body,
        $profile->account->id,
        $profile->account->apiToken
    );
    if (true === $response['success']) {
        notifadz_update_script($response['body']->ids);
        if (notifadz_is_advertiser($profile)) {
            notifadz_update_script_triggers($response['body']->ids);
        }
        notifadz_add_or_update_option('adrenalead_notifadz_template_data', $response['body']);
        notifadz_add_or_update_option('adrenalead_notifadz_ids', $response['body']->ids);
        notifadz_add_or_update_option('adrenalead_notifadz_need_to_copy_ads', 1);
        notifadz_adrenalead_update_resources();
    }

    echo wp_json_encode($response);
    exit;
}

function notifadz_update_template()
{
    notifadz_verify_nonce();
    $actualParams = get_option('adrenalead_notifadz_template_data');
    if (empty($actualParams)) {
        echo wp_json_encode(['success' => false, 'body' => "No template to update."]);
        exit;
    }
    $templateId = $actualParams->id;
    $type = sanitize_text_field($_POST['params']['type']);
    $logo = sanitize_text_field($_POST['params']['logo']);
    $body = notifdaz_get_body_for_template($type);
    if ($type == 'optinbox') {
        $body['image'] = $logo;
    }

    $profile = get_option('adrenalead_notifadz_profil');
    $uri = 'templates/' . $templateId;
    $body = stripslashes_deep($body);
    $response = notifadz_adrenalead_http_patch_basic_authorization(
        Notifadz::API_BASE_URL . $uri,
        $body,
        $profile->account->id,
        $profile->account->apiToken
    );
    if (true === $response['success']) {
        notifadz_add_or_update_option('adrenalead_notifadz_template_data', $response['body']);
        notifadz_adrenalead_update_resources();
    }

    echo wp_json_encode($response);
    exit;
}

function notifdaz_get_body_for_template($type)
{
    return [
        'name' => sanitize_text_field($_POST['params']['label']) . ' ' . sanitize_text_field($_POST['params']['type']),
        'type' => $type,
        'logoDesktop' => sanitize_text_field($_POST['params']['logo']),
        'logoMobile' => sanitize_text_field($_POST['params']['logoMobile']),
        'params' => [
            'text1Desktop' => sanitize_text_field($_POST['params']['catchMessage']),
            'text2Desktop' => sanitize_text_field($_POST['params']['quoteMessage']),
            'text3Desktop' => sanitize_text_field($_POST['params']['contentMessage']),
            'text1DesktopColor' => sanitize_text_field($_POST['params']['colorsCatchMessage']),
            'text2DesktopColor' => sanitize_text_field($_POST['params']['colorsQuoteMessage']),
            'text3DesktopColor' => sanitize_text_field($_POST['params']['colorsContentMessage']),
            'textMobile' => sanitize_text_field($_POST['params']['textMobile']),
        ],
    ];
}

function notifadz_get_cgv()
{
    notifadz_verify_nonce();
    $uri = 'cgv';
    $response = notifadz_adrenalead_http_get(Notifadz::API_BASE_URL . $uri);

    echo wp_json_encode($response);
    exit;
}

function notifadz_add_user()
{
    notifadz_verify_nonce();
    $postData = sanitize_post($_POST['params']);
    $cleanUrl = notifadz_get_domain_name();

    // todo: for tests purpose
    if (str_contains($postData['user_email'], '@test.com')) {
        $cleanUrl = explode('@', $postData['user_email'])[0] . '.com';
    }
    $requestBody = [
        'account' => [
            'companyName' => $postData['account_companyName'],
            'type' => $postData['account_type'],
            'phone' => $postData['user_phone'],
            'address' => $postData['account_address'],
            'zipCode' => $postData['account_zipCode'],
            'city' => $postData['account_city'],
            'countryCode' => $postData['account_countryCode']
        ],
        'user' => [
            'email' => $postData['user_email'],
            'phone' => $postData['user_phone'],
            'title' => $postData['user_title'],
            'firstName' => $postData['user_firstName'],
            'lastName' => $postData['user_lastName'],
            'address' => $postData['account_address'],
            'zipCode' => $postData['account_zipCode'],
            'city' => $postData['account_city'],
            'countryCode' => $postData['account_countryCode'],
            'timeZone' => $postData['user_timeZone'],
            'password' => $postData['user_password'],
            'passwordConfirm' => $postData['user_passwordConfirm'],
        ],
        'website' => [
            'domain' => $cleanUrl,
            'iabCodeList' => [],
        ],
        'cgv' => [
            'id' => (int) $postData['cgv_id'],
            'ip' => notifadz_get_user_ip(),
            'userAgent' => $_SERVER['HTTP_USER_AGENT'],
        ],
        'locale' => $postData['account_countryCode'],
    ];

    $uri = 'accounts/wordpress';
    $response = notifadz_adrenalead_http_post(Notifadz::API_BASE_URL . $uri, $requestBody);

    if (true === $response['success']) {
        $uriAccount = 'accounts';
        $responseAccount = notifadz_adrenalead_http_get_basic_authorization(
            Notifadz::API_BASE_URL . $uriAccount,
            $response['body']->accountId,
            $response['body']->accountToken
        );

        $hasNotActiveSubscription = !isset($response['body']->activeSubscription);
        $isAdvertiser = $response['body']->clientType === "ADVERTISER";
        $isNotMonetized = $response['body']->monetize == 0;
    
        if ($isAdvertiser && $isNotMonetized && $hasNotActiveSubscription)
        {
            $response['body'] = __('403', 'notifadz-by-adrenalead-web-push-notifications');
            echo wp_json_encode($response);
            exit;
        }
        if ($responseAccount['success']) {
            // Connection successful => save token and accountId and profile in WP DB
            notifadz_add_or_update_option('adrenalead_notifadz_token', sanitize_text_field($responseAccount['body']->account->apiToken));
            notifadz_add_or_update_option('adrenalead_notifadz_account_id', sanitize_text_field($responseAccount['body']->account->id));
            notifadz_add_or_update_option('adrenalead_notifadz_profil', $responseAccount['body']);
        }
    }

    echo wp_json_encode($response);
    exit;
}

function notifadz_adrenalead_login_email()
{
    notifadz_verify_nonce();
    $uri = 'accounts';
    $email = sanitize_text_field($_POST['email']);
    $password = sanitize_text_field($_POST['password']);
    $response = notifadz_adrenalead_http_get_basic_authorization(Notifadz::API_BASE_URL . $uri, $email, $password);
    $hasNotActiveSubscription = !isset($response['body']->activeSubscription);
    $isAdvertiser = $response['body']->clientType === "ADVERTISER";
    $isNotMonetized = $response['body']->monetize == 0;

    if ($isAdvertiser && $isNotMonetized && $hasNotActiveSubscription)
    {
        $response['body'] = __('403', 'notifadz-by-adrenalead-web-push-notifications');
        echo wp_json_encode($response);
        exit;
    }

    if (false === $response['success']) {
        if ($response['statusCode'] === 401) {
            $response['body'] = __('Your credentials are not correct', 'notifadz-by-adrenalead-web-push-notifications');
        }
        echo wp_json_encode($response);
        exit;
    }

    notifadz_add_or_update_option('adrenalead_notifadz_token', sanitize_text_field($response['body']->account->apiToken));
    notifadz_add_or_update_option('adrenalead_notifadz_account_id', sanitize_text_field($response['body']->account->id));
    notifadz_add_or_update_option('adrenalead_notifadz_profil', $response['body']);

    // Try and get existing script for user_id and website
    $domain = sanitize_text_field($_POST['label']);
    // todo: for tests purpose
    if (str_contains($_POST['email'], '@test.com')) {
        $domain = explode('@', sanitize_text_field($_POST['email']))[0] . '.com';
    }
    $uri = 'templates/wordpress/' . $domain;
    $responseScript = notifadz_adrenalead_http_get_basic_authorization(
        Notifadz::API_BASE_URL . $uri,
        $response['body']->account->id,
        $response['body']->account->apiToken
    );
    $response['shouldConfirmTemplate'] = false;
    if (true === $responseScript['success']) {
        $response['shouldConfirmTemplate'] = true;
        $response['templateId'] = $responseScript['body']->id;
        notifadz_add_or_update_option('adrenalead_notifadz_need_confirm_template', 1);
        notifadz_add_or_update_option('adrenalead_notifadz_confirm_template_id', $responseScript['body']->id);
    }

    echo wp_json_encode($response);
    exit;
}

function notifadz_check_ads()
{
    notifadz_verify_nonce();
    if (notifadz_is_advertiser()) {
        notifadz_add_or_update_option('adrenalead_notifadz_need_to_copy_ads', 0);
        notifadz_add_or_update_option('adrenalead_notifadz_tab', '');
        echo wp_json_encode(['success' => true]);
        exit;
    }
    $label = sanitize_text_field($_POST['params']['label']);
    $protocol = is_SSL() ? 'https://' : 'http://';
    $url = $protocol . $label . '/ads.txt';
    $response = wp_remote_get($url);
    $text = wp_remote_retrieve_body($response);
    if (!empty($text)) {
        $check = strpos($text, "appnexus.com, 2579, DIRECT");
        if ($check) {
            notifadz_add_or_update_option('adrenalead_notifadz_need_to_copy_ads', 0);
            notifadz_add_or_update_option('adrenalead_notifadz_tab', '');

            echo wp_json_encode(['success' => true, 'body' => 'ads.txt is present and up to date !']);
            exit;
        }
    }
    notifadz_add_or_update_option('adrenalead_notifadz_need_to_copy_ads', 1);

    echo wp_json_encode(['success' => false, 'body' => 'ads.txt is either not present or does not contain adrenalead lines.']);
    exit;
}

function notifadz_get_ads_txt()
{
    notifadz_verify_nonce();
    die(get_option('adrenalead_notifadz_ads'));
}

function notifadz_confirm_template()
{
    notifadz_verify_nonce();
    $id = sanitize_text_field($_POST['id']);
    $profile = get_option('adrenalead_notifadz_profil');
    $uri = 'templates/' . $id;
    $response = notifadz_adrenalead_http_get_basic_authorization(
        Notifadz::API_BASE_URL . $uri,
        $profile->account->id,
        $profile->account->apiToken
    );
    if (true === $response['success']) {
        notifadz_add_or_update_option('adrenalead_notifadz_need_to_copy_ads', 1);
        notifadz_update_script($response['body']->ids);
        $tabToShow = 'fonctionnalites';
        if (notifadz_is_advertiser($profile)) {
            notifadz_update_script_triggers($response['body']->ids);
            $tabToShow = '';
        }
        notifadz_add_or_update_option('adrenalead_notifadz_template_data', $response['body']);
        notifadz_add_or_update_option('adrenalead_notifadz_need_confirm_template', 0);
        notifadz_add_or_update_option('adrenalead_notifadz_ids', $response['body']->ids);
        notifadz_add_or_update_option('adrenalead_notifadz_tab', $tabToShow);
        notifadz_adrenalead_update_resources();
    }

    echo wp_json_encode($response);
    exit;
}

function notifadz_activate_scripts_triggers()
{
    notifadz_verify_nonce();
    $triggersScriptsActivated = sanitize_text_field($_POST['params']['activate_triggers_scripts'] ?? 0);
    notifadz_add_or_update_option('adrenalead_notifadz_script_triggers_activated', $triggersScriptsActivated);

    echo wp_json_encode(['success' => true]);
    exit;
}

function notifadz_adrenalead_footer_script()
{
    echo wp_kses(get_option('adrenalead_notifadz_script'), ['script' => []]);
    if (notifadz_is_woocommerce_activated() && notifadz_is_advertiser()) {
        $areTriggersScriptsActivated = get_option('adrenalead_notifadz_script_triggers_activated');
        if (1 === (int) $areTriggersScriptsActivated) {
            echo wp_kses(get_option('adrenalead_notifadz_script_triggers'), ['script' => []]);
        }
    }
}

function notifadz_adrenalead_update_resources()
{
    $adsTxt = notifadz_adrenalead_download_resource('https://cdn.adrenalead.com/install/ads.txt');
    $serviceWorker = notifadz_adrenalead_download_resource('https://cdn.adrenalead.com/install/serviceworker.js');
    update_option('adrenalead_notifadz_ads', $adsTxt);
    update_option('adrenalead_notifadz_worker', $serviceWorker);
}

$ntdz = new Notifadz();