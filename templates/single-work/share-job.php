<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post;

$company_id = (int)Opaljob_Query::get_company_by_work($post->ID);

$facebook     = get_post_meta($company_id , OPALJOB_COMPANY_PREFIX . 'facebook', true );
$twitter      = get_post_meta($company_id , OPALJOB_COMPANY_PREFIX . 'twitter', true );
$google		  = get_post_meta($company_id , OPALJOB_COMPANY_PREFIX . 'google', true );
$pinterest    = get_post_meta($company_id , OPALJOB_COMPANY_PREFIX . 'pinterest', true );
$linkedin     = get_post_meta($company_id , OPALJOB_COMPANY_PREFIX . 'linkedin', true );

$share_url     = urlencode( get_permalink() );
$share_title   = urlencode( get_the_title() );
$share_source  = urlencode( get_bloginfo( 'name' ) );
$share_content = urlencode( get_the_content() );
$share_media   = wp_get_attachment_thumb_url( get_post_thumbnail_id() );
$popup_attr    = 'resizable=0, toolbar=0, menubar=0, status=0, location=0, scrollbars=0';


if ( $facebook || $twitter || $google || $pinterest || $linkedin ) {
	echo '<div class="bo-social-icons">';
	echo '<span class="opaljob-social-title">';
	echo empty( $title ) ? __("Share this job",'opaljob') : $title;
	echo '</span>';
	if($facebook) {
		echo '<a href="#share" class="bo-social-white radius-x"'
				. ' title="' . __( 'Share on Facebook', 'opaljob' ) . '"'
						. ' onclick="window.open('
								. "'http://www.facebook.com/sharer.php?u={$share_url}&amp;t={$share_title}','popupFacebook','width=650,height=270,{$popup_attr}');"
								. ' return false;">';
		echo '<i  class="fa fa-facebook"></i></a>';
	}

	if($twitter) {
		echo '<a href="#share" class="bo-social-white radius-x""'
				. ' title="' . __( 'Share on Twitter', 'opaljob' ) . '"'
						. ' onclick="window.open('
								. "'https://twitter.com/intent/tweet?text={$share_title}&amp;url={$share_url}','popupTwitter','width=500,height=370,{$popup_attr}');"
								. ' return false;">';
		echo '<i  class="fa fa-twitter"></i></a>';
	}

	if($google) {
		echo '<a href="#share" class="bo-social-white radius-x""'
				. ' title="' . __( 'Share on Google+', 'opaljob' ) . '"'
						. ' onclick="window.open('
						. "'https://plus.google.com/share?url={$share_url}','popupGooglePlus','width=650,height=226,{$popup_attr}');"
						. ' return false;">';
		echo '<i  class="fa fa-google-plus"></i></a>';
	}

	if($pinterest) {
		echo '<a href="#share" class="bo-social-white radius-x""'
				. ' title="' . __( 'Share on Pinterest', 'opaljob' ) . '"'
						. ' onclick="window.open('
								. "'http://pinterest.com/pin/create/button/?url={$share_url}&amp;media={$share_media}&amp;description={$share_title}','popupPinterest','width=750,height=265,{$popup_attr}');"
								. ' return false;">';
		echo '<i  class="fa fa-printest"></i></a>';
	}

	if($linkedin) {
		echo '<a href="#share" class="bo-social-white radius-x""'
				. ' title="' . __( 'Share on LinkedIn', 'opaljob' ) . '"'
						. ' onclick="window.open('
								. "'http://www.linkedin.com/shareArticle?mini=true&amp;url={$share_url}&amp;title={$share_title}&amp;source={$share_source}','popupLinkedIn','width=610,height=480,{$popup_attr}');"
								. ' return false;">';
		echo '<i  class="fa fa-linkedin"></i></a>';
	}

	echo '</div>'; 
}