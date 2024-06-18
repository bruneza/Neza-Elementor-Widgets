<?php
/**
 * Define constants.
 */
define('NEZA_THEME_DIR', get_stylesheet_directory());
define('NEZA_THEME_URL', get_stylesheet_directory_uri());
define('NEZA_ELE_DIR', NEZA_THEME_DIR . '/elementor');

/**
 * Enqueue styles and scripts.
 */
function neza_enqueue_styles() {
    // Enqueue the child theme's styles.
    wp_enqueue_style('neza-styles', get_stylesheet_uri(), array('hello-elementor','hello-elementor-theme-style'), rand(0, 111));
    wp_enqueue_style('neza-you-channel-grid', NEZA_THEME_DIR. '/assets/css/you-channel-grid.css', false, rand(0, 111));
    
}
add_action('wp_enqueue_scripts', 'neza_enqueue_styles', 200);

/**
 * Require Essentiala file.
 */
require_once NEZA_ELE_DIR . '/init.php';

// print_r(NEZA_ELE_DIR);
/**
 * Load plugin textdomain.
 */
load_plugin_textdomain('neza');