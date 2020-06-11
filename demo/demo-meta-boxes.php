<?php
/**
 * Initialize the custom Meta Boxes.
 *
 * @package Prince
 */

add_action( 'admin_init', 'custom_meta_boxes' );

/**
 * Meta Boxes demo code.
 *
 * You can find all the available option types in demo-theme-options.php.
 *
 * @since     1.0.0
 */
function custom_meta_boxes() {

	/**
	 * Create a custom meta boxes array that we pass to
	 * the Prince Meta Box API Class.
	 */
	$my_meta_box = array(
		'id'       => 'demo_meta_box',
		'title'    => __( 'Demo Meta Box', 'prince-settings' ),
		'desc'     => '',
		'pages'    => array( 'post' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'label' => __( 'Conditions', 'prince-settings' ),
				'id'    => 'demo_conditions',
				'type'  => 'tab',
			),
			array(
				'label' => __( 'Show Gallery', 'prince-settings' ),
				'id'    => 'demo_show_gallery',
				'type'  => 'on-off',
				'class'  => 'disabled',
				'desc'  => sprintf( __( 'Shows the Gallery when set to %s.', 'prince-settings' ), '<code>on</code>' ),
				'std'   => 'off',
			),
			array(
				'label'     => '',
				'id'        => 'demo_textblock',
				'type'      => 'textblock',
				'desc'      => __( 'Congratulations, you created a gallery!', 'prince-settings' ),
				'operator'  => 'and',
				'condition' => 'demo_show_gallery:is(on),demo_gallery:not()',
			),
			array(
				'label'     => __( 'Gallery', 'prince-settings' ),
				'id'        => 'demo_gallery',
				'type'      => 'gallery',
				'desc'      => sprintf( __( 'This is a Gallery option type. It displays when %s.', 'prince-settings' ), '<code>demo_show_gallery:is(on)</code>' ),
				'condition' => 'demo_show_gallery:is(on)',
			),
			array(
				'label' => __( 'More Options', 'prince-settings' ),
				'id'    => 'demo_more_options',
				'type'  => 'tab',
			),
			array(
				'label' => __( 'Text', 'prince-settings' ),
				'id'    => 'demo_text',
				'type'  => 'text',
				'desc'  => __( 'This is a demo Text field.', 'prince-settings' ),
			),
			array(
				'label' => __( 'Textarea', 'prince-settings' ),
				'id'    => 'demo_textarea',
				'type'  => 'textarea',
				'desc'  => __( 'This is a demo Textarea field.', 'prince-settings' ),
			),
		),
	);

	/**
	 * Register our meta boxes using the
	 * prince_register_meta_box() function.
	 */
	if ( function_exists( 'prince_register_meta_box' ) ) {
		prince_register_meta_box( $my_meta_box );
	}
}
