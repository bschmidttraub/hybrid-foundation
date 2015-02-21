<?php
/**
 * The configuration options for the Shoestrap Customizer
 */

/* Kirki configuration */
add_filter( 'kirki/config', 'hybrid_base_customizer_config' );

function hybrid_base_customizer_config() {

	$args = array(

		// Change the logo image. (URL)
		// If omitted, the default theme info will be displayed.
		// A good size for the logo is 250x50.
		'logo_image'   => get_template_directory_uri() . '/assets/images/theme-logo.png',

		// The color of active menu items, help bullets etc.
		'color_active' => '#1abc9c',

		// Color used for secondary elements and desable/inactive controls
		'color_light'  => '#8cddcd',

		// Color used for button-set controls and other elements
		'color_select' => '#34495e',

		// Color used on slider controls and image selects
		'color_accent' => '#FF5740',

		// The generic background color.
		// You should choose a dark color here as we're using white for the text color.
		'color_back'   => '#222',

		// This line is needed if Kirki is embedded.
		'url_path'     => get_template_directory_uri() . '/kirki/',

		// If you want to take advantage of the backround control's 'output',
		// then you'll have to specify the ID of your stylesheet here.
		// The "ID" of your stylesheet is its "handle" on the wp_enqueue_style() function.
		// http://codex.wordpress.org/Function_Reference/wp_enqueue_style
		'stylesheet_id' => 'style',

	);

	return $args;

}

/*
 * TYPOGRAPHY
 * =================================
 */


add_action( 'customize_register', 'section_typography' );

/**
 * Create the typography section
 */
function section_typography( $wp_customize ) {

	// Create the "My Section" section
	$wp_customize->add_section( 'section_typography', array(
		'title'    => __( 'Typography', 'hybrid_base' ),
		'priority' => 70
	) );

}

/**
 * Create the setting
 */
function settings_typography( $controls ) {

	$controls[] = array(
		'type'     => 'select',
		'setting'  => 'settings_typography_heading_font',
		'label'    => __( 'Heading Font', 'hybrid_base' ),
		'section'  => 'section_typography',
		'default'  => 'Alegreya',
		'priority' => 1,
		'choices'  => array(
			'Alegreya' => __( 'Alegreya', 'hybrid-base' ),
			'Open Sans' => __( 'Open Sans', 'hybrid-base' ),
			'Lato' => __( 'Lato', 'hybrid-base' ),
			'Roboto Condensed' => __( 'Roboto Condensed', 'hybrid-base' ),
		),
		'output' => array(
			'element'  => 'h1, h2, h3',
			'property' => 'font-family',
		),
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'settings_typography_heading_color',
		'label'    => __( 'Heading Colors', 'hybrid_base' ),
		'section'  => 'section_typography',
		'default'  => '#1abc9c',
		'priority' => 2,
		'output' => array(
			'element'  => 'h1, h2, h3',
			'property' => 'color',
		),
	);

	return $controls;
}
add_filter( 'kirki/controls', 'settings_typography' );

?>