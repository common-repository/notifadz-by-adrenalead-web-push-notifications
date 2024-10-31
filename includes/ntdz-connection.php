<div id="ntdz_connect_section" class="ntdz_connect_section ntdz_flex_connect">
    <div class="ntdz_left_connect_sect">
        <!--  -------------- SUBSCRIPTION SECTION ------------------ -->
        <form id="ntdz_subsc_account" role="form" data-toggle="validator" method="post">
            <input type="hidden" id="cgv_id" name="cgv_id" />
            <div id="ntdz_subscription">
                <span class="ntdz_connect">
                    <?php esc_html_e('Log in to embed a Notifadz collection template on your website.', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                </span>
                <p>
                    <?php esc_html_e('This extension allows website publishers and media outlets to engage and monetize their web audience through web push notifications. They can animate and take advantage of the notification collection and sending tool to engage and retain their community of web push subscribers for free.', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                </p>
                <div class="input-group subscription_form">
                    <select class="ntdz-form-control-connect nt select_ntdz text-center" id="SelectStatus" name="account_type" required>
                        <option value="" disabled <?php if (empty($profile)) {
                            echo esc_attr('selected');
                        } ?>><?php esc_html_e("Select your status", "notifadz-by-adrenalead-web-push-notifications") ?>*
                        </option>
                        <option value="ADVERTISER" <?php if ($profile && $profile->status == 'ADVERTISER') {
                            echo esc_attr('selected');
                        } ?>><?php esc_html_e("I am an e-merchant", "notifadz-by-adrenalead-web-push-notifications") ?></option>
                        <option value="PUBLISHER" <?php if ($profile && $profile->status == 'PUBLISHER') {
                            echo esc_attr('selected');
                        } ?>><?php esc_html_e("I am an editor", "notifadz-by-adrenalead-web-push-notifications") ?></option>
                    </select>
                </div>
                <div class="input-group subscription_form mt-4">
                    <select class="ntdz-form-control-connect nt" id="SelectClient" name="user_title" required>
                        <option value="" disabled <?php if (empty($profile)) {
                            echo esc_attr('selected');
                        } ?>><?php esc_html_e("Please select Mr/Mrs*", "notifadz-by-adrenalead-web-push-notifications") ?>
                        </option>
                        <option value="M" <?php if ($profile && $profile->title == 'M') {
                            echo esc_attr('selected');
                        } ?>><?php esc_html_e("Mr", "notifadz-by-adrenalead-web-push-notifications") ?></option>
                        <option value="Mme" <?php if ($profile && $profile->title == 'Mme') {
                            echo esc_attr('selected');
                        } ?>><?php esc_html_e("Mrs", "notifadz-by-adrenalead-web-push-notifications") ?></option>
                    </select>
                    <input type="text" id="first_name" name="user_firstName" class="ntdz-form-control-connect "
                           value="<?php echo esc_attr($profile->firstName ?? '') ?? ''; ?>"
                           placeholder="<?php esc_attr_e('First name*', 'notifadz-by-adrenalead-web-push-notifications'); ?>"
                           autofocus="" aria-label="Token" aria-describedby="basic-addon1" required>
                    <input type="text" id="name" name="user_lastName" class="ntdz-form-control-connect "
                           placeholder="<?php esc_attr_e('Name*', 'notifadz-by-adrenalead-web-push-notifications'); ?>"
                           autofocus="" aria-label="Token" aria-describedby="basic-addon1" required>
                </div>
                <div class="input-group subscription_form mt-4">
                    <input type="text" id="address" name="account_companyName" class="ntdz-form-control-connect "
                           value="<?php echo esc_attr($profile->companyName ?? '') ?? ''; ?>"
                           placeholder="<?php esc_attr_e('Company name*', 'notifadz-by-adrenalead-web-push-notifications'); ?>"
                           autofocus="" aria-label="Token" aria-describedby="basic-addon1" required>
                </div>
                <div class="input-group subscription_form mt-4">
                    <input type="text" id="address" name="account_address" class="ntdz-form-control-connect "
                           value="<?php echo esc_attr($profile->address ?? '') ?? ''; ?>"
                           placeholder="<?php esc_attr_e('Address*', 'notifadz-by-adrenalead-web-push-notifications'); ?>"
                           autofocus="" aria-label="Token" aria-describedby="basic-addon1" required>
                    <input type="text" id="zip_code" name="account_zipCode" class="ntdz-form-control-connect "
                           value="<?php echo esc_attr($profile->zipCode ?? '') ?? ''; ?>"
                           placeholder="<?php esc_attr_e('Postal code*', 'notifadz-by-adrenalead-web-push-notifications'); ?>"
                           autofocus="" aria-label="Token" aria-describedby="basic-addon1" required>
                </div>
                <div class="input-group subscription_form mt-4">
                    <input type="text" id="account_city" name="account_city" class="ntdz-form-control-connect "
                           value="<?php echo esc_attr($profile->city ?? '') ?? ''; ?>"
                           placeholder="<?php esc_attr_e('City*', 'notifadz-by-adrenalead-web-push-notifications'); ?>"
                           autofocus="" aria-label="Token" aria-describedby="basic-addon1" required>
                    <select class="ntdz-form-control-connect" id="SelectClient" name="account_countryCode" required>
                        <option value="" disabled selected>
                            <?php esc_html_e("Your country*", 'notifadz-by-adrenalead-web-push-notifications') ?>
                        </option>
                        <?php
                        require_once plugin_dir_path(__FILE__) . 'ntdz-countries.php';
                        foreach ($countries as $code => $name): ?>
                            <option value="<?php echo esc_attr($code); ?>">
                                <?php esc_html_e($name, 'notifadz-by-adrenalead-web-push-notifications') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="input-group subscription_form mt-4">
                    <input type="text" id="email" name="user_email" class="ntdz-form-control-connect "
                           placeholder="<?php esc_attr_e('Email*', 'notifadz-by-adrenalead-web-push-notifications'); ?>"
                           autofocus="" aria-label="Token" aria-describedby="basic-addon1" required>
                    <input type="text" id="phone" value="<?php echo esc_attr($profile->phone ?? '') ?? ''; ?>" name="user_phone"
                           class="ntdz-form-control-connect "
                           placeholder="<?php esc_attr_e('Phone number*', 'notifadz-by-adrenalead-web-push-notifications'); ?>"
                           autofocus="" aria-label="Token" aria-describedby="basic-addon1" required>
                </div>
                <div class="input-group subscription_form mt-4">
                    <input type="password" id="password" name="user_password" class="ntdz-form-control-connect "
                           placeholder="<?php esc_attr_e('Password*', 'notifadz-by-adrenalead-web-push-notifications'); ?>"
                           autofocus="" aria-label="Token" aria-describedby="basic-addon1" required>
                    <input type="password" id="passwordConfirm" name="user_passwordConfirm"
                           class="ntdz-form-control-connect "
                           placeholder="<?php esc_attr_e('Confirm password*', 'notifadz-by-adrenalead-web-push-notifications'); ?>"
                           autofocus="" aria-label="Token" aria-describedby="basic-addon1" required>
                </div>
                <div id="pass-strength-result"></div>
                <p class="mt-0"><i><?php esc_attr_e('Password needs at least one upper and one lower character, one special character, one number, and be at least 10 characters', 'notifadz-by-adrenalead-web-push-notifications'); ?></i></p>
                <input type="hidden" id="time_zone" name="user_timeZone" class="ntdz-form-control-connect "
                       placeholder="Timezone" autofocus="" aria-label="Token" aria-describedby="basic-addon1">
                <div id="sign_up_block" class="input-group mt-4">
                    <fieldset class="mb-4 mt-4 ntdz-none" id="fieldset-link-general-conditions">
                        <label for="accept_conditions">
                            <input name="accept_conditions" type="checkbox" id="accept_conditions" value="1">
                            <?php _e('I have read and accept the <a target="_blank" href="javascript:" id="link-general-conditions">general conditions of sale</a>', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                        </label>
                    </fieldset>
                    <input class="ntdz_button" type="submit" id="submit_create_account" name="page_lang"
                           value="<?php esc_attr_e('Create my account', 'notifadz-by-adrenalead-web-push-notifications'); ?>" />
                </div>
            </div>
            <p class="mt-4 mb-0">
                <?php esc_attr_e('Required fields*', 'notifadz-by-adrenalead-web-push-notifications'); ?>
            </p>
        </form>
        <!-- --------------- SUBSCRIPTION SECTION END ------------------ -->
        <hr class="ntdz_connect_hr">
        <!-- --------------- CONNECTION SECTION EMAIL/PASSWORD ------------------ -->
        <form id="ntdz_connect_email" role="form" data-toggle="validator" method="post">
            <div id="ntdz_connexion">
                <span><?php esc_html_e('Already have a Notifadz account?', 'notifadz-by-adrenalead-web-push-notifications'); ?></span>
                <div class="input-group mt-4">
                    <input type="text" id="loginEmail" name="email" class="ntdz-form-control-connect"
                           placeholder="<?php esc_attr_e('Email', 'notifadz-by-adrenalead-web-push-notifications'); ?>*"
                           autofocus="" aria-label="Email" aria-describedby="basic-addon1" required>
                </div>
                <div class="input-group mt-4">
                    <input type="password" id="loginPassword" name="password" class="ntdz-form-control-connect"
                           placeholder="<?php esc_attr_e('Password', 'notifadz-by-adrenalead-web-push-notifications'); ?>*"
                           autofocus="" aria-label="Password" aria-describedby="basic-addon1" required>
                </div>
                <div id="sign_up_block" class="input-group mt-8">
                    <input class="ntdz_button token_connect" type="submit" id="loginSubmit" name="connect_email"
                           value="<?php esc_attr_e('Log in', 'notifadz-by-adrenalead-web-push-notifications'); ?>" />
                </div>
            </div>
        </form>
    </div>
    <div id="ntdz_connect_sect_img" class="ntdz_right_connect_sect">
        <img src="<?php echo esc_attr(plugins_url('../res/img/bg-login.jpg', __FILE__)) ?>" />
    </div>
</div>