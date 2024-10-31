=== Notifadz by Adrenalead - Web Push Notification ===
Contributors: Adrenalead
Donate link: https://adrenalead.com
Tags: Web push notification, web push, push, push messages, notification
Requires at least: 5.2
Tested up to: 6.6
Requires PHP: 7.2
Stable tag: 3.0.18
Version: 3.0.18
Author URI: https://adrenalead.com
Author: Adrenalead
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Text Domain: notifadz-by-adrenalead-web-push-notifications
Domain Path: /languages

With the Notifadz by Adrenalead plugin, start engaging and monetizing your audience via Web Push Notifications in just 10 minutes!

== Description ==

This plugin allows you to create your Notifadz account, customize your subscriber collection template, and configure your account.

== Features ==

- Supports: Chrome, Firefox, Microsoft Edge, Opera, Safari on desktop and Android
- Requires HTTPS
- Create a Notifadz account: If you don’t have an account yet, you can create one directly through the plugin. If you already have an account, simply enter your access token to connect it to the plugin.
- Configure your Web Push subscriber collection template: You can select your preferred template format, and also customize the text and image associated with your template for both desktop and mobile versions.
- Update your ads.txt: Find the lines to implement in your ads.txt file to maximize your revenue.
- Automatic setup via the plugin: The service worker.js and collection script are implemented automatically.
- Send new content via a Web Push Notification: To simplify the work of editorial teams, the plugin allows your article to be automatically sent as a push notification as soon as it’s published. Configure your send directly from the article creation page.

You can then track the growth of your subscriber base and the revenue generated directly on the Notifadz platform by logging into your account.

== Installation ==
1) Extract the zip file into your /wp-content/plugins/ directory or upload it via the plugin menu in your WordPress Dashboard.
2) Activate the plugin via the "Plugins" menu in WordPress.
3) Log in using your Notifadz account or create a new Notifadz account through the plugin.
4) Activate your collection template or configure a new one.
5) Add the ads.txt lines to your ads.txt file or create one if necessary.
6) Your customized template will now appear on your site with the notification request.
7) Bonus: if you have an e-merchant account, configure your marketing automation scripts.

== Frequently Asked Questions ==

= Where can I find tutorials for the tool?  =

Publisher: 

EN: https://documentation-notifadz.notion.site/Notifadz-User-guide-for-publishers-2fc44cdac1c24f24b057581fd0b6a168?pvs=74
FR: https://documentation-notifadz.notion.site/Notifadz-Guide-d-utilisation-diteurs-1f6e27d382e140099fde637e5a5c1bb1?pvs=74

E-merchants

EN: https://documentation-notifadz.notion.site/Notifadz-User-guide-for-advertisers-c8470524be994ad89e1d3a0ff8054eb6?pvs=74
FR: https://documentation-notifadz.notion.site/Notifadz-Guide-d-utilisation-annonceurs-dc7b841d75c84cb49b112948a405cfc8?pvs=74

= What is notifadz.com? =

At the same time, publishers who wish to can monetize their audiences and thus add an incremental source of revenue to their site, all without allocating additional ad spaces on their site! The ads are displayed directly on the user's screen, whether on desktop or mobile.

= What is Web Push Notification ? =

For publishing teams : Web Push Notifications allow publishers to retain their users by relaying their editorial content. Since users are redirected to the publisher’s website, Web Push is a booster for SEO and presence on Google Discover! Articles can be sent on demand or automatically through synchronization with the publisher’s RSS feeds.

Note: Web Push can also be used to push more commercial messages, for example, to boost the sale of paid content.

About monetization : At the same time, publishers who wish to can monetize their audiences and thus add an incremental source of revenue to their site, all without allocating additional ad spaces on their site! The ads are displayed directly on the user's screen, whether on desktop or mobile.

== External Scripts ==

The collection script refers to a remote script hosted by Adrenalead that enables the registration of subscriptions to the web push service.

== External service ==

The plugin connects to the NotifAdz API, which belongs to Adrenalead, the publisher of the plugin, in order to function properly.

Here is the complete list of URLs called and their usage:

- https://apis.notifadz.com/api/v1/templates : Used to create, retrieve or modify collection templates
- https://apis.notifadz.com/api/v1/cgv : Used to get terms and conditions depending on the account type
- https://apis.notifadz.com/api/v1/accounts/ : Used to get account information and connect account
- https://apis.notifadz.com/api/v1/accounts/wordpress : Used to create new accounts
- https://secure-apis.notifadz.com/notifadz-v2/campaign/planned : Used to send article as notification

Publisher FR CGV : [Link Text](https://statics.pushaddict.com/CGV/publishers/FR/CGV_publishers_V_1.10_fr.pdf)
Publisher EN T&C : [Link Text](https://statics.pushaddict.com/CGV/publishers/EN/CGV_publishers_V_1.10_en.pdf)

Advertiser CGV : [Link Text](https://statics.pushaddict.com/CGV/advertisers/FR/CGV_advertisers_V_1.9_fr.pdf)
Advertiser T&C : [Link Text](https://statics.pushaddict.com/CGV/advertisers/EN/CGV_advertisers_V_1.9_en.pdf)

== Screenshots ==

[https://adrenalead.com/wp-content/uploads/2024/04/SC-acces-wordpress-plugin-notifadz-EN-1024x423.jpg Find and install the plugin]
[https://adrenalead.com/wp-content/uploads/2024/09/Tableau-de-bord-Adrenalead-Plugin.gif Configure your template]
[https://adrenalead.com/wp-content/uploads/2024/04/SC-reglages-adstxt-plugin-notifadz-EN-1024x636.png Technical configuration and optimization]
[https://adrenalead.com/wp-content/uploads/2024/04/SC-article-push-plugin-notifadz-EN-1024x500.png Turning every article into an opportunity]

== Changelog ==

= 3.0.18 =
* Condition fix for checking e-merchants subscription

= 3.0.17 =
* Addition of the e-merchants connection
* Addition of the triggers section for e-merchants
* Modification of the account creation form
* Switching to the new API dedicated to users

= 3.0.16 =
* Switch to native English and support for FR translations

= 3.0.15 =
* Adding affiliate program

= 3.0.14 =
* Fix log error

= 3.0.13 =
* Adding English for pt_BR

= 3.0.12 =
* Warning fix

= 3.0.11 =
* CSS on select element fix

= 3.0.10 =
* Text update
* Javascript error fix

= 3.0.9 =
* Log error fix

= 3.0.8 =
* Minor bug fix

= 3.0.7 =
* Addition of a feature allowing to send an article as a push notification upon its publication

= 3.0.6 =
* Adding en_US language

= 3.0.5 =
* Bug corrections

= 3.0.4 =
* Update file ads.txt

= 3.0.3 =
* Added manually integration of ads.txt

= 3.0.2 =
* Update optinbox picture issues
* Black color default added to text

= 3.0.1 =
* Graphic redesign
* Added color modification
* Added of modification of mobile hook
* Added mobile and desktop image upload

= 2.0.1 =
* Added Token area
* Added ads.txt and serviceworker.js files
* First upload