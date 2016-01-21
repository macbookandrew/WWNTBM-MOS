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

// add header image dimensions
add_image_size( 'module-header', 1800, 300 );

// add page slug to body class
function add_slug_body_class( $classes ) {
    global $post;
    if ( isset( $post ) ) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    }
    return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

// add custom course content
add_filter( 'columncount', function() { return 1; } );

function add_duration_header() {
    return '<td>Duration</td>';
}
add_filter( 'columnheader', 'add_duration_header' );

function add_duration_content( $content, $unit ) {
    return '<td class="duration">' . get_field( 'video_duration', $unit->ID ) .'</td>';
}
add_filter( 'columncontent', 'add_duration_content', 10, 2 );

// enable comments on units
add_post_type_support( 'course_unit', 'comments' );
