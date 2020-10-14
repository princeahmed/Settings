<?php

/**
 * Initialize the custom Settings.
 */
add_action( 'init', 'prince_settings' );

/**
 * Build the custom settings & update Prince.
 *
 * @return    void
 * @since     1.0.0
 */
function prince_settings() {

	/* Prince is not loaded yet, or this is not an admin request */
	if ( ! function_exists( 'prince_settings_id' ) || ! is_admin() ) {
		return;
	}

	/**
	 * Get a copy of the saved settings array.
	 */
	$saved_settings = get_option( prince_settings_id(), array() );

	/**
	 * Custom settings array that will eventually be
	 * passes to the Prince Settings API Class.
	 */

	$custom_settings = array(
		'contextual_help' => array(
			'content' => array(
				array(
					'id'      => 'option_types_help',
					'title'   => __( 'Option Types', 'wp-radio' ),
					'content' => '<p>' . __( 'Help content goes here!', 'wp-radio' ) . '</p>'
				)
			),
			'sidebar' => '<p>' . __( 'Sidebar content goes here!', 'wp-radio' ) . '</p>'
		),
		'sections'        => array(
			array(
				'id'    => 'options',
				'icon'  => 'prince-icon-dashboard',
				'title' => __( 'Options', 'wp-radio' )
			),
		),
		'settings'        => array(

			array(
				'id'       => 'playlist',
				'label'    => 'Playlist',
				'desc'     => 'Playlist',
				'type'     => 'playlist',
				'section'  => 'options',
				'settings' => [
					'type' => 'video'
				],
			),
			array(
				'id'      => 'gallery',
				'label'   => 'Gallery',
				'desc'    => 'Gallery',
				'type'    => 'gallery',
				'section' => 'options'
			),


		)
	);

	/* allow settings to be filtered before saving */
	$custom_settings = apply_filters( prince_settings_id() . '_args', $custom_settings );

	/* settings are not the same update the DB */
	if ( $saved_settings !== $custom_settings ) {
		update_option( prince_settings_id(), $custom_settings );
	}

	/* Lets Prince know the UI Builder is being overridden */
	global $prince_has_custom_settings;
	$prince_has_custom_settings = true;

}