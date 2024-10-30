=== MinhNhut Link Gateway ===
Contributors: minhnhut
Tags: link, redirect
Donate link: http://minhnhut.info
Requires at least: 3.0.1
Tested up to: 3.6
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Linking Gateway for Outbound link. Take resposible for redirecting user to target external url. This plugin allow you to create a custom page that people will see before they leave your website.

== Description ==
This plugin take care of Outbound link. Take resposible for redirecting user to target external url. This plugin allow you to create a custom page that people will see before they leave your website.

Using shortcode is required to make redirector work correctly.

-- How to use

After activate plugin, a new redirector page will be created. That page will take responsible for redirecting. You can customize it by creating new template in your theme.

Shortcode to use in your posts

[linkgate url="..."]Click here[/linkgate]

Or

[linkgate url="..." title="..."]Click here[/linkgate]

== Installation ==
1. Upload \"mn-linkgate.zip\" to the \"/wp-content/plugins/\" directory.
2. Extract it.
3. Activate the plugin through the \"Plugins\" menu in WordPress.
4. Customize plugin\'s options in Settings -> Link Gate Redirector.

== Frequently Asked Questions ==
= How to use? =
Simply use shortcode in your post's content:

[linkgate url="..."]Click here[/linkgate]

Or

[linkgate url="..." title="..."]Click here[/linkgate]

= How do I create redirector page? =
It should be created automatically when you activate the plug-in first time. If this was not created or you have deleted it by accident, just creating a new page with any title you want, and this shortcode [linkgate-redirector] in the content. Remember to add slug for your page. It should be \"redirect\". If you use different page slug for redirector page, you might update it in Settings -> Link Gate Redirector -> Redirect page\'s slug.

= How do I change template for my redirector page? =
Redirector page is just a normal page in WordPress. You can customize it easily by creating new page template file in your theme. And use it as template for your redirector page.

= Does your plug-in support other language? =
Front end redirector page\'s texts are 100% customizable via Settings -> Link Gate Redirector. However, Back end options page is currently in English. I just have a plan to translate it to many language. However, i don\'t have much time to it right now. It would be appreciated if you could help me to translate it to your local language. Please send me a message, if you interest.

== Screenshots ==
1. The screenshot description corresponds to screenshot-1.(png|jpg|jpeg|gif).
2. The screenshot description corresponds to screenshot-2.(png|jpg|jpeg|gif).
3. The screenshot description corresponds to screenshot-3.(png|jpg|jpeg|gif).

== Changelog ==
= 1.0 =
* Initial release.

== Upgrade Notice ==
= 1.0 =
* Initial release.