<?php

define( MOS_THEME_VERSION, wp_get_theme()->get( 'Version' ) );

// remove default style.css, load wwntbm-mos.css
function add_theme_styles() {
    wp_dequeue_style( 'twentysixteen-style-css' );
    wp_enqueue_style( 'wwntbm-mos-styles', get_stylesheet_directory_uri() . '/wwntbm-mos.css', array(), MOS_THEME_VERSION );
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
add_filter( 'wpcw_front_course_outline_column_count', function() { return 1; } );

function add_duration_header() {
    return '<td class="length-header">Length</td>';
}
add_filter( 'wpcw_front_course_outline_column_header', 'add_duration_header' );

function add_duration_content( $content, $unit ) {
    return '<td class="duration">' . get_field( 'video_duration', $unit->ID ) .'</td>';
}
add_filter( 'wpcw_front_course_outline_column_content', 'add_duration_content', 10, 2 );

// enable comments on units
add_post_type_support( 'course_unit', 'comments' );

// enqueue responsive-videos.js
function add_responsive_videos_js() {
    wp_enqueue_script( 'responsive-videos', get_stylesheet_directory_uri() . '/js/responsive-videos.min.js', array( 'jquery' ), MOS_THEME_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'add_responsive_videos_js' );

// add login page branding
add_filter( 'login_headerurl', function() { return home_url(); } );

function login_styles() { ?>
    <style type="text/css" media="screen">
        body, html {
            background-color: #181818;
            color: #a3a3a3;
        }
        #login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/WWNTBM-logo-on-dark.png);
            background-size: contain;
            width: 100%;
            height: 150px;
        }
    </style>
<?php }
add_action('login_head', 'login_styles' );
