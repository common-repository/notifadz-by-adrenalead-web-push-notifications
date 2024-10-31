<?php

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
$locale = get_locale();
$isWoocommerceActivated = notifadz_is_woocommerce_activated();
?>
<div id="ntdz_triggers_page" class="ntdz-none ntdz-template-page">
    <span class="ntdz_h1_block">
        <span class="dashicons dashicons-admin-plugins"></span>
        <?php esc_html_e('Automatisation', 'notifadz-by-adrenalead-web-push-notifications'); ?>
    </span>
    <hr class="ntdz_dott">
    <div class="ntdz_headUp">
        <img src="<?php echo esc_attr(plugins_url('../res/img/ico_thumb.png', __FILE__)) ?>" />
        <div class="ntdz_headUp_txt">
            <p><?php esc_html_e('Your scripts are integrated !', 'notifadz-by-adrenalead-web-push-notifications'); ?>
            </p>
            <span><?php esc_html_e('It\'s time to launch your first campaigns', 'notifadz-by-adrenalead-web-push-notifications'); ?></span>
        </div>
    </div>

    <form id="ntdz_triggers" role="form" data-toggle="validator" method="post">
        <div class="ntdz_box_row">
            <?php if (!$isWoocommerceActivated) { ?>
                <p class="mt-8 ntdz_notif ntdz_notif_warning">
                    <?php esc_html_e("It seems you don't have Woocommerce activated on your website. We advice you to install it in order to use our triggers." , 'notifadz-by-adrenalead-web-push-notifications'); ?>
                </p>
            <?php } ?>
            <!-- --------------- ACTIVATION TRIGGERS ------------------ -->
            <div id="ntdz_activation_triggers" class="mt-8">
                <div class="ntdz_h2_block mb-4">
                    <span class="dashicons dashicons-sos"></span>
                    <?php esc_html_e('Activation of trigger scripts', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                    <hr class="ntdz_dott">
                </div>
                <p><?php esc_html_e("It's time to activate your first automated campaigns ", 'notifadz-by-adrenalead-web-push-notifications'); ?></p>

                <div class="ntdz-box-lightblue mt-10">
                    <div>
                        <h4 class="font-size-12em"><?php esc_html_e('Welcome Push & Visit Revive', 'notifadz-by-adrenalead-web-push-notifications'); ?></h4>
                        <fieldset>
                            <label for="activate_triggers_scripts">
                                <input name="activate_triggers_scripts" type="checkbox" id="activate_triggers_scripts"
                                       value="1"<?php echo 1 === (int)get_option('adrenalead_notifadz_script_triggers_activated') ? ' checked': '' ?>>
                                <?php esc_html_e('Activate these 2 scripts', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                            </label>
                        </fieldset>
                        <p><i><?php esc_html_e('Installation is automatic', 'notifadz-by-adrenalead-web-push-notifications'); ?></i></p>
                    </div>
                    <div style="width: 40%;">
                        <h5 class="font-size-11em mb-0"><?php esc_html_e('Welcome Push', 'notifadz-by-adrenalead-web-push-notifications'); ?></h5>
                        <p class="mt-0"><?php esc_html_e('Automated sending of a welcome notification after the user subscribes to your notifications', 'notifadz-by-adrenalead-web-push-notifications'); ?></p>

                        <h5 class="font-size-11em mb-0"><?php esc_html_e('Visit Revive', 'notifadz-by-adrenalead-web-push-notifications'); ?></h5>
                        <p class="mt-0"><?php esc_html_e('Revive the user following its last visit to encourage him to return to the site', 'notifadz-by-adrenalead-web-push-notifications'); ?></p>
                    </div>
                </div>

                <div class="ntdz-box-lightblue mt-10">
                    <div>
                        <h4 class="font-size-12em"><?php esc_html_e('Cart Abandonment / Goal Completion', 'notifadz-by-adrenalead-web-push-notifications'); ?></h4>
                        <p><?php esc_html_e('Sending a notification to the Internet user who has not completed their purchase on your site.', 'notifadz-by-adrenalead-web-push-notifications'); ?></p>
                        <p><i><?php esc_html_e('Script to trigger on add to cart event.', 'notifadz-by-adrenalead-web-push-notifications'); ?></i></p>
                    </div>
                    <div style="width: 40%;">
                        <pre><code class="language-js"><?php
                            $scriptCartAbandonment = file_get_contents(__DIR__ .'/scripts/cartAbandonment.js');
                            echo nl2br(esc_html($scriptCartAbandonment)); ?>
                            </code></pre>
                        <textarea id="textarea-script-cart" class="ntdz-none"><?php echo $scriptCartAbandonment ?></textarea>
                        <button class="btn-copy-textarea ntdz_button_grey ntdz_button_script" data-textarea-id="textarea-script-cart">
                            <span class="dashicons dashicons-admin-page"></span>
                            <?php esc_html_e('Copy the script', 'notifadz-by-adrenalead-web-push-notifications') ?>
                        </button>
                    </div>
                </div>
            </div>

            <!-- --------------- ACTIVATION CONVERSION SCRIPT ------------------ -->
            <div id="ntdz_activation_triggers" class="mt-8">
                <div class="ntdz_h2_block mb-4">
                    <span class="dashicons dashicons-editor-unlink"></span>
                    <?php esc_html_e('Enabling the conversion script', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                    <hr class="ntdz_dott">
                </div>

                <div class="ntdz-box-lightblue mt-10">
                    <div>
                        <h4 class="font-size-12em"><?php esc_html_e('Conversion script', 'notifadz-by-adrenalead-web-push-notifications'); ?></h4>
                        <p class="mb-4"><?php esc_html_e('Script to be placed on order confirmation pages.', 'notifadz-by-adrenalead-web-push-notifications'); ?></p>
                        <p><i><?php esc_html_e('Configuring dynamic variables:', 'notifadz-by-adrenalead-web-push-notifications'); ?></i></p>
                        <p><i><?php _e('<b>XXXXXX</b> should be replaced with a transaction ID or order number or indicate <b>null</b> if you cannot.', 'notifadz-by-adrenalead-web-push-notifications'); ?></i></p>
                        <p><i><?php _e('<b>€€€</b> is to be replaced by the transaction amount or indicate <b>null</b> if you cannot.', 'notifadz-by-adrenalead-web-push-notifications'); ?></i></p>
                    </div>
                    <div style="width: 40%;">
                        <pre><code class="language-js"><?php
                            $profile = get_option('adrenalead_notifadz_profil');
                            $advertiserPrincipalId = $profile->advertiserPrincipalId;
                            $scriptConversion = file_get_contents(__DIR__ .'/scripts/conversion.js');
                            $scriptConversion = str_replace('{advertiserId}', $advertiserPrincipalId, $scriptConversion);
                            echo nl2br(esc_html($scriptConversion)); ?>
                            </code></pre>
                        <textarea id="textarea-script-conversion" class="ntdz-none"><?php echo $scriptConversion ?></textarea>
                        <button class="btn-copy-textarea ntdz_button_grey ntdz_button_script" data-textarea-id="textarea-script-conversion">
                            <span class="dashicons dashicons-admin-page"></span>
                            <?php esc_html_e('Copy the script', 'notifadz-by-adrenalead-web-push-notifications') ?>
                        </button>
                    </div>
                </div>
            </div>

            <!-- --------------- SAVE BUTTON ------------------ -->
            <input type="submit" id="ntdz_triggers_submit_btn"
                   class="ntdz_button ntdz_button_xl mt-10"
                   value="<?php esc_html_e('Save changes', 'notifadz-by-adrenalead-web-push-notifications') ?>" />

            <!-- --------------- ACCESS NOTIFADZ ------------------ -->
            <hr class="ntdz_dott mt-10">
            <a class="ntdz_button ntdz_button_xl ntdz_button_darkblue mt-10" href="https://notifadz.com/fr/" target="_blank">
                <?php esc_html_e('Access my campaigns directly from Notifadz', 'notifadz-by-adrenalead-web-push-notifications') ?>
            </a>
        </div>
    </form>
</div>