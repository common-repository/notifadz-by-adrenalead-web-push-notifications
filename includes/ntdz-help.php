<?php
if (!defined('ABSPATH'))
	exit; // Exit if accessed directly
$locale = get_locale();
?>
<div id="ntdz_help_page" class="ntdz-none ntdz-template-page">
	<form id="" role="form" data-toggle="validator" method="post">
		<h2 class="ntdz_h2_block">
			<?php esc_html_e('Adrenalead Technical Support', 'notifadz-by-adrenalead-web-push-notifications'); ?>
		</h2>
		<div class="ntdz_desc_head">
			<p><?php esc_html_e('A template with a default visual will be set up on your site, enabling you to start collecting subscribers. You can then customize it by logging into your account directly on notifadz.com', 'notifadz-by-adrenalead-web-push-notifications'); ?>
			</p>
		</div>
		<div class="ntdz_box_row">
			<div class="ntdz_box_col75">
				<!-- --------------- TEMPLATE SECTION ------------------ -->
				<div class="ntdz_flex">
					<a href="https://adrenalead.com/contact/" target="_blank" style="text-decoration : none;">
						<div class="ntdz_help_center mr-4">
							<img src="<?php echo esc_attr(plugins_url('../res/img/ntdz_help.jpg', __FILE__)) ?>"
								class="mb-4" />
							<p><?php esc_html_e('Contact technical support', 'notifadz-by-adrenalead-web-push-notifications'); ?>
							</p>
						</div>
					</a>
					<?php if ($locale == 'fr_FR'): ?>
						<a href="https://documentation-notifadz.notion.site/Notifadz-Guide-d-utilisation-diteurs-1f6e27d382e140099fde637e5a5c1bb1"
							target="_blank" style="text-decoration : none;">
							<div class="ntdz_help_center mr-4">
								<img src="<?php echo esc_attr(plugins_url('../res/img/tutorial.jpg', __FILE__)) ?>"
									class="mb-4" />
								<p><?php esc_html_e('Discover our  tutorials', 'notifadz-by-adrenalead-web-push-notifications'); ?>
								</p>
							</div>
						</a>
					<?php else: ?>
						<a href="https://documentation-notifadz.notion.site/Notifadz-User-guide-for-publishers-2fc44cdac1c24f24b057581fd0b6a168"
							target="_blank" style="text-decoration : none;">
							<div class="ntdz_help_center mr-4">
								<img src="<?php echo esc_attr(plugins_url('../res/img/tutorial.jpg', __FILE__)) ?>"
									class="mb-4" />
								<p><?php esc_html_e('Discover our  tutorials', 'notifadz-by-adrenalead-web-push-notifications'); ?>
								</p>
							</div>
						</a>
					<?php endif; ?>
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
		</div>
	</form>
</div>