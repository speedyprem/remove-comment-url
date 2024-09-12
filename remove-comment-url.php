<?php
/*
Plugin Name: Remove Comment URL
Plugin URI: https://www.premtiwari.in/remove-comment-url/
Description: Allows administrators to globally disable the URL/Website input field from the WordPress inbuilt comments form on their site.
Author: Prem Tiwari
Version: 1.2.0
Author URI: https://www.premtiwari.in/
*/

/**
 * Function to unset the website field from the comments form.
 * @param Array $fields
 * @return Array
 */
function rcu_disable_comment_url( $fields ) {
    if ( isset( $fields['url'] ) ) {
        unset( $fields['url'] );
        return $fields;
    }
}
// Hook our function rcu_disable_comment_url with the filter comment_form_default_fields.
add_filter( 'comment_form_default_fields', 'rcu_disable_comment_url' );

// Filter to remove the existing links from the comments.
add_filter( 'get_comment_author_url', function( $url, $comment_ID, $comment ) {
    if ( ! is_admin() && $comment->user_id !== get_post()->post_author && ! user_can( $comment->user_id, 'manage_options' ) ) {
        return '';
    }
    return $url;
}, 10, 3 );
