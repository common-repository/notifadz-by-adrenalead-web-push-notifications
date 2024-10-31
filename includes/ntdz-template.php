<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
?>
<div id="ntdz_template_page" class="ntdz-none ntdz-template-page">
    <span class="ntdz_h1_block"><span
            class="dashicons dashicons-admin-appearance"></span><?php esc_html_e('Template management', 'notifadz-by-adrenalead-web-push-notifications'); ?></span>
    <hr class="ntdz_dott">
    <div class="ntdz_headUp">
        <img src="<?php echo esc_attr(plugins_url('../res/img/ico_arrow.svg', __FILE__)) ?>" />
        <div class="ntdz_headUp_txt">
            <p><?php esc_html_e('Welcome to Notifadz by Adrenalead!', 'notifadz-by-adrenalead-web-push-notifications'); ?>
            </p>
            <span><?php esc_html_e('Subscriber collection template configuration.', 'notifadz-by-adrenalead-web-push-notifications'); ?></span>
        </div>
    </div>
    <form id="ntdz_get_template" role="form" data-toggle="validator" method="post">
        <div class="ntdz_box_row">
            <div class="">
                <div class="ntdz_h2_block">
                    <span class="dashicons dashicons-desktop"></span>
                    <?php esc_html_e('Desktop version', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                    <hr class="ntdz_dott">
                </div>
                <!-- -------------- TEMPLATE SECTION ------------------ -->
                <div class="ntdz_section_template">
                    <span><?php esc_html_e('1.Choose the template format', 'notifadz-by-adrenalead-web-push-notifications'); ?></span>
                    <p><?php esc_html_e('You can choose the format that suits you best from two customizable templates:', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                    </p>
                    <div class="ntdz_flex mt-4">
                        <div class="ntdz_tempOptinbox typeChoice <?php if (!empty($templateData->type) && $templateData->type == 'optinbox')
                            echo esc_attr('ntdz_tempActive'); ?>"
                            id="ntdz_optinbox" data-type="optinbox">
                            <img src="<?php echo esc_attr(plugins_url('../res/img/ntdz_optinbox.png', __FILE__)) ?>" />
                            <p><?php esc_html_e('Template OptinBox', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                            </p>
                        </div>
                        <div class="ntdz_tempPerso typeChoice mr-4 <?php if (!empty($templateData->type) && $templateData->type == 'perso')
                            echo esc_attr('ntdz_tempActive'); ?>"
                            id="ntdz_perso" data-type="perso">
                            <img src="<?php echo esc_attr(plugins_url('../res/img/ntdz_tempperso.png', __FILE__)) ?>" />
                            <p><?php esc_html_e('Template Wide', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="ntdz_section_template">
                    <span><?php esc_html_e('2.Customize template texts', 'notifadz-by-adrenalead-web-push-notifications'); ?></span>
                    <p class="">
                        <?php esc_html_e('Choose which messages to display when your template appears:', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                    </p>
                    <!-- rajout pour docker:wq -->
                    <div class="input-group">
                        <div class="mt-4 d-flex">
                            <input class="ntdz-form-control mt-4" id="catchMessage"
                                placeholder="<?php esc_html_e('Be notified of our news and partner offers in real time', 'notifadz-by-adrenalead-web-push-notifications'); ?>"
                                type="text" maxlength="80" name="catchMessage"
                                value="<?php if (!empty($templateData->params->text1Desktop))
                                    echo esc_attr($templateData->params->text1Desktop);
                                else
                                    esc_html_e('Be notified of our news and partner offers in real time', 'notifadz-by-adrenalead-web-push-notifications'); ?>"
                                required="" autofocus="" aria-label="Token" aria-describedby="basic-addon1">
                            <span id="spanCatchMessage" data-color=""></span>
                            <input id="colorCatchMessage" class="color-picker" value='<?php if (!empty($templateData->params->text1DesktopColor))
                                echo esc_attr($templateData->params->text1DesktopColor);
                            else
                                echo esc_attr(''); ?>' data-default-color="#000000" />
                        </div>
                        <div class="mt-4 d-flex">
                            <input type="text" id="quoteMessage"
                                placeholder="<?php esc_html_e('No email required.', 'notifadz-by-adrenalead-web-push-notifications'); ?>"
                                name="quoteMessage" maxlength="35" class="ntdz-form-control mt-4" value="<?php if (!empty($templateData->params->text2Desktop))
                                    echo esc_html($templateData->params->text2Desktop);
                                else
                                    esc_html_e('No email required.', 'notifadz-by-adrenalead-web-push-notifications'); ?>"
                                required="" autofocus="" aria-label="Token" aria-describedby="basic-addon1">
                            <span id="spanQuoteMessage" data-color=""></span>
                            <input id="colorQuoteMessage" class="color-picker"
                                value='<?php if (!empty($templateData->params->text2DesktopColor))
                                    echo esc_attr($templateData->params->text2DesktopColor); ?>'
                                data-default-color="#000000" />
                        </div>
                        <div class="mt-4 d-flex">
                            <input type="text" id="contentMessage"
                                placeholder="<?php esc_html_e('Allow notifications to continue.', 'notifadz-by-adrenalead-web-push-notifications'); ?>"
                                maxlength="45" name="contentMessage" class="ntdz-form-control mt-4"
                                value="<?php if (!empty($templateData->params->text3Desktop))
                                    echo esc_attr($templateData->params->text3Desktop);
                                else
                                    esc_html_e('Allow notifications to continue.', 'notifadz-by-adrenalead-web-push-notifications'); ?>" required="" autofocus="" aria-label="Token"
                                aria-describedby="basic-addon1">
                            <span id="spanContentMessage" data-color=""></span>
                            <input id="colorContentMessage" class="color-picker"
                                value='<?php if (!empty($templateData->params->text3DesktopColor))
                                    echo esc_attr($templateData->params->text3DesktopColor); ?>'
                                data-default-color="#000000" />
                        </div>
                    </div>
                </div>
                <hr>
                <div class="ntdz_flex_img">
                    <div class="ntdz_col-md-8 ntdz_section_template ntdz_sect_img">
                        <span><?php esc_html_e('3.Download a suitable image for your template', 'notifadz-by-adrenalead-web-push-notifications'); ?></span>
                        <p class="">
                            <?php esc_html_e('Choose your brand image (recommended size: 640*426px) :', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                        </p>
                        <input type="text" id="logo" name="logo" data-img="logoChosen"
                            class="ntdz-form-control url-input"
                            placeholder="<?php esc_html_e('Paste your image url (recommended size: 640*426px)', 'notifadz-by-adrenalead-web-push-notifications'); ?>"
                            value="<?php if (!empty($templateData->logoDesktop))
                                echo esc_attr($templateData->logoDesktop); ?>"
                            required="" autofocus="" aria-label="Token" aria-describedby="basic-addon1">
                        <div class="ntdz_btn_action">
                            <a class="toCropper" href="#"
                                target="_blank"><?php esc_html_e('Using the library', 'notifadz-by-adrenalead-web-push-notifications'); ?></a>
                        </div>
                        <p class="mt-4">
                            <b><?php esc_html_e('*Use your media library to add an image and resize it. Then copy its url and paste it into the field above.', 'notifadz-by-adrenalead-web-push-notifications'); ?></b>
                        </p>
                    </div>
                    <div class="ntdz_col-md-4 ntdz_back_img">
                        <div class="ntdz_img_contain">
                            <img id="logoChosen"
                                src="<?php if (!empty($templateData->logoDesktop))
                                    echo esc_attr($templateData->logoDesktop); ?>"
                                class="" />
                        </div>
                    </div>
                </div>
                <div class="ntdz_h2_block">
                    <span class="dashicons dashicons-smartphone"></span>
                    <?php esc_html_e('Mobile version', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                    <hr class="ntdz_dott">
                </div>
                <div class="ntdz_section_template">
                    <span><?php esc_html_e('4.Customize the mobile template texts', 'notifadz-by-adrenalead-web-push-notifications'); ?></span>
                    <p class="">
                        <?php esc_html_e('Choose which message to display when your mobile template appears:', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                    </p>
                    <div class="input-group">
                        <div class="mt-4">
                            <input class="ntdz-form-control mt-4" id="textMobile" maxlength="80"
                                placeholder="<?php esc_html_e('Be notified of our latest news and exclusive offers in real time', 'notifadz-by-adrenalead-web-push-notifications'); ?>"
                                type="text" name="textMobile"
                                value="<?php if (!empty($templateData->params->textMobile))
                                    echo esc_attr($templateData->params->textMobile);
                                else
                                    esc_html_e('Be notified of our latest news and exclusive offers in real time', 'notifadz-by-adrenalead-web-push-notifications'); ?>"
                                required="" autofocus="" aria-describedby="basic-addon1">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="ntdz_flex_img">
                    <div class="ntdz_col-md-8 ntdz_section_template ntdz_sect_img">
                        <span><?php esc_html_e('5.Download a logo for the mobile version', 'notifadz-by-adrenalead-web-push-notifications'); ?></span>
                        <p class="">
                            <?php esc_html_e('Download the logo that will appear on the mobile version (recommended size: 320x150px):', 'notifadz-by-adrenalead-web-push-notifications'); ?>
                        </p>
                        <input type="text" id="logoMobile" name="logoMobile" data-img="logoChosenMobile"
                            class="ntdz-form-control url-input"
                            placeholder=<?php esc_html_e('Paste the URL of your logo (recommended size: 320x150px)', 'notifadz-by-adrenalead-web-push-notifications'); ?>"
                            value="<?php if (!empty($templateData->logoMobile))
                                echo esc_attr($templateData->logoMobile); ?>"
                            required="" autofocus="" aria-label="Token" aria-describedby="basic-addon1">
                        <div class="ntdz_btn_action">
                            <a class="toCropper" href="#"
                                target="_blank"><?php esc_html_e('Use the library', 'notifadz-by-adrenalead-web-push-notifications'); ?></a>
                        </div>
                        <p class="mt-4">
                            <b><?php esc_html_e('*Use your media library to add an image and resize it. Then copy its url and paste it into the field above.', 'notifadz-by-adrenalead-web-push-notifications'); ?></b>
                        </p>
                    </div>
                    <div class="ntdz_col-md-4 ntdz_back_img_mobile">
                        <div class="ntdz_img_contain_mobile">
                            <img id="logoChosenMobile"
                                src="<?php if (!empty($templateData->logoMobile))
                                    echo esc_attr($templateData->logoMobile); ?>"
                                class="" />
                        </div>
                    </div>
                </div>
                <div id="" class="input-group mt-8">
                    <input class="ntdz_button" type="submit" id="get_script" name="page_lang"
                        value="<?php esc_html_e('Save changes', 'notifadz-by-adrenalead-web-push-notifications'); ?>" />
                </div>
                <!-- --------------- TEMPLATE SECTION END ------------------ -->
            </div>
        </div>
    </form>
</div>