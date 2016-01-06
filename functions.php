<?php

// remove default style.css, load wwntbm-mos.css
function add_theme_styles() {
    wp_dequeue_style( 'twentysixteen-style-css' );
    wp_enqueue_style( 'wwntbm-mos-styles', get_stylesheet_directory_uri() . '/wwntbm-mos.css' );
}
add_action( 'wp_enqueue_scripts', 'add_theme_styles' );

// tweak default fonts
function twentysixteen_fonts_url() {
    $fonts_url = '';
    $fonts     = array();
    $subsets   = 'latin,latin-ext';

    if ( 'off' !== _x( 'on', 'Merriweather font: on or off', 'twentysixteen' ) ) {
        $fonts[] = 'Merriweather:400,700,300italic,400italic,700italic';
    }

    if ( 'off' !== _x( 'on', 'Montserrat font: on or off', 'twentysixteen' ) ) {
        $fonts[] = 'Montserrat:400,700';
    }

    if ( $fonts ) {
        $fonts_url = add_query_arg( array(
            'family' => urlencode( implode( '|', $fonts ) ),
            'subset' => urlencode( $subsets ),
        ), 'https://fonts.googleapis.com/css' );
    }

    return $fonts_url;
}
