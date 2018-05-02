<?php
defined( 'ABSPATH' ) || exit;

/**
 * Replace feed urls
 *
 * @param mixed $source
 *
 * @return mixed
 */
function asse_action_feed_replace_url( $buffer, $source ) {
    // exit if not feed
    if ( ! is_feed() ) {
        return $buffer;
    }

    // check to be feed
    return preg_replace_callback( '/(["\'])(\/?data\/uploads[^\\1]*?)\\1/i', function ( $m ) {
        $path = substr( $m[2], 0, 1 ) === '/' ? $m[2] : '/' . $m[2];

        return $m[1] . FRONT_URL . $path . $m[1];
    }, $buffer );
}


/**
 * Function to start replace
 *
 * @wp-hook wp_head
 */
function asse_action_feed() {
    ob_start( 'asse_action_feed_replace_url' );
}

add_action( 'atom_head', 'asse_action_feed' );
add_action( 'rss_head', 'asse_action_feed' );
add_action( 'rss2_head', 'asse_action_feed' );
add_action( 'afbia_head', 'asse_action_feed' );
