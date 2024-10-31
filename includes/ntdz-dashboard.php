<?php

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
$locale = get_locale();
?>
<div id="ntdz_dashboard_page" class="ntdz-template-page">
    <span class="ntdz_h1_block"><span
            class="dashicons dashicons-admin-home"></span><?php esc_html_e('Dashboard', 'notifadz-by-adrenalead-web-push-notifications'); ?></span>
    <hr class="ntdz_dott">
    <div class="ntdz_headUp">
        <img src="<?php echo esc_attr(plugins_url('../res/img/ico_thumb.png', __FILE__)) ?>" />
        <div class="ntdz_headUp_txt">
            <p><?php esc_html_e('Welcome to the Notifadz by Adrenalead extension', 'notifadz-by-adrenalead-web-push-notifications'); ?>
            </p>
            <span><?php esc_html_e('Your Template is currently attracting new subscribers to your site!', 'notifadz-by-adrenalead-web-push-notifications'); ?></span>
        </div>
    </div>
    <div class="ntdz_desc_head">
        <p><?php esc_html_e('The Notifadz extension is published by Adrenalead - 1st Advertising Network for Web Push Notifications. This extension enables website and media publishers to monetize their web audience thanks to web push notifications, and to take advantage of the tool to collect and send notifications to their own audience free of charge.', 'notifadz-by-adrenalead-web-push-notifications'); ?>
        </p>
    </div>

    <div class="ntdz_box_row">
        <!-- --------------- PROFIL CONNECT ------------------ -->
        <?php
        // useful to keep both API versions, profileInformation is a kind of DTO if user has new API
        $profile = get_option('adrenalead_notifadz_profil');
        $profileInformation = new stdClass();
        $profileInformation->email = $profile->users[0]->email;
        $profileInformation->phone = $profile->account->phone ?? '';
        $profileInformation->address = $profile->account->address;
        $profileInformation->zipCode = $profile->account->zipCode;
        $profileInformation->city = $profile->account->city;
        $profileInformation->country = $profile->account->countryCode;
        $token = get_option('adrenalead_notifadz_token') ?? ''; ?>
        <form id="ntdz_profil_connect" role="form" data-toggle="validator"
            class="<?php if (empty($token)) {
                echo esc_attr('ntdz-none');
            } ?>">
            <div id="ntdz_profil" class="mt-8">
                <div class="ntdz_h3_block">
                    <span
                        id="nadz_firstName"><?php esc_html_e('My account information', 'notifadz-by-adrenalead-web-push-notifications'); ?></span>
                    <hr class="ntdz_dott">
                </div>
                <div class="input-group subscription_form mt-4">
                    <input type="text" disabled id="final_address" name="address" class="ntdz-form-control"
                        value="<?php echo isset($profileInformation->address) ? esc_attr($profileInformation->address) : ''; ?>" placeholder=""
                        autofocus="" aria-label="Token" aria-describedby="basic-addon1">
                    <input type="text" disabled id="final_zip_code" name="zip_code" class="ntdz-form-control"
                        value="<?php echo isset($profileInformation->zipCode) ? esc_attr($profileInformation->zipCode) : ''; ?>" placeholder=""
                        autofocus="" aria-label="Token" aria-describedby="basic-addon1">
                </div>
                <div class="input-group subscription_form mt-4">
                    <input type="text" disabled id="final_city" name="city" class="ntdz-form-control"
                        value="<?php echo isset($profileInformation->city) ? esc_attr($profileInformation->city) : ''; ?>" placeholder=""
                        autofocus="" aria-label="Token" aria-describedby="basic-addon1">
                    <select class="ntdz-form-control select_ntdz" disabled id="final_select_country" name="country">
                        <option value="" disabled><?php esc_html_e("France") ?></option>
                        <option value="FR" selected><?php esc_html_e("France") ?></option>
                    </select>
                </div>
                <div class="input-group subscription_form mt-4">
                    <input type="text" disabled id="final_email" name="email" class="ntdz-form-control"
                        value="<?php echo isset($profileInformation->email) ? esc_attr($profileInformation->email) : ''; ?>" placeholder=""
                        autofocus="" aria-label="Token" aria-describedby="basic-addon1">
                    <input type="text" disabled id="final_phone" name="phone" class="ntdz-form-control"
                        value="<?php echo isset($profileInformation->phone) ? esc_attr($profileInformation->phone) : ''; ?>" placeholder=""
                        autofocus="" aria-label="Token" aria-describedby="basic-addon1">
                </div>
                <div class="input-group subscription_form mt-4">
                    <input type="text" disabled id="final_token" name="tokenNb" class="ntdz-form-control"
                        value="<?php echo isset($token) ? esc_attr($token) : ''; ?>" placeholder="" autofocus=""
                        aria-label="Token" aria-describedby="basic-addon1">
                </div>
            </div>
        </form>
        <!-- --------------- PROFIL CONNECT END ------------------ -->

        <!-- --------------- INFORMATIONS SECTION ------------------ -->
        <div class="ntdz_FAQ">
            <div class="ntdz_h3_block">
                <span><?php esc_html_e('Questions / Answers', 'notifadz-by-adrenalead-web-push-notifications'); ?></span>
                <hr class="ntdz_dott">
            </div>
            <div class="ntdz-list">
                <span><?php esc_html_e('What actions are initiated by the plugin?', 'notifadz-by-adrenalead-web-push-notifications'); ?></span>
                <ul class="ntdz-list-consent">
                    <li><?php esc_html_e('- Integration of a serviceworker.js at the root of your site.', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                    </li>
                    <li><?php esc_html_e('- Edit or add an ads.txt file at the root of your site.', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                    </li>
                    <li><?php esc_html_e('- Install the subscriber collection script before closing the </body> tag on all your pages.', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                    </li>
                </ul>
                <span><?php esc_html_e('What happens once I\'ve created my account?', 'notifadz-by-adrenalead-web-push-notifications'); ?></span>
                <ul class="ntdz-list-consent">
                    <li><?php esc_html_e('- Subscriber collection is active on your site', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                    </li>
                    <li><?php esc_html_e('- From Notifadz, you can track your first collection statistics (Impressions, Subscription rate, etc.).', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                    </li>
                    <li><?php esc_html_e('- Adrenalead starts monetizing your subscriber base to generate your first revenues (you can track the activation of monetization partners from your Notifadz account).', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                    </li>
                </ul>
            </div>
        </div>
        <!-- --------------- INFORMATIONS SECTION END ------------------ -->

        <!-- --------------- HELP SECTION ------------------ -->
        <div class="ntdz_box_help">
            <div class="ntdz_h3_block">
                <span><?php esc_html_e('Getting to grips with the tool', 'notifadz-by-adrenalead-web-push-notifications'); ?></span>
                <hr class="ntdz_dott">
            </div>
            <div class="ntdz_flex mt-8">
                <a href="https://adrenalead.com/contact/" target="_blank" style="text-decoration : none;">
                    <div class="ntdz_help_center mr-4">
                        <img src="<?php echo esc_attr(plugins_url('../res/img/ntdz_help.jpg', __FILE__)) ?>"
                            class="mb-4" />
                        <p><?php esc_html_e('Contact technical support', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                        </p>
                    </div>
                </a>
                <?php
                $documentationLinks = [
                    'ADVERTISER' => [
                        'fr' => 'https://documentation-notifadz.notion.site/Notifadz-Guide-d-utilisation-annonceurs-dc7b841d75c84cb49b112948a405cfc8',
                        'en' => 'https://documentation-notifadz.notion.site/Notifadz-User-guide-for-advertisers-c8470524be994ad89e1d3a0ff8054eb6',
                    ],
                    'PUBLISHER' => [
                        'fr' => 'https://documentation-notifadz.notion.site/Notifadz-Guide-d-utilisation-diteurs-1f6e27d382e140099fde637e5a5c1bb1',
                        'en' => 'https://documentation-notifadz.notion.site/Notifadz-User-guide-for-publishers-2fc44cdac1c24f24b057581fd0b6a168',
                    ],
                ];
                $localeIso = substr($locale, 0, 2);
                $link = $documentationLinks[$profile->account->clientType][$localeIso] ?? '';
                ?>
                <a href="<?php echo $link; ?>" target="_blank" style="text-decoration : none;">
                    <div class="ntdz_help_center mr-4">
                        <img src="<?php echo esc_attr(plugins_url('../res/img/tutorial.jpg', __FILE__)) ?>"
                            class="mb-4" />
                        <p><?php esc_html_e('Discover our  tutorials', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                        </p>
                    </div>
                </a>
                <a href="https://notifadz.com/fr/" target="_blank" style="text-decoration : none;">
                    <div class="ntdz_help_center">
                        <img src="<?php echo esc_attr(plugins_url('../res/img/ntdz_notifadz.jpg', __FILE__)) ?>"
                            class="mb-4" />
                        <p><?php esc_html_e('Log in to your Notifadz account', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <!-- --------------- HELP SECTION END ------------------ -->
    </div>
</div>