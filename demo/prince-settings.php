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
					'title'   => __( 'Option Types', 'theme-text-domain' ),
					'content' => '<p>' . __( 'Help content goes here!', 'theme-text-domain' ) . '</p>'
				)
			),
			'sidebar' => '<p>' . __( 'Sidebar content goes here!', 'theme-text-domain' ) . '</p>'
		),
		'sections'        => array(
			array(
				'id'    => 'top_header_menu',
				'icon'  => 'prince-icon-dashboard',
				'title' => __( 'Top Header Menus', 'theme-text-domain' )
			),
			array(
				'id'    => 'site_info',
				'title' => __( 'Site Info', 'theme-text-domain' )
			),
			array(
				'id'    => 'header',
				'title' => __( 'Hero Section', 'theme-text-domain' )
			),
			array(
				'id'    => 'services',
				'title' => __( 'Services Section', 'theme-text-domain' )
			),
			array(
				'id'    => 'expertise',
				'title' => __( 'Expertise Section', 'theme-text-domain' )
			),
			array(
				'id'    => 'skills',
				'title' => __( 'Skills Section', 'theme-text-domain' )
			),

			array(
				'id'    => 'portfolios',
				'title' => __( 'Portfolios Section', 'theme-text-domain' )
			),
			array(
				'id'    => 'testimonals',
				'title' => __( 'Testimonials Section', 'theme-text-domain' )
			),

			array(
				'id'    => 'call_to_action',
				'title' => __( 'Call To Action Section', 'theme-text-domain' )
			),
			array(
				'id'    => 'about',
				'title' => __( 'About Page', 'theme-text-domain' )
			),

		),
		'settings'        => array(

			/*
			>>>>Top Header Section
			*/


			array(
				'id'      => 'top_header_menu_on_off',
				'label'   => 'On/ Off',
				'desc'    => 'On/ Off Your Top Header',
				'std'     => 'off',
				'block'         => true,
				'type'    => 'on-off',
				'section' => 'top_header_menu'
			),

			array(
				'id'      => 'top_header_menu_email',
				'label'   => 'Email',
				'desc'    => 'Enter Your Email Address',
				'std'     => 'hello@hello.com',
				'type'    => 'text',
				'block'         => true,
				'section' => 'top_header_menu'
			),

			array(
				'id'      => 'top_header_menu_phone',
				'label'   => 'Phone Number',
				'desc'    => 'Enter Your Phone Number',
				'std'     => '+88017419209857',
				'type'    => 'text',
				'section' => 'top_header_menu'
			),
			array(
				'id'       => 'top_header_menu_socials',
				'label'    => 'Social Icons and Address',
				'desc'     => 'Enter Your Social Icons',
				'std'      => '',
				'block'      => true,
				'type'     => 'list-item',
				'section'  => 'top_header_menu',
				'settings' => array(
					array(
						'id'    => 'top_header_menu_socials_icon',
						'label' => 'Social Icons',
						'title' => 'Social Icon Type',
						'desc'  => 'Enter Your Social Icon. Use Font-awesome classes for creating icon. e.g for facebook use <b>fa fa-facebook-square </b>',
						'std'   => 'fa fa-a',
						'block'      => true,
						'type'  => 'text'
					),
					array(
						'id'    => 'top_header_menu_socials_link',
						'block'      => true,
						'label' => 'Social Icons Link',
						'title' => 'Social Icons Link',
						'desc'  => 'Enter Your Social Icon Link. . e.g for facebook use <b>www.facebook.com/6611.prince</b>',
						'std'   => 'https://www.facebook.com/6611.prince',
						'type'  => 'text'
					)
				)
			),

			/*
			>>>>Site Info Section
			*/

			array(
				'id'      => 'site_logo',
				'label'   => 'Logo',
				'desc'    => 'Upload a logo. Recomended size is <b>70x60 px</b>',
				'std'     => get_template_directory_uri() . '/princelogo.png',
				'type'    => 'upload',
				'section' => 'site_info'
			),

			array(
				'id'      => 'site_favicon',
				'label'   => 'Favicon',
				'desc'    => 'Upload a Favicon. Recomended size is <b>70x60 px</b>',
				'std'     => get_template_directory_uri() . '/princelogo.png',
				'type'    => 'upload',
				'section' => 'site_info'
			),

			array(
				'id'      => 'site_copyright',
				'label'   => 'Copyright',
				'desc'    => 'Upload a Favicon. Recomended size is <b>70x60 px</b>',
				'std'     => 'Copyright © 2017 <a href="#">Prince</a>| All rights reserved by <a href="#">PrinceBoss</a>.',
				'type'    => 'text',
				'section' => 'site_info'
			),


			/*
			>>>>Header Section
			*/

			array(/*>>>>>-- Background Tab -- <<<<<<*/
				'id'      => 'header_bg_tab',
				'label'   => 'Background',
				'type'    => 'tab',
				'section' => 'header'
			),
			array(
				'id'      => 'header_bg',
				'label'   => 'Background',
				'desc'    => 'Change your Header Background. Recomended size is <b>1260x285 px</b>',
				'std'     => '',
				'type'    => 'background',
				'section' => 'header'
			),
			array(
				'id'      => 'particle_bg_on_off',
				'label'   => 'Particles Background',
				'desc'    => 'On/ OFF Particles Background',
				'std'     => 'on',
				'type'    => 'on-off',
				'section' => 'header'
			),

			array(
				'id'      => 'particle_bg_number',
				'desc'    => 'The Number Of particles',
				'std'     => '80',
				'type'    => 'text',
				'section' => 'header'
			),

			array(
				'id'      => 'particle_bg_color',
				'desc'    => 'The Number Of particles',
				'std'     => '#ffffff',
				'type'    => 'colorpicker',
				'section' => 'header'
			),

			array(
				'id'      => 'particle_bg_shape',
				'label'   => 'Particles Shape',
				'desc'    => 'The Number Of particles',
				'std'     => '["circle","image"]',
				'type'    => 'text',
				'section' => 'header'
			),

			array(
				'id'      => 'particle_bg_shape_image',
				'desc'    => 'The Number Of particles',
				'std'     => 'http://localhost/wp/wp-content/uploads/2017/10/logo.png',
				'type'    => 'upload',
				'section' => 'header'
			),

			array(
				'id'      => 'particle_bg_opacity',
				'desc'    => 'The Number Of particles',
				'std'     => '0.5',
				'type'    => 'text',
				'section' => 'header'
			),

			array(
				'id'      => 'particle_bg_line_linked_on_off',
				'label'   => 'Particles Line Linked',
				'desc'    => 'The Number Of particles',
				'std'     => 'on',
				'type'    => 'on-off',
				'section' => 'header'
			),

			array(
				'id'      => 'particle_bg_line_linked_color',
				'desc'    => 'The Number Of particles',
				'std'     => '#ffffff',
				'type'    => 'colorpicker',
				'section' => 'header'
			),

			array(
				'id'      => 'particle_bg_move',
				'label'   => 'Particles Move',
				'desc'    => 'The Number Of particles',
				'std'     => 'on',
				'type'    => 'on-off',
				'section' => 'header'
			),

			array(
				'id'      => 'particle_bg_move_speed',
				'desc'    => 'The Number Of particles',
				'std'     => '3',
				'type'    => 'text',
				'section' => 'header'
			),

			array(
				'id'      => 'particle_bg_events_onhover',
				'label'   => 'Partcile Events On Hover',
				'desc'    => 'The Number Of particles',
				'std'     => 'on',
				'type'    => 'on-off',
				'section' => 'header'
			),
			array(
				'id'      => 'particle_bg_events_onhover_mode',
				'desc'    => 'The Number Of particles',
				'std'     => 'repulse',
				'type'    => 'text',
				'section' => 'header'
			),

			array(
				'id'      => 'particle_bg_events_onclick',
				'label'   => 'Partcile Events On Click',
				'desc'    => 'The Number Of particles',
				'std'     => 'on',
				'type'    => 'on-off',
				'section' => 'header'
			),

			array(
				'id'      => 'particle_bg_events_onclick_mode',
				'desc'    => 'The Number Of particles',
				'std'     => 'push',
				'type'    => 'text',
				'section' => 'header'
			),

			array(/*>>>>>-- Typing Text Tab -- <<<<<<*/
				'id'      => 'header_type_tab',
				'label'   => 'Typing Text',
				'type'    => 'tab',
				'section' => 'header'
			),

			array(
				'id'      => 'header_type_texts',
				'label'   => 'Typing Text',
				'desc'    => 'Add the <b> Typing Texts </b> html',
				'std'     => '',
				'type'    => 'textarea',
				'section' => 'header',
			),

			array(/*>>>>>-- Button Tab -- <<<<<<*/
				'id'      => 'header_btn_tab',
				'label'   => 'Button',
				'type'    => 'tab',
				'section' => 'header'
			),
			array(
				'id'      => 'header_btn',
				'label'   => 'Button Text',
				'desc'    => 'Add Button Text',
				'std'     => "YES! I'AM AVAILABLE FOR WORK",
				'type'    => 'text',
				'section' => 'header'
			),
			array(
				'id'      => 'header_btn_link',
				'label'   => 'Button Link',
				'desc'    => 'Add Button Link',
				'std'     => esc_url( "link" ),
				'type'    => 'text',
				'section' => 'header'
			),
			array(/*>>>>>-- Bottom Tab -- <<<<<<*/
				'id'      => 'header_bottom_tab',
				'label'   => 'Bottom',
				'type'    => 'tab',
				'section' => 'header'
			),
			array(
				'id'      => 'header_bottom',
				'label'   => 'Bottom Text',
				'desc'    => 'Add Bottom Text',
				'std'     => "Learn More What I do",
				'type'    => 'text',
				'section' => 'header'
			),

			/*
			>>>>Services Section
			*/
			array(/*>>>>>-- Title Tab -- <<<<<<*/
				'id'      => 'services_title_tab',
				'label'   => 'Title',
				'type'    => 'tab',
				'section' => 'services'
			),
			array(
				'id'      => 'services_title',
				'label'   => 'Title Text',
				'desc'    => 'Add Title Text',
				'std'     => "SERVICES",
				'type'    => 'text',
				'section' => 'services'
			),
			array(
				'id'      => 'services_subtitle',
				'label'   => 'Subtitle Text',
				'desc'    => 'Add Subtitle Text',
				'std'     => "Lorem ipsum dolor sit amet, consectetur adipiscing elit",
				'type'    => 'text',
				'section' => 'services'
			),

			array( /*>>>>>-- Services Posts Tab -- <<<<<<*/
				'id'      => 'services_posts_tab',
				'label'   => 'Services Posts',
				'type'    => 'tab',
				'section' => 'services'
			),
			array(
				'id'      => 'services_posts',
				'label'   => 'Services',
				'desc'    => 'Select Posts for services section',
				'std'     => "",
				'type'    => 'category-select',
				'section' => 'services'
			),

			array( /*>>>>>-- Bottom Tab -- <<<<<<*/
				'id'      => 'services_bottom_tab',
				'label'   => 'Bottom',
				'type'    => 'tab',
				'section' => 'services'
			),
			array(
				'id'      => 'services_bottom_text',
				'label'   => 'Bottom Text',
				'desc'    => 'Add Bottom Text',
				'std'     => "ALL ABOUT SERVICES",
				'type'    => 'text',
				'section' => 'services'
			),
			array(
				'id'      => 'services_bottom_page',
				'label'   => 'Action Page',
				'desc'    => 'Select an action page.',
				'std'     => "",
				'type'    => 'page-select',
				'section' => 'services'
			),


			/*
			>>>>Expertise Section
			*/

			array(/*>>>>>-- Title Tab -- <<<<<<*/
				'id'      => 'expertise_title_tab',
				'label'   => 'Title',
				'type'    => 'tab',
				'section' => 'expertise'
			),
			array(
				'id'      => 'expertise_title',
				'label'   => 'Title Text',
				'desc'    => 'Add Title Text',
				'std'     => "MY EXPERTISE",
				'type'    => 'text',
				'section' => 'expertise'
			),
			array(
				'id'      => 'expertise_subtitle',
				'label'   => 'Subtitle Text',
				'desc'    => 'Add Subtitle Text',
				'std'     => "I possess more than 12 years of web design and front-end development experience for commercial and federal clients.",
				'type'    => 'text',
				'section' => 'expertise'
			),

			array( /*>>>>>-- Expertise Posts Tab -- <<<<<<*/
				'id'      => 'expertise_posts_tab',
				'label'   => 'Portfoilos Posts',
				'type'    => 'tab',
				'section' => 'expertise'
			),
			array(
				'id'      => 'expertise_posts',
				'label'   => 'Portfolios',
				'desc'    => 'Select Posts for Portfolios section',
				'std'     => "",
				'type'    => 'category-select',
				'section' => 'expertise'
			),
			/*
			>>>>Skills Section
			*/

			array(/*>>>>>-- Title Tab -- <<<<<<*/
				'id'      => 'skills_title_tab',
				'label'   => 'Title',
				'type'    => 'tab',
				'section' => 'skills'
			),
			array(
				'id'      => 'skills_title',
				'label'   => 'Title Text',
				'desc'    => 'Add Title Text',
				'std'     => "MY EXPERTISE",
				'type'    => 'text',
				'section' => 'skills'
			),
			array(
				'id'      => 'skills_subtitle',
				'label'   => 'Subtitle Text',
				'desc'    => 'Add Subtitle Text',
				'std'     => "I possess more than 12 years of web design and front-end development experience for commercial and federal clients.",
				'type'    => 'text',
				'section' => 'skills'
			),

			array( /*>>>>>-- sKILLS Posts Tab -- <<<<<<*/
				'id'      => 'skills_items_tab',
				'label'   => 'Portfoilos Posts',
				'type'    => 'tab',
				'section' => 'skills'
			),
			array(
				'id'       => 'skills_items',
				'label'    => 'Skills Items',
				'desc'     => 'Add skilss for Skilss section',
				'std'      => "",
				'type'     => 'list-item',
				'section'  => 'skills',
				'settings' => array(
					array(
						'id'    => 'skills_label',
						'label' => 'Skill Label',
						'desc'  => 'Add skilss label Skill items',
						'std'   => "",
						'type'  => 'text',
					),

					array(
						'id'    => 'skills_value',
						'label' => 'Skill Value',
						'desc'  => 'Add skills Value Skill items',
						'std'   => "",
						'type'  => 'text',
					),
				)
			),

			/*
			>>>>Portfolios Section
			*/
			array(/*>>>>>-- Title Tab -- <<<<<<*/
				'id'      => 'portfolios_title_tab',
				'label'   => 'Title',
				'type'    => 'tab',
				'section' => 'portfolios'
			),
			array(
				'id'      => 'portfolios_title',
				'label'   => 'Title Text',
				'desc'    => 'Add Title Text',
				'std'     => "MY EXPERTISE",
				'type'    => 'text',
				'section' => 'portfolios'
			),
			array(
				'id'      => 'portfolios_subtitle',
				'label'   => 'Subtitle Text',
				'desc'    => 'Add Subtitle Text',
				'std'     => "I possess more than 12 years of web design and front-end development experience for commercial and federal clients.",
				'type'    => 'text',
				'section' => 'portfolios'
			),

			array( /*>>>>>-- Portfolios Posts Tab -- <<<<<<*/
				'id'      => 'portfolios_posts_tab',
				'label'   => 'Portfolios Posts',
				'type'    => 'tab',
				'section' => 'portfolios'
			),
			array(
				'id'        => 'portfolios_posts',
				'label'     => 'Portfolios',
				'desc'      => 'Select Posts for portfolios section',
				'std'       => "",
				'type'      => 'custom-post-type-checkbox',
				'section'   => 'portfolios',
				'post_type' => 'portfolios',
			),
			array( /*>>>>>-- Action Tab -- <<<<<<*/
				'id'      => 'portfolios_action_tab',
				'label'   => 'Action',
				'type'    => 'tab',
				'section' => 'portfolios'
			),
			array(
				'id'      => 'portfolios_action_btn',
				'label'   => 'Button Text',
				'desc'    => "The button text.",
				'std'     => "LET'S WORK TOGETHER",
				'type'    => 'text',
				'section' => 'portfolios',
			),
			array(
				'id'      => 'portfolios_action',
				'label'   => 'Action Page',
				'desc'    => "",
				'std'     => "http://",
				'type'    => 'text',
				'section' => 'portfolios',
			),

			/*
			>>>>Testimonals Section
			*/
			array(/*>>>>>-- Title Tab -- <<<<<<*/
				'id'      => 'testimonals_title_tab',
				'label'   => 'Title',
				'type'    => 'tab',
				'section' => 'testimonals'
			),
			array(
				'id'      => 'testimonals_title',
				'label'   => 'Title Text',
				'desc'    => 'Add Title Text',
				'std'     => "MY EXPERTISE",
				'type'    => 'text',
				'section' => 'testimonals'
			),
			array(
				'id'      => 'testimonals_subtitle',
				'label'   => 'Subtitle Text',
				'desc'    => 'Add Subtitle Text',
				'std'     => "I possess more than 12 years of web design and front-end development experience for commercial and federal clients.",
				'type'    => 'text',
				'section' => 'testimonals'
			),
			array(
				'id'      => 'testimonals_side_desc',
				'label'   => 'Side Description',
				'desc'    => 'Add Subtitle Text',
				'std'     => "I possess more than 12 years of web design and front-end development experience for commercial and federal clients.",
				'type'    => 'textarea-simple',
				'rows'    => 4,
				'section' => 'testimonals'
			),

			array( /*>>>>>-- Portfolios Posts Tab -- <<<<<<*/
				'id'      => 'testimonals_posts_tab',
				'label'   => 'Testimonals Posts',
				'type'    => 'tab',
				'section' => 'testimonals'
			),
			array(
				'id'       => 'testimonals_reviews',
				'label'    => 'Testimonals',
				'desc'     => 'Select Posts for portfolios section',
				'std'      => "",
				'type'     => 'list-item',
				'section'  => 'testimonals',
				'settings' => array(
					array(
						'id'    => 'testimonals_client',
						'label' => 'Testimonals Client',
						'desc'  => 'Select Posts for portfolios section',
						'std'   => "",
						'type'  => 'text'
					),
					array(
						'id'    => 'testimonals_client_desc',
						'label' => 'Client Description',
						'desc'  => 'Select Posts for portfolios section',
						'std'   => "",
						'type'  => 'text'
					),
					array(
						'id'    => 'testimonals_client_img',
						'label' => 'Client Image',
						'desc'  => 'Select Posts for portfolios section',
						'std'   => "",
						'type'  => 'upload'
					),
					array(
						'id'    => 'testimonals_client_review',
						'label' => 'Reivew',
						'desc'  => 'Select Posts for portfolios section',
						'std'   => "STD",
						'rows'  => 3,
						'type'  => 'textarea-simple'
					),

				)
			),


			/*
			>>>>Call To Action Section
			*/

			array(/*>>>>>-- Title Tab -- <<<<<<*/
				'id'      => 'call_to_action_title_tab',
				'label'   => 'Title',
				'type'    => 'tab',
				'section' => 'call_to_action'
			),
			array(
				'id'      => 'call_to_action_title',
				'label'   => 'Title Text',
				'desc'    => 'Add Title Text',
				'std'     => "MY EXPERTISE",
				'type'    => 'text',
				'section' => 'call_to_action'
			),
			array(
				'id'      => 'call_to_action_description',
				'label'   => 'Description',
				'desc'    => 'Add Subtitle Text',
				'std'     => "I possess more than 12 years of web design and front-end development experience for commercial and federal clients.",
				'type'    => 'text',
				'section' => 'call_to_action'
			),


			array( /*>>>>>-- Action Tab -- <<<<<<*/
				'id'      => 'call_to_action_action_tab',
				'label'   => 'Action',
				'type'    => 'tab',
				'section' => 'call_to_action'
			),

			array(
				'id'      => 'call_to_action_btn',
				'label'   => 'Button Text',
				'desc'    => "The button text",
				'std'     => "LET'S WORK TOGETHER",
				'type'    => 'text',
				'section' => 'call_to_action',
			),

			array(
				'id'      => 'call_to_action_action',
				'label'   => 'Action Page',
				'desc'    => "Select a page for navigate the user.",
				'std'     => "",
				'type'    => 'page-select',
				'section' => 'call_to_action',
			),


			/*
			*About Page
			*/

			array(/* Main Tab */
				'id'      => 'about_tab',
				'label'   => 'Main',
				'type'    => 'tab',
				'section' => 'about',
			),

			array(
				'id'      => 'about_title',
				'label'   => 'Page Title',
				'desc'    => "Add some text to the page title",
				'std'     => "WoW!, A whole page just about me.",
				'type'    => 'text',
				'section' => 'about',
			),

			array(
				'id'      => 'about_image',
				'label'   => 'Image',
				'desc'    => "Add some text to the page title",
				'std'     => "http://localhost/wp/wp-content/themes/prince/princeme.pnga",
				'type'    => 'upload',
				'section' => 'about',
			),

			array(
				'id'      => 'about_socials_tab',
				'label'   => 'Socials',
				'type'    => 'tab',
				'section' => 'about',
			),

			array(
				'id'      => 'about_socials_title',
				'label'   => 'Title',
				'desc'    => "Add some text to the page title",
				'std'     => "BE MY BFF",
				'type'    => 'text',
				'section' => 'about',
			),

			array(
				'id'       => 'about_socials_icon_list',
				'label'    => 'Socials Icons',
				'desc'     => "Add some text to the page title",
				'std'      => "",
				'type'     => 'list-item',
				'section'  => 'about',
				'settings' => array(

					array(
						'id'      => 'about_socials_icon',
						'label'   => 'Social Icon',
						'desc'    => "Add some text to the page title",
						'std'     => "fa fa-facebook-square",
						'type'    => 'text',
						'section' => 'about',
					),

					array(
						'id'      => 'about_socials_link',
						'label'   => 'Social Link',
						'desc'    => "Add some text to the page title",
						'std'     => "",
						'type'    => 'text',
						'section' => 'about',
					),

				)
			),

			array(/* Description Tab */
				'id'      => 'about_desc_tab',
				'label'   => 'Description',
				'type'    => 'tab',
				'section' => 'about',
			),

			array(
				'id'      => 'about_desc_title',
				'label'   => 'Description Title',
				'desc'    => "Add some text to the page title",
				'std'     => 'Me Talking about myself.',
				'type'    => 'text',
				'section' => 'about',
			),


			array(
				'id'      => 'about_desc',
				'label'   => 'About Description',
				'desc'    => "Add some text to the page title",
				'std'     => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.unknown printer took a galley of type and scrambled it to make a type specimen book.unknown printer took a galley of type and scrambled it to make a type specimen book.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.unknown printer took a galley of type and scrambled it to make a type specimen book.unknown printer took a galley of type and scrambled it to make a type specimen book.",
				'type'    => 'textarea-simple',
				'section' => 'about',
			),


			array(/* Skills Tab */
				'id'      => 'about_skills_tab',
				'label'   => 'Skills set',
				'type'    => 'tab',
				'section' => 'about',
			),

			array(
				'id'      => 'about_skills_title',
				'label'   => 'Skills  Title',
				'desc'    => "Add some text to the page title",
				'std'     => 'My SKILL SET',
				'type'    => 'text',
				'section' => 'about',
			),

			array(
				'id'       => 'about_skills_list',
				'label'    => 'Skills',
				'desc'     => "Add some text to the page title",
				'std'      => "",
				'type'     => 'list-item',
				'section'  => 'about',
				'settings' => array(

					array(
						'id'      => 'about_skills_img',
						'label'   => 'Thumbnail',
						'desc'    => "Add some text to the page title",
						'std'     => "http://localhost/wp/wp-content/themes/prince/princefiverr.PNG",
						'type'    => 'upload',
						'section' => 'about',
					),

					array(
						'id'      => 'about_skills_name',
						'label'   => 'Skills Name',
						'desc'    => "Add some text to the page title",
						'std'     => "HTML",
						'type'    => 'text',
						'section' => 'about',
					),

					array(
						'id'      => 'about_skills_color',
						'label'   => 'Skill bar color',
						'desc'    => "Add some text to the page title",
						'std'     => "#337ab7",
						'type'    => 'colorpicker',
						'section' => 'about',
					),

					array(
						'id'      => 'about_skills_value',
						'label'   => 'Skill Value',
						'desc'    => "Add some text to the page title out of 100",
						'std'     => "",
						'type'    => 'text',
						'section' => 'about',
					),

				),
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