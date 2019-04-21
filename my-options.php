<?php
/**
 * Initialize the custom Theme Options.
 */
add_action( 'init', 'prince_theme_options' );

/**
 * Build the custom settings & update OptionTree.
 *
 * @return    void
 * @since     2.0
 */
function prince_theme_options() {

	/* OptionTree is not loaded yet, or this is not an admin request */
	if ( !function_exists( 'prince_settings_id' ) || !is_admin() )
		return false;

	/**
	 * Get a copy of the saved settings array. 
	 */
	$saved_settings = get_option( prince_settings_id(), array() );

	/**
	 * Custom settings array that will eventually be 
	 * passes to the OptionTree Settings API Class.
	 */
	$custom_settings = array(
		'contextual_help' => array(
			'content' => array(
				array(
					'id' => 'option_types_help',
					'title' => __( 'Option Types', 'theme-text-domain' ),
					'content' => '<p>' . __( 'Help content goes here!', 'theme-text-domain' ) . '</p>'
				)
			),
			'sidebar' => '<p>' . __( 'Sidebar content goes here!', 'theme-text-domain' ) . '</p>'
		),
		'sections' => array(
			array(
				'id' => 'top_header_menu',
				'title' => __( 'Top Header Menus', 'theme-text-domain' )
			),
		),
		'settings' => array(
		
		/*
		>>>>Top Header Section
		*/
		
		
		array(
				'id' => 'top_header_menu_on_off',
				'label' => 'On/ Off',
				'desc' => 'On/ Off Your Top Header',
				'std' => 'off',
				'type' => 'on-off',
				'section' => 'top_header_menu'
			),

			array(
				'id' => 'top_header_menu_email',
				'label' => 'Email',
				'desc' => 'Enter Your Email Address',
				'std' => 'hello@hello.com',
				'type' => 'text',
				'section' => 'top_header_menu'
			),

			array(
				'id' => 'top_header_menu_phone',
				'label' => 'Phone Number',
				'desc' => 'Enter Your Phone Number',
				'std' => '+88017419209857',
				'type' => 'text',
				'section' => 'top_header_menu'
			),
			array(
				'id' => 'top_header_menu_socials',
				'label' => 'Social Icons and Address',
				'desc' => 'Enter Your Social Icons',
				'std' => '',
				'type' => 'list-item',
				'section' => 'top_header_menu',
				'settings' => array(
					array(
						'id' => 'top_header_menu_socials_icon',
						'label' => 'Social Icons',
						'title' => 'Social Icon Type',
						'desc' => 'Enter Your Social Icon. Use Font-awesome classes for creating icon. e.g for facebook use <b>fa fa-facebook-square </b>',
						'std' => 'fa fa-',
						'type' => 'text'
					),
		array(
						'id' => 'top_header_menu_socials_link',
						'label' => 'Social Icons Link',
						'title' => 'Social Icons Link',
						'desc' => 'Enter Your Social Icon Link. . e.g for facebook use <b>www.facebook.com/6611.prince</b>',
						'std' => 'https://www.facebook.com/6611.prince',
						'type' => 'text'
					)
				)
			),
		) );

	/* allow settings to be filtered before saving */
	$custom_settings = apply_filters( prince_settings_id() . '_args', $custom_settings );

	/* settings are not the same update the DB */
	if ( $saved_settings !== $custom_settings ) {
		update_option( prince_settings_id(), $custom_settings );
	}

	/* Lets OptionTree know the UI Builder is being overridden */
	global $ot_has_custom_theme_options;
	$ot_has_custom_theme_options = true;

}