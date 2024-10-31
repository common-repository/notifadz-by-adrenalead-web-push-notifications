<?php
	if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div id="ntdz_fonctionnalites_page" class="ntdz-none ntdz-template-page">
	<span class="ntdz_h1_block"><span class="dashicons dashicons-admin-settings"></span><?php esc_html_e('Settings', 'notifadz-by-adrenalead-web-push-notifications'); ?></span>
    <hr class="ntdz_dott">
	<form id="" role="form" data-toggle="validator" method="post">
		<div class="ntdz_box_row">
			<div class="ntdz_box_col75">
                <?php if (!notifadz_is_advertiser()) { ?>
                <div class="ntdz_h2_block">
					<span><?php esc_html_e( 'ADS.TXT:', 'notifadz-by-adrenalead-web-push-notifications' ); ?></span>
                    <hr class="ntdz_dott">
				</div>
				<p class="mb-8"><?php esc_html_e( 'Copy these lines into your ads.txt file to improve your revenues', 'notifadz-by-adrenalead-web-push-notifications' ); ?></p>
                <p class="mb-8 ntdz_notif ntdz_notif_warning ntdz-none">
                    <span class="dashicons dashicons-bell ntdz_bell_notif"></span>
                    <span class="ntdz-oblique"><?php esc_html_e(' It seems that your ads.txt doesn\'t yet contain these elements (or doesn\'t exist), so don\'t forget to include them!', 'notifadz-by-adrenalead-web-push-notifications' ); ?></span>
                </p>
				<div id="ads_code_block" class="input-group">
                    <button class="nadzCopyButton btn-copy-textarea"
                            data-textarea-id="nadzAdsLine_textarea"
                            title="<?php esc_html_e('Copy the lines', 'notifadz-by-adrenalead-web-push-notifications') ?>" id="copyScript">
                        <span class="dashicons dashicons-admin-page"></span>
                    </button>
					<code id="nadzAdsLine"><?php 
                            $adsContent = get_option('adrenalead_notifadz_ads') ?? '';
                            echo nl2br(esc_html($adsContent));
                        ?></code>
						<textarea id="nadzAdsLine_textarea" class="ntdz-none">
							<?php echo get_option('adrenalead_notifadz_ads');?>
						</textarea>
				</div>
                <?php } ?>
				<div class="ntdz_h2_block">
					<span><?php esc_html_e( 'Logout:', 'notifadz-by-adrenalead-web-push-notifications' ); ?></span>
				</div>
				<p class="mb-8"><?php esc_html_e( 'Pause monetization of my audience. By clicking on the "Deactivate monetization on my site" button, all formats will be deactivated.', 'notifadz-by-adrenalead-web-push-notifications' ); ?></p>
				<div class="input-group mt-10">
					<a href="?page=notifadz_settings&reset=1" class="ntdz_button_grey"><span class="dashicons dashicons-migrate"></span><?php esc_html_e( 'Deactivate monetization on my site', 'notifadz-by-adrenalead-web-push-notifications' ); ?></a>
				</div>
			</div>
		</div>
	</form>
</div>