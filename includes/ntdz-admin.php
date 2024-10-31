<?php

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

$locale = get_locale();
$profile = get_option('adrenalead_notifadz_profil') ?? [];
$needToLoginAfterUpdate = !empty($profile) && !isset($profile->account);

if (isset($_GET['reset']) || $needToLoginAfterUpdate) {
    notifadz_adrenalead_delete_options($needToLoginAfterUpdate); ?>
    <div id="transition_page" class="input-group ntdz_contain">
        <div style="width: 70%;float: left;margin-left: 50px;margin-top: 100px;height: 200px;">
            <p><?php
                if ($needToLoginAfterUpdate) {
                    esc_html_e("You are now disconnected from the notifadz extension. You are not collecting anymore, the template is not active on your site. Because of the update of our plugin, please login using your email and password", 'notifadz-by-adrenalead-web-push-notifications');
                } else {
                    esc_html_e("You are now disconnected from the notifadz extension. The template has been removed from your site.", 'notifadz-by-adrenalead-web-push-notifications');
                } ?>
            </p>
            <a href="?page=notifadz_settings" class="ntdz_button_grey">
                <?php esc_html_e("Back to login page", 'notifadz-by-adrenalead-web-push-notifications'); ?>
            </a>
        </div>
    </div>
<?php } else {
    $token = get_option('adrenalead_notifadz_token');
    ?>
    <div class="wrap ntdz_contain">
    <?php if (false === $token) {
        require_once plugin_dir_path(__FILE__) . 'ntdz-connection.php';
    } else {
        $clientTypes = [
            'ADVERTISER' => __('Advertiser', 'notifadz-by-adrenalead-web-push-notifications'),
            'PUBLISHER' => __('Publisher', 'notifadz-by-adrenalead-web-push-notifications'),
            'AGENCY' => __('Agency', 'notifadz-by-adrenalead-web-push-notifications'),
        ];
        $needConfirmTemplate = (int)get_option('adrenalead_notifadz_need_confirm_template');
        $confirmTemplateId = (int)get_option('adrenalead_notifadz_confirm_template_id');
        $templateData = get_option('adrenalead_notifadz_template_data') ?? [];
        $tabToShow = get_option('adrenalead_notifadz_tab') ?? '';
        $isScriptPresent = (empty($templateData)) ? 0 : 1;
        $isAdvertiser = notifadz_is_advertiser($profile);
        $isPublisher = notifadz_is_publisher($profile);
        ?>
        <div id="ntdz_push_container" class="ntdz_push_container">
            <input type="hidden" id="nadz_script" value="<?php echo esc_attr($isScriptPresent) ?>">
            <input type="hidden" id="nadz_need_confirm_template" value="<?php echo $needConfirmTemplate ?>" />
            <input type="hidden" id="nadz_confirm_template_id" value="<?php echo $confirmTemplateId ?>" />
            <input type="hidden" id="nadz_tab_to_show" value="<?php echo $tabToShow ?>" />
            <input type="hidden" id="nadz_profile_type" value="<?php echo $profile ? $profile->account->clientType : '' ?>" />
            <div class="ntdz_tab_contain">
                <img src="<?php echo esc_attr(plugins_url('../res/img/notifadz_logo_white.png', __FILE__)) ?>"
                    class="ntdz_logo" alt="NotifAdz" />
                <div id="ntdz_dashboard_tab" class="ntdz_tab ntdz_active_tab">
                    <?php esc_html_e('DASHBOARD', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                    <span class="ntdz_active_sous_tab" id="dash_sml_tab">
                        <?php esc_html_e('Help, account info', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                    </span>
                </div>
                <div id="ntdz_template_tab" class="ntdz_tab">
                    <?php esc_html_e('TEMPLATE MANAGEMENT', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                    <span class="ntdz_active_sous_tab" id="temp_sml_tab">
                        <?php esc_html_e('Integration, customization', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                    </span>
                </div>
                <?php if ($isAdvertiser) { ?>
                <div id="ntdz_triggers_tab" class="ntdz_tab">
                    <?php esc_html_e('AUTOMATISATION', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                    <span class="ntdz_active_sous_tab" id="triggers_sml_tab">
                        <?php esc_html_e('Activation triggers', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                    </span>
                </div>
                <?php } ?>
                <span id="ntdz_fonctionnalites_tab" class="ntdz_tab">
                    <?php esc_html_e('SETTINGS', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                    <span class="dashicons dashicons-bell ntdz_notif ntdz_bell_notif ntdz-none"></span>
                    <span class="ntdz_active_sous_tab" id="fonc_sml_tab">
                        <?php esc_html_e('Ads.txt, logout', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                    </span>
                </span>
                <?php if ($isPublisher) { ?>
                <span id="ntdz_affiliate_tab" class="ntdz_tab">
                    <?php esc_html_e('AFFILIATE PROGRAM', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                    <span class="ntdz_active_sous_tab" id="affi_sml_tab">
                        <?php esc_html_e("Access to the affiliate program", 'notifadz-by-adrenalead-web-push-notifications'); ?>
                    </span>
                </span>
                <?php } ?>
            </div>
            <div class="ntdz-minimal_body">
                <a href="https://wordpress.org/support/plugin/notifadz-by-adrenalead-web-push-notifications/reviews/#new-post" target="_blank">
                    <div class="ntdz-minimal_head">
                        <span class="ntdz-minimal_head_type">
                            <?php esc_html_e($clientTypes[$profile->account->clientType], 'notifadz-by-adrenalead-web-push-notifications') ?>
                        </span>
                        <span class="ntdz-minimal_head_notation">
                            <?php esc_html_e('Do you like this plugin ?', 'notifadz-by-adrenalead-web-push-notifications') ?>
                            <span class="ntdz-minimal_head_notation_rate">
                                <?php _e('Feel free to <u>rate it on wordpress.org</u>!', 'notifadz-by-adrenalead-web-push-notifications') ?>
                            </span>
                        </span>
                    </div>
                </a>
                <div class="ntdz-minimal_adz">
                    <div class="row">
                        <!-- --------------- Dashboard ------------------ -->
                        <?php require_once plugin_dir_path(__FILE__) . 'ntdz-dashboard.php'; ?>
                        <!-- --------------- Dashboard END ------------------ -->

                        <!-- --------------- Template de collecte ------------------ -->
                        <?php require_once plugin_dir_path(__FILE__) . 'ntdz-template.php'; ?>
                        <!-- --------------- Template de collecte END ------------------ -->

                        <!-- --------------- Automatisation ------------------ -->
                        <?php if ($isAdvertiser) {
                            require_once plugin_dir_path(__FILE__) . 'ntdz-triggers.php';
                        } ?>
                        <!-- --------------- Automatisation END ------------------ -->

                        <!-- --------------- Fonctionnalités ------------------ -->
                        <?php require_once plugin_dir_path(__FILE__) . 'ntdz-fonctionnalites.php'; ?>
                        <!-- --------------- Fonctionnalités END ------------------ -->

                        <!-- --------------- Affiliation ------------------ -->
                        <?php if ($isPublisher) {
                            require_once plugin_dir_path(__FILE__) . 'ntdz-affiliate.php';
                        } ?>
                        <!-- --------------- Affiliation END ------------------ -->

                        <!-- --------------- STEP 3 ------------------ -->
                        <div id="step_three" class="ntdz-none">
                            <div>
                                <img src="<?php echo esc_attr(plugins_url('../res/img/dashboard_ntdz.png', __FILE__)) ?>"
                                    class="ntdz_img_desktop" />
                            </div>
                            <h3 class="ntdz_label_block">
                                <?php esc_html_e("Follow the evolution of your subscriber base and revenues directly from your ", 'notifadz-by-adrenalead-web-push-notifications'); ?><a
                                    href="https://notifadz.com" target="_blank"
                                    style="color : #135de4;text-decoration: underline;"><?php esc_html_e("Notifadz account.", 'notifadz-by-adrenalead-web-push-notifications'); ?><a />
                            </h3>
                        </div>

                        <!-- --------------- Besoin d'aide ------------------ -->
                        <?php require_once plugin_dir_path(__FILE__) . 'ntdz-help.php'; ?>
                        <!-- --------------- Besoin d'aide END ------------------ -->
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
<?php } ?>