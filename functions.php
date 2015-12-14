<?php

function add_theme_styles() {
    wp_dequeue_style( 'twentysixteen-style-css' );
    wp_enqueue_style( 'wwntbm-mos-styles', get_stylesheet_directory_uri() . '/wwntbm-mos.css' );
}
add_action( 'wp_enqueue_scripts', 'add_theme_styles' );
