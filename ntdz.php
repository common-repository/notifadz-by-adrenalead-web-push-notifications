<?php
/*
Plugin Name: Notifadz by Adrenalead - Web Push Notifications
Plugin URI: http://wordpress.org/plugins/Notifadz-by-Adrenalead-Web-Push-Notifications/
Description: L'extension Notifadz d'Adrenalead vous facilite l'activation de la collecte d'abonnés aux Web Push Notifications directement depuis votre site internet.
Author: Adrenalead
Version: 3.0.18
Author URI: https://adrenalead.com
License: GPLv3 or later
Text Domain: notifadz-by-adrenalead-web-push-notifications
Domain Path: /includes/languages

*/

/*
Copyright © 2021 Notifadz by Adrenalead.
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define('NADZ_PLUGIN_URL', plugin_dir_url(__FILE__));

register_activation_hook(__FILE__, 'notifadz_adrenalead_activation');

register_deactivation_hook(__FILE__, 'notifadz_adrenalead_deactivation');

function notifadz_adrenalead_activation()
{
    notifadz_adrenalead_rewrite_rules();
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
}

function notifadz_adrenalead_deactivation()
{
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
    notifadz_adrenalead_delete_options();
}

function notifadz_adrenalead_delete_options($isResetFromUpdate = false)
{
    if (false === $isResetFromUpdate) {
        delete_option('adrenalead_notifadz_script');
    }
    delete_option('adrenalead_notifadz_account_id');
    delete_option('adrenalead_notifadz_token');
    delete_option('adrenalead_notifadz_profil');
    delete_option('adrenalead_notifadz_template_data');
    delete_option('adrenalead_notifadz_need_to_copy_ads');
    delete_option('adrenalead_notifadz_ads');
    delete_option('adrenalead_notifadz_worker');
    delete_option('adrenalead_notifadz_ids');
    delete_option('adrenalead_notifadz_script_triggers');
    delete_option('adrenalead_notifadz_need_confirm_template');
    delete_option('adrenalead_notifadz_confirm_template_id');
    delete_option('adrenalead_notifadz_script_triggers_activated');
    delete_option('adrenalead_notifadz_tab');
}

// admin

require_once plugin_dir_path(__FILE__) . 'includes/ntdz-functions.php';




