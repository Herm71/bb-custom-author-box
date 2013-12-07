<?php
/**
 * Plugin Name: Custom Author Box
 * Plugin URI: http://www.blackbirdconsult.com
 * Description: Customize the Genesis Authorbox
 * Version: 1.0
 * Author: Jason Chafin
 * Author URI: http://www.blackbirdconsult.com
 * License: GPL2
 */
 
 
 // REGISTER STYLES
function plugin_style() { 
	  wp_register_style( 'plugin-style', plugins_url('custom-author-box.css', __FILE__));
	  wp_enqueue_style( 'plugin-style' );
		}

add_action('wp_enqueue_scripts', 'plugin_style');

//Change contact info methods
function change_contact_info($contactmethods) {
    unset($contactmethods['aim']);
    unset($contactmethods['yim']);
    unset($contactmethods['jabber']);
    unset($contactmethods['gplus']);
    $contactmethods['website_title'] = 'Website Title';
    $contactmethods['twitter'] = 'Twitter';
    $contactmethods['facebook'] = 'Facebook';
    $contactmethods['linkedin'] = 'Linked In';
    $contactmethods['gplus'] = 'Google +';
    return $contactmethods;
}

add_filter('user_contactmethods','change_contact_info',10,1);

//Remove old author box and replace with new one
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8);
add_action('genesis_after_entry', 'theme_author_box', 8);

function theme_author_box() {
  $authinfo = "<div class=\"postauthor\">\r\n";
	$authinfo .= get_avatar(get_the_author_id() , 100);
	$authinfo .= "<h4>". get_the_author_meta('display_name') ."</h4>\r\n";
	$authinfo .= "<p>" . get_the_author_meta('description') . "</p>\r\n";
	$authinfo .= "</div>\r\n";
	$facebook = get_the_author_meta('facebook');
	$twitter = get_the_author_meta('twitter');
	$gplus = get_the_author_meta('gplus');
	$blog_title = get_the_author_meta('blog_title');

$flength = strlen($facebook);
$tlength = strlen($twitter);
$glength = strlen($gplus);
$llength = strlen($blog_title);
	
	$authsocial = "<div class=\"postauthor-bottom\"> <p><span>Connect With Me :</span>\r\n";	
if ($flength > 1) {
	$authsocial .= "<a class=\"author-fb\" href=\"http://facebook.com/" . $facebook . "\" target=\"_blank\" rel=\"nofollow\" title=\"" . get_the_author_meta('display_name') . " on Facebook\">Facebook</a>";
}

if ($glength > 1) {	
	$authsocial .="<a class=\"author-gplus\" href=\"" . $gplus . "\" rel=\"me\" target=\"_blank\" title=\"" . get_the_author_meta('display_name') . " on Google+\">Google+</a>";
}

if ($tlength > 1) {	
	$authsocial .= "<a class=\"author-twitter\" href=\"http://twitter.com/" . $twitter . "\" target=\"_blank\" rel=\"nofollow\" title=\"" . get_the_author_meta('display_name') . " on Twitter\">Twitter</a>";
}

if ($llength > 1) {	
	$authsocial .= "<a class=\"author-blog\" href=\"" . $blog_title . "\" target=\"_blank\" rel=\"nofollow\" title=\"" . get_the_author_meta('display_name') . " Personal Blog\">Personal Blog</a>";
}

	$authsocial .= "</p>\r\n";

	$authsocial .= "</div>\r\n";
	
	if ( is_single() ) {
		echo $authinfo;
		echo $authsocial;
	}
}