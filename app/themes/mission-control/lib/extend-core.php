<?php

namespace Apollo\Extend\Core;

// IMAGE SIZES
// =============================================================================

// add_image_size($name, $width, $height, $hard_crop);


// WP CORE
// =============================================================================

// Allow SVG uploads (1)
function mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes',  __NAMESPACE__ . '\\mime_types');

// Fix SVG Thumb Display (1)
function fix_svg_thumb_display() {
  echo '
    <style type="text/css">
      td.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail {
        width: 100% !important;
        height: auto !important;
      }
    </style>
  ';
}
add_action('admin_head',  __NAMESPACE__ . '\\fix_svg_thumb_display');


// WP HEAD FUNCTIONS
// =============================================================================

// Typekit
function typekit() {
  echo '<script type="text/javascript" src="//use.typekit.net/' . TYPEKIT_ID . '.js"></script>';
  echo '<script type="text/javascript">try{Typekit.load();}catch(e){}</script>';
}

if (TYPEKIT_ID) {
  add_action('wp_head', __NAMESPACE__ . '\\typekit', 1);
}


// CREDITS:
// (1) https://css-tricks.com/snippets/wordpress/allow-svg-through-wordpress-media-uploader/
