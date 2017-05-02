<?php

/**
 * Replace feed urls
 *
 * @param mixed $source
 * @return mixed
 */
function replaceFeedUrls($source) {
  // check to be feed
  if ((!defined('STATIC_URL') || STATIC_URL === "") && is_feed()) {
    return preg_replace_callback('/(["\'])(\/?data\/uploads[^\\1]*?)\\1/i', function($m) {
      $path = substr($m[2], 0, 1) === '/' ? $m[2] : '/' . $m[2];
      return $m[1] . FRONT_URL . $path . $m[1];
    }, $source);
  }
  return $source;
}


/**
 * Function to start replace
 *
 * @wp-hook wp_head
 */
function bufferReplaceFeed()
{
  ob_start('replaceFeedUrls');
}
add_action('atom_head', 'bufferReplaceFeed');
add_action('rss_head', 'bufferReplaceFeed');
add_action('rss2_head', 'bufferReplaceFeed');
