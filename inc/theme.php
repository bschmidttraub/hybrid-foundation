<?php

/* Register custom image sizes. */
add_action( 'init', 'hybrid_base_register_image_sizes', 5 );

/* Register custom menus. */
add_action( 'init', 'hybrid_base_register_menus', 5 );

/* Register sidebars. */
add_action( 'widgets_init', 'hybrid_base_register_sidebars', 5 );

/* Add custom scripts. */
add_action( 'wp_enqueue_scripts', 'hybrid_base_enqueue_scripts', 5 );

/* Add custom styles. */
add_action( 'wp_enqueue_scripts', 'hybrid_base_enqueue_styles', 5 );

/* Add a class to the header */
add_filter( 'hybrid_attr_branding', 'hybrid_base_attr_branding', 6 );

/**
 * Registers custom image sizes for the theme. 
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function hybrid_base_register_image_sizes() {

	/* Sets the 'post-thumbnail' size. */
	//set_post_thumbnail_size( 150, 150, true );
}

/**
 * Registers nav menu locations.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function hybrid_base_register_menus() {
	register_nav_menu( 'primary',    _x( 'Primary',    'nav menu location', 'hybrid-base' ) );
	register_nav_menu( 'secondary',  _x( 'Secondary',  'nav menu location', 'hybrid-base' ) );
	register_nav_menu( 'subsidiary', _x( 'Subsidiary', 'nav menu location', 'hybrid-base' ) );
}

/**
 * Registers sidebars.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function hybrid_base_register_sidebars() {

	hybrid_register_sidebar(
		array(
			'id'          => 'primary',
			'name'        => _x( 'Primary', 'sidebar', 'hybrid-base' ),
			'description' => __( 'Add sidebar description.', 'hybrid-base' )
		)
	);

	hybrid_register_sidebar(
		array(
			'id'          => 'subsidiary',
			'name'        => _x( 'Subsidiary', 'sidebar', 'hybrid-base' ),
			'description' => __( 'Add sidebar description.', 'hybrid-base' )
		)
	);
}

/**
 * Load scripts for the front end.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function hybrid_base_enqueue_scripts() {
	// ===== Foundation
	if ( current_theme_supports( 'foundation-base' ) ) {
		wp_enqueue_script( 'foundation', get_stylesheet_directory_uri() . '/assets/javascripts/foundation/foundation.js', 'jquery', FOUNDATION_VERSION, true );
	}

	// ===== Load Foundation components if supported by the theme
	$foundation_components = array(
		'abide', 'accordion', 'alert', 'clearing', 'dropdown', 'equalizer', 'interchange', 'joyride', 'magellan', 'offcanvas', 'orbit', 'reveal', 'slider', 'tab', 'tooltip', 'topbar'
	);

	foreach ( $foundation_components as $component ) {	
		if ( current_theme_supports( 'foundation-' . $component ) ) {
			wp_enqueue_script( 'foundation-' . $component, get_stylesheet_directory_uri() . '/assets/javascripts/foundation/foundation.' . $component . '.js', array( 'jquery' ), FOUNDATION_VERSION, true );
		}
	}

	// ===== Initialize Foundation
	if ( current_theme_supports( 'foundation-base' ) ) {
		wp_enqueue_script( 'foundation-init', get_stylesheet_directory_uri() . '/assets/javascripts/foundation.init.js', array( 'jquery' ), FOUNDATION_VERSION, true );
	}
}

/**
 * Load stylesheets for the front end.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function hybrid_base_enqueue_styles() {

	/* Gets ".min" suffix. */
	$suffix = hybrid_get_min_suffix();

	/* Load one-five base style. */
	// wp_enqueue_style( 'one-five', trailingslashit( HYBRID_CSS ) . "one-five{$suffix}.css" );

	/* Load gallery style if 'cleaner-gallery' is active. */
	if ( current_theme_supports( 'cleaner-gallery' ) ) {
		wp_enqueue_style( 'gallery', trailingslashit( HYBRID_CSS ) . "gallery{$suffix}.css" );
	}

	/* Load parent theme stylesheet if child theme is active. */
	if ( is_child_theme() ) {
		wp_enqueue_style( 'parent', trailingslashit( get_template_directory_uri() ) . "style{$suffix}.css" );
	}

	/* Load active theme stylesheet. */
	wp_enqueue_style( 'style', get_stylesheet_uri() );
}

/**
 * Filter the branding attributes.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function hybrid_base_attr_branding( $attr ) {
	$attr['class'] = 'title-area';
	return $attr;
}

/**
 * Callback function for adding editor styles.  Use along with the add_editor_style() function.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function hybrid_base_get_editor_styles() {

	/* Set up an array for the styles. */
	$editor_styles = array();

	/* Add the theme's editor styles. */
	$editor_styles[] = trailingslashit( get_template_directory_uri() ) . 'css/editor-style.css';

	/* If a child theme, add its editor styles. Note: WP checks whether the file exists before using it. */
	if ( is_child_theme() && file_exists( trailingslashit( get_stylesheet_directory() ) . 'css/editor-style.css' ) )
		$editor_styles[] = trailingslashit( get_stylesheet_directory_uri() ) . 'css/editor-style.css';

	/* Add the locale stylesheet. */
	$editor_styles[] = get_locale_stylesheet_uri();

	/* Uses Ajax to display custom theme styles added via the Theme Mods API. */
	$editor_styles[] = add_query_arg( 'action', 'hybrid_base_editor_styles', admin_url( 'admin-ajax.php' ) );

	/* Return the styles. */
	return $editor_styles;
}
