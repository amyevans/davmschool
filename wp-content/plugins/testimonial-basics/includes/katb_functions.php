<?php
/**
 * This file holds many of the functions used in Testimonial Basics
 * @package		Testimonial Basics WordPress Plugin
 * @copyright	Copyright (c) 2015, Kevin Archibald
 * @license		http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author		Kevin Archibald <www.kevinsspace.ca/contact/>
 * Testimonial Basics is distributed under the terms of the GNU GPL
 */
/**
 * Get Testimonial Basics Plugin Options
 * 
 * Array that holds all of the defined values
 * for Testimonial Basics Plugin Options. If the user 
 * has not specified a value for a given Theme 
 * option, then the option's default value is
 * used instead.
 *
 * @uses	katb_get_option_defaults()	defined below
 * 
 * @return	array	$katb_options	current values for all Theme options
 */
 
function katb_get_options() {

	// Get the option defaults
	$katb_option_defaults = katb_get_option_defaults();
	// Globalize the variable that holds the Theme options
	global $katb_options;
	// Parse the stored options with the defaults
	$katb_options = wp_parse_args( get_option( 'katb_testimonial_basics_options', array() ), $katb_option_defaults );
	// Return the parsed array
	//var_dump($katb_options);
	//wp_die();
	return $katb_options;
}

/**
 * Get Testimonial Basics Plugin Option Defaults
 * 
 * Array that holds all of the deault values
 * for Testimonial Basics Plugin Options. 
 *
 * @uses	katb_get_option_parameters()	defined below
 * 
 * 
 * @return	array	$katb_option_defaults	current default values for all Theme options
 */
function katb_get_option_defaults() {
	// Get the array that holds all
	// Theme option parameters
	$katb_option_parameters = katb_get_option_parameters();
	// Initialize the array to hold
	// the default values for all
	// Theme options
	$katb_option_defaults = array();
	// Loop through the option
	// parameters array
	foreach ( $katb_option_parameters as $katb_option_parameter ) {
		$name = $katb_option_parameter['name'];
		// Add an associative array key
		// to the defaults array for each
		// option in the parameters array
		$katb_option_defaults[$name] = $katb_option_parameter['default'];
	}
	// Return the defaults array
	return $katb_option_defaults;
}

/**
 * Get Testimonial Basics Plugin Option Parameters
 * 
 * Array that holds all of the parameters
 * for Testimonial Basics Plugin Options. 
 *
 * @return	array	$options	all elements for each option
 */
function katb_get_option_parameters() {
	
	$options = array (
/* ------------------------- General -------------------------------------- */
		'katb_admin_access_level' => array(
			'name' => 'katb_admin_access_level',
			'title' => esc_html__('User role to edit testimonials','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"Administrator", 
				"Editor"
			),
			'description' => esc_html__('default: Administrator','testimonial-basics'),
			'section' => 'general',
			'tab' => 'general',
			'default' => 'Administrator',
			'class' => 'select'
		),
		'katb_contact_email' => array(
			'name' => 'katb_contact_email',
			'title' => esc_html__('Testimonial notify email address','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Leave blank to use admin email','testimonial-basics'),
			'section' => 'general',
			'tab' => 'general',
			'default' => '',
			'class' => 'email'
		),
		'katb_use_ratings' => array(
			'name' => 'katb_use_ratings',
			'title' => esc_html__('Use Ratings','testimonial-basics'),
			'type' => 'checkbox',
			'description' => esc_html__('Use 5 star rating system','testimonial-basics'),
			'section' => 'general',
			'tab' => 'general',
			'default' => 0,
			'class' => 'checkbox'
		),
		'katb_use_css_ratings' => array(
			'name' => 'katb_use_css_ratings',
			'title' => esc_html__('Use CSS Rating System','testimonial-basics'),
			'type' => 'checkbox',
			'description' => esc_html__('Use CSS instead of jQuery','testimonial-basics'),
			'section' => 'general',
			'tab' => 'general',
			'default' => 0,
			'class' => 'checkbox'
		),
		'katb_star_color' => array(
			'name' => 'katb_star_color',
			'title' => esc_html__('Star color for css stars','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('default: #EACB1E, only used for css stars','testimonial-basics'),
			'section' => 'general',
			'tab' => 'general',
			'default' => '#EACB1E',
			'class' => 'ka_color'
		),
		'katb_star_shadow_color' => array(
			'name' => 'katb_star_shadow_color',
			'title' => esc_html__('Shadow color for the css stars','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('default: #000000, only used for css stars','testimonial-basics'),
			'section' => 'general',
			'tab' => 'general',
			'default' => '#000000',
			'class' => 'ka_color'
		),
		'katb_enable_rotator' => array(
			'name' => 'katb_enable_rotator',
			'title' => esc_html__('Enable the testimonial rotator script','testimonial-basics'),
			'type' => 'checkbox',
			'description' => esc_html__('Default: checked','testimonial-basics'),
			'section' => 'general',
			'tab' => 'general',
			'default' => 1,
			'class' => 'checkbox'
		),
		'katb_custom_css' => array(
			'name' => 'katb_custom_css',
			'title' => esc_html__('Custom CSS','testimonial-basics'),
			'type' => 'textarea',
			'description' => esc_html__('replace default css styles or add new ones ','testimonial-basics'),
			'section' => 'general',
			'tab' => 'general',
			'default' => '',
			'class' => 'css'
		),
		//Schema Markup
		'katb_use_schema' => array(
			'name' => 'katb_use_schema',
			'title' => esc_html__( 'Use schema markup' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Schema markup is used for Google Snippets to help SEO','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_schema_company_name' => array(
			'name' => 'katb_schema_company_name',
			'title' => esc_html__('Schema Company Name','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Name of Company the testimonials are about.','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' => '',
			'class' => 'nohtml'
		),
		'katb_schema_company_url' => array(
			'name' => 'katb_schema_company_url',
			'title' => esc_html__('Schema Company Website Reference','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Company website address ','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' => '',
			'class' => 'url'
		),
		'katb_schema_display_company' => array(
			'name' => 'katb_schema_display_company',
			'title' => esc_html__( 'Schema Display Company', 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Display company name and website','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' =>1, // 0 for off
			'class' => 'checkbox'
		),
		'katb_schema_display_aggregate' => array(
			'name' => 'katb_schema_display_aggregate',
			'title' => esc_html__( 'Schema Display Aggregate', 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Display a summary of reviews','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' =>1, // 0 for off
			'class' => 'checkbox'
		),
		'katb_schema_display_reviews' => array(
			'name' => 'katb_schema_display_reviews',
			'title' => esc_html__( 'Schema Display Reviews', 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Select to display the individual reviews','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' =>1, // 0 for off
			'class' => 'checkbox'
		),
		'katb_use_group_name_for_aggregate' => array(
			'name' => 'katb_use_group_name_for_aggregate',
			'title' => esc_html__( 'Use Group Name for Aggregate Name', 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Select to use the Group Name','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' =>1, // 0 for off
			'class' => 'checkbox'
		),
		'katb_custom_aggregate_review_name' => array(
			'name' => 'katb_custom_aggregate_review_name',
			'title' => esc_html__('Custom Aggregate Review Name','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Enter a name for the aggregate review','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' => '',
			'class' => 'nohtml'
		),
		'katb_individual_group_name' => array(
			'name' => 'katb_individual_group_name',
			'title' => esc_html__( 'Group Individual Review Name', 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Use group name for individual review name','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_individual_custom_name' => array(
			'name' => 'katb_individual_custom_name',
			'title' => esc_html__('Custom Individual Review Name','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('If not using the Group Name, enter one here','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' => '',
			'class' => 'nohtml'
		),
/* ------------------------- Input Form Options -------------------------------------- */
		'katb_auto_approve' => array(
			'name' => 'katb_auto_approve',
			'title' => esc_html__( 'Auto Approve Testimonials' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('CAUTION: Use at your own risk.','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_use_captcha' => array(
			'name' => 'katb_use_captcha',
			'title' => esc_html__( 'Use captcha on input forms' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Check to include captcha.','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_use_color_captcha' => array(
			'name' => 'katb_use_color_captcha',
			'title' => esc_html__( 'Use color captcha option' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Check to use the color captcha option','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_use_color_captcha_2' => array(
			'name' => 'katb_use_color_captcha_2',
			'title' => esc_html__( 'Use Color Captcha Option 2' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Least secure but most compatible','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_exclude_website_input' => array(
			'name' => 'katb_exclude_website_input',
			'title' => esc_html__('Exclude Website in input form','testimonial-basics'),
			'type' => 'checkbox',
			'description' => esc_html__('Default: unchecked','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' => 0,
			'class' => 'checkbox'
		),
		'katb_require_website_input' => array(
			'name' => 'katb_require_website_input',
			'title' => esc_html__('Require website input','testimonial-basics'),
			'type' => 'checkbox',
			'description' => esc_html__('Default: unchecked','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' => 0,
			'class' => 'checkbox'
		),
		'katb_exclude_location_input' => array(
			'name' => 'katb_exclude_location_input',
			'title' => esc_html__('Exclude Location in input form','testimonial-basics'),
			'type' => 'checkbox',
			'description' => esc_html__('Default: unchecked','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' => 0,
			'class' => 'checkbox'
		),
		'katb_require_location_input' => array(
			'name' => 'katb_require_location_input',
			'title' => esc_html__('Require Location input','testimonial-basics'),
			'type' => 'checkbox',
			'description' => esc_html__('Default: unchecked','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' => 0,
			'class' => 'checkbox'
		),
//Content Input Form
		'katb_include_email_note' => array(
			'name' => 'katb_include_email_note',
			'title' => esc_html__( 'Include email note' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Check to include','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_email_note' => array(
			'name' => 'katb_email_note',
			'title' => esc_html__('Email note','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Default:Email is not published','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 'Email is not published',
			'class' => 'nohtml'
		),
		'katb_use_popup_message' => array(
			'name' => 'katb_use_popup_message',
			'title' => esc_html__( 'Use popup messages' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Use popup messages for errors and thankyou','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_content_input_font_size' => array(
			'name' => 'katb_content_input_font_size',
			'title' => esc_html__('Base Font size','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"0.625em",
				"0.75em", 
				"0.875em",
				"1em",
				"1.125em",
				"1.25em",
				"1.375em"
			),
			'description' => esc_html__('1em is equal to 16px','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => '1em',
			'class' => 'select'
		),
		'katb_include_input_title' => array(
			'name' => 'katb_include_input_title',
			'title' => esc_html__( 'Include title on input form' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Check to include','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_input_title' => array(
			'name' => 'katb_input_title',
			'title' => esc_html__('Title for Input Form','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Default:Add a Testimonial','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 'Add a Testimonial',
			'class' => 'nohtml'
		),			
		'katb_show_html_content' => array(
			'name' => 'katb_show_html_content',
			'title' => esc_html__('Show html allowed strip in input form','testimonial-basics'),
			'type' => 'checkbox',
			'description' => esc_html__('Default: checked','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 1,
			'class' => 'checkbox'
		),
		'katb_show_gravatar_link' => array(
			'name' => 'katb_show_gravatar_link',
			'title' => esc_html__('Show gravatar link','testimonial-basics'),
			'type' => 'checkbox',
			'description' => esc_html__('Allows users to set up Gravatar','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 1,
			'class' => 'checkbox'
		),
		'katb_author_label' => array(
			'name' => 'katb_author_label',
			'title' => esc_html__('Author Label','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Default: Author*','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 'Author *',
			'class' => 'nohtml'
		),
		'katb_email_label' => array(
			'name' => 'katb_email_label',
			'title' => esc_html__('Email Label','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Default: Email*','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 'Email *',
			'class' => 'nohtml'
		),
		'katb_website_label' => array(
			'name' => 'katb_website_label',
			'title' => esc_html__('Website Label','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Default: Website','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 'Website',
			'class' => 'nohtml'
		),
		'katb_location_label' => array(
			'name' => 'katb_location_label',
			'title' => esc_html__('Location Label','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Default: Location','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 'Location',
			'class' => 'nohtml'
		),
		'katb_rating_label' => array(
			'name' => 'katb_rating_label',
			'title' => esc_html__('Rating Label','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Default: Rating','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 'Rating',
			'class' => 'nohtml'
		),
		'katb_testimonial_label' => array(
			'name' => 'katb_testimonial_label',
			'title' => esc_html__('Testimonial Label','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Default: Testimonial*','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 'Testimonial *',
			'class' => 'nohtml'
		),
		'katb_captcha_label' => array(
			'name' => 'katb_captcha_label',
			'title' => esc_html__('Captcha Label','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Default: Enter Captcha','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 'Enter Captcha',
			'class' => 'nohtml'
		),
		'katb_submit_label' => array(
			'name' => 'katb_submit_label',
			'title' => esc_html__('Submit Label','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Default: Submit','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 'Submit',
			'class' => 'nohtml'
		),
		'katb_reset_label' => array(
			'name' => 'katb_reset_label',
			'title' => esc_html__('Reset Label','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Default: Reset','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 'Reset',
			'class' => 'nohtml'
		),
		'katb_required_label' => array(
			'name' => 'katb_required_label',
			'title' => esc_html__('Required Label','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Default: * Required','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => '* Required',
			'class' => 'nohtml'
		),
/* ------------------------- Widget Input Form -------------------------------------- */
		'katb_include_widget_email_note' => array(
			'name' => 'katb_include_widget_email_note',
			'title' => esc_html__( 'Include email note' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Check to include','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_email_note' => array(
			'name' => 'katb_widget_email_note',
			'title' => esc_html__('Email note','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Default:Email is not published','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 'Email is not published',
			'class' => 'nohtml'
		),
		'katb_use_widget_popup_message' => array(
			'name' => 'katb_use_widget_popup_message',
			'title' => esc_html__( 'Use popup messages' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Use popup messages for errors and thankyou','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_input_font_size' => array(
			'name' => 'katb_widget_input_font_size',
			'title' => esc_html__('Base Font size','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"0.625em",
				"0.75em", 
				"0.875em",
				"1em",
				"1.125em",
				"1.25em",
				"1.375em"
			),
			'description' => esc_html__('1em is equal to 16px','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => '1em',
			'class' => 'select'
		),
		'katb_show_html_widget' => array(
			'name' => 'katb_show_html_widget',
			'title' => esc_html__('Show html allowed strip in widget form','testimonial-basics'),
			'type' => 'checkbox',
			'description' => esc_html__('Default: not checked','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 0,
			'class' => 'checkbox'
		),
		'katb_show_widget_gravatar_link' => array(
			'name' => 'katb_show_widget_gravatar_link',
			'title' => esc_html__('Show gravatar link','testimonial-basics'),
			'type' => 'checkbox',
			'description' => esc_html__('Allows users to set up Gravatar','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 1,
			'class' => 'checkbox'
		),
		'katb_widget_labels_above' => array(
			'name' => 'katb_widget_labels_above',
			'title' => esc_html__('Show input labels above input box','testimonial-basics'),
			'type' => 'checkbox',
			'description' => esc_html__('Default: not checked or inside input box','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 0,
			'class' => 'checkbox'
		),
		'katb_widget_author_label' => array(
			'name' => 'katb_widget_author_label',
			'title' => esc_html__('Widget Author Label','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Default: Author-Required','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 'Author-Required',
			'class' => 'nohtml'
		),
		'katb_widget_email_label' => array(
			'name' => 'katb_widget_email_label',
			'title' => esc_html__('Widget Email Label','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Default: Email-Required','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 'Email-Required',
			'class' => 'nohtml'
		),
		'katb_widget_website_label' => array(
			'name' => 'katb_widget_website_label',
			'title' => esc_html__('Widget Website Label','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Default: Website-Optional','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 'Website-Optional',
			'class' => 'nohtml'
		),
		'katb_widget_location_label' => array(
			'name' => 'katb_widget_location_label',
			'title' => esc_html__('Widget Location Label','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Default: Location-Optional','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 'Location-Optional',
			'class' => 'nohtml'
		),
		'katb_widget_rating_label' => array(
			'name' => 'katb_widget_rating_label',
			'title' => esc_html__('Widget Rating Label','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Default: Rating-Optional','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 'Rating',
			'class' => 'nohtml'
		),
		'katb_widget_testimonial_label' => array(
			'name' => 'katb_widget_testimonial_label',
			'title' => esc_html__('Widget Testimonial Label','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Default: Testimonial-Required','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 'Testimonial-Required',
			'class' => 'nohtml'
		),
		'katb_widget_captcha_label' => array(
			'name' => 'katb_widget_captcha_label',
			'title' => esc_html__('Widget Captcha Label','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Default: Enter Captcha','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 'Enter Captcha',
			'class' => 'nohtml'
		),
		'katb_widget_submit_label' => array(
			'name' => 'katb_widget_submit_label',
			'title' => esc_html__('Widget Submit Label','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Default: Submit','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 'Submit',
			'class' => 'nohtml'
		),
		'katb_widget_reset_label' => array(
			'name' => 'katb_widget_reset_label',
			'title' => esc_html__('Widget Reset Label','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Default: Reset','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 'Reset',
			'class' => 'nohtml'
		),
		'katb_widget_required_label' => array(
			'name' => 'katb_widget_required_label',
			'title' => esc_html__('Widget Required Label','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Optional-leave blank if not using','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => '',
			'class' => 'nohtml'
		),
// Content Display
		'katb_layout_option' => array(
			'name' => 'katb_layout_option',
			'title' => esc_html__('Layout Option','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"Top Meta",
				"Bottom Meta",
				"Side Meta" 
			),
			'description' => esc_html__('Try them to see what you prefer','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' => 'Bottom Meta',
			'class' => 'select'
		),
		'katb_content_font' => array(
			'name' => 'katb_content_font',
			'title' => esc_html__('Font for Content Display','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"default font", 
				"Georgia, serif",
				"Verdana, Geneva, sans-serif", 
				"Arial, Helvetica, sans-serif",
				"'Book Antiqua', 'Palatino Linotype', Palatino, serif",
				"Cambria, Georgia, serif",
				"'Comic Sans MS', sans-serif",
				"Tahoma, Geneva, sans-serif",
				"'Times New Roman', Times, serif",
				"'Trebuchet MS', Helvetica, sans-serif"									
			),
			'description' => esc_html__('default is theme font','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' => 'default font',
			'class' => 'select'
		),
		'katb_content_font_size' => array(
			'name' => 'katb_content_font_size',
			'title' => esc_html__('Base Font size','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"0.625em",
				"0.75em", 
				"0.875em",
				"1em",
				"1.125em",
				"1.25em",
				"1.375em"
			),
			'description' => esc_html__('1em is equal to 16px','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' => '1em',
			'class' => 'select'
		),
		'katb_use_pagination' => array(
			'name' => 'katb_use_pagination',
			'title' => esc_html__( 'Use pagination' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Check to include for ALL or ALL GROUP displays.','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_paginate_number' => array(
			'name' => 'katb_paginate_number',
			'title' => esc_html__('Testimonials per page','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"3",
				"5", 
				"10"
			),
			'description' => esc_html__('select 3, 5 or 10 per page','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' => '10',
			'class' => 'select'
		),
		'katb_use_excerpts' => array(
			'name' => 'katb_use_excerpts',
			'title' => esc_html__( 'Use excerpts in testimonial display' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Check to include','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_excerpt_length' => array(
			'name' => 'katb_excerpt_length',
			'title' => esc_html__('Excerpt length in words','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('default: 80','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' => '80',
			'class' => 'nohtml'
		),
		'katb_show_title' => array(
			'name' => 'katb_show_title',
			'title' => esc_html__( 'Show title in testimonial' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Use schema name options without the schema','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_show_website' => array(
			'name' => 'katb_show_website',
			'title' => esc_html__( 'Show website in testimonial' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Check to include website','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_show_date' => array(
			'name' => 'katb_show_date',
			'title' => esc_html__( 'Show date in testimonial' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Check to include date','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_show_location' => array(
			'name' => 'katb_show_location',
			'title' => esc_html__( 'Show location in testimonial' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Check to include location','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_use_gravatars' => array(
			'name' => 'katb_use_gravatars',
			'title' => esc_html__( 'Use gravatars' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Check to include','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_use_round_images' => array(
			'name' => 'katb_use_round_images',
			'title' => esc_html__( 'Use round gravatars/images' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('All images will be round','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_use_gravatar_substitute' => array(
			'name' => 'katb_use_gravatar_substitute',
			'title' => esc_html__( 'Use gravatar substitute' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Use substitute if gravatar unavailable','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_gravatar_size' => array(
			'name' => 'katb_gravatar_size',
			'title' => esc_html__('Gravatar size','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				'40',
				'50',
				'60',
				'70', 
				'80',
				'90',
				'100'
			),
			'description' => esc_html__('Select a size for the gravatar','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' => '80',
			'class' => 'select'
		),
		'katb_use_italic_style' => array(
			'name' => 'katb_use_italic_style',
			'title' => esc_html__( 'Use italic font style' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Check to include','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
//Rotator
		'katb_rotator_speed' => array(
			'name' => 'katb_rotator_speed',
			'title' => esc_html__('Time between slides','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				'4000',
				'5000',
				'6000',
				'7000',
				'8000',
				'9000',
				'10000',
				'11000',
				'12000',
				'13000',
				'14000'
			),
			'description' => esc_html__('default: 7000 ms, IE9,IE10 uses default','testimonial-basics'),
			'section' => 'content_rotator',
			'tab' => 'content_display',
			'default' => '7000',
			'class' => 'select'
		),
		'katb_rotator_height' => array(
			'name' => 'katb_rotator_height',
			'title' => esc_html__('Rotator height in pixels','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				'variable',
				'50',
				'75',
				'100',
				'125',
				'150',
				'175',
				'200',
				'225',
				'250',
				'275',
				'300',
				'325',
				'350'
			),
			'description' => esc_html__('default: variable','testimonial-basics'),
			'section' => 'content_rotator',
			'tab' => 'content_display',
			'default' => 'variable',
			'class' => 'select'
		),
		'katb_rotator_transition' => array(
			'name' => 'katb_rotator_transition',
			'title' => esc_html__('Rotator transition effect','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				'fade',
				'left to right',
				'right to left'
			),
			'description' => esc_html__('default: fade, IE9,IE10 uses default','testimonial-basics'),
			'section' => 'content_rotator',
			'tab' => 'content_display',
			'default' => 'fade',
			'class' => 'select'
		),
//Custom Display Options	
		'katb_use_formatted_display' => array(
			'name' => 'katb_use_formatted_display',
			'title' => esc_html__( 'Use formatted display' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Check to include','testimonial-basics'),
			'section' => 'content_custom_formats',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),		
		'katb_background_wrap_color' => array(
			'name' => 'katb_background_wrap_color',
			'title' => esc_html__('Color Option 1','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('wrap color: Top Meta,Bottom Meta, Meta box color: Side Meta','testimonial-basics'),
			'section' => 'content_custom_formats',
			'tab' => 'content_display',
			'default' => '#EDEDED',
			'class' => 'ka_color'
		),
		'katb_testimonial_box_color' => array(
			'name' => 'katb_testimonial_box_color',
			'title' => esc_html__('Color Option 2','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('Content Box Color','testimonial-basics'),
			'section' => 'content_custom_formats',
			'tab' => 'content_display',
			'default' => '#DBDBDB',
			'class' => 'ka_color'
		),
		'katb_testimonial_box_font_color' => array(
			'name' => 'katb_testimonial_box_font_color',
			'title' => esc_html__('Testimonial Box Font Color','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('default: #000000','testimonial-basics'),
			'section' => 'content_custom_formats',
			'tab' => 'content_display',
			'default' => '#000000',
			'class' => 'ka_color'
		),		
		'katb_author_location_color' => array(
			'name' => 'katb_author_location_color',
			'title' => esc_html__('Author,Location, and Date Color','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('default: #000000','testimonial-basics'),
			'section' => 'content_custom_formats',
			'tab' => 'content_display',
			'default' => '#000000',
			'class' => 'ka_color'
		),		
		'katb_website_link_color' => array(
			'name' => 'katb_website_link_color',
			'title' => esc_html__('Website Link Color','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('default: #3384E8','testimonial-basics'),
			'section' => 'content_custom_formats',
			'tab' => 'content_display',
			'default' => '#3384E8',
			'class' => 'ka_color'
		),
		'katb_website_link_hover_color' => array(
			'name' => 'katb_website_link_hover_color',
			'title' => esc_html__('Website Link Hover Color','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('default: #FFFFFF','testimonial-basics'),
			'section' => 'content_custom_formats',
			'tab' => 'content_display',
			'default' => '#FFFFFF',
			'class' => 'ka_color'
		),
//Widget
		'katb_widget_layout_option' => array(
			'name' => 'katb_widget_layout_option',
			'title' => esc_html__('Widget Layout Option','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"Top Meta",
				"Bottom Meta",
				"Image & Meta Top",
				"Image & Meta Bottom",
				"Centered Image & Meta Top",
				"Centered Image & Meta Bottom"
			),
			'description' => esc_html__('Try them to see what you prefer','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' => 'Bottom Meta',
			'class' => 'select'
		),
		'katb_widget_font' => array(
			'name' => 'katb_widget_font',
			'title' => esc_html__('Font for Widget Display','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"default font", 
				"Georgia, serif",				
				"Verdana, Geneva, sans-serif", 
				"Arial, Helvetica, sans-serif",
				"'Book Antiqua', 'Palatino Linotype', Palatino, serif",
				"Cambria, Georgia, serif",
				"'Comic Sans MS', sans-serif",
				"Tahoma, Geneva, sans-serif",
				"'Times New Roman', Times, serif",
				"'Trebuchet MS', Helvetica, sans-serif"									
			),
			'description' => esc_html__('default is theme font','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' => 'default font',
			'class' => 'select'
		),
		'katb_widget_font_size' => array(
			'name' => 'katb_widget_font_size',
			'title' => esc_html__('Base Font size','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"0.625em",
				"0.75em", 
				"0.875em",
				"1em",
				"1.125em",
				"1.25em",
				"1.375em"
			),
			'description' => esc_html__('1em is equal to 16px','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' => '1em',
			'class' => 'select'
		),
		'katb_widget_use_excerpts' => array(
			'name' => 'katb_widget_use_excerpts',
			'title' => esc_html__( 'Use excerpts in widget testimonial display' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Check to include','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_excerpt_length' => array(
			'name' => 'katb_widget_excerpt_length',
			'title' => esc_html__('Widget excerpt length in characters','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('default: 25','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' => '25',
			'class' => 'nohtml'
		),
		'katb_widget_show_title' => array(
			'name' => 'katb_widget_show_title',
			'title' => esc_html__( 'Show title in testimonial' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Use schema name options without the schema','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_show_website' => array(
			'name' => 'katb_widget_show_website',
			'title' => esc_html__( 'Show website in widget' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Check to include website','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_show_date' => array(
			'name' => 'katb_widget_show_date',
			'title' => esc_html__( 'Show date in widget' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Check to include date','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_show_location' => array(
			'name' => 'katb_widget_show_location',
			'title' => esc_html__( 'Show location in widget' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Check to include location','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_use_gravatars' => array(
			'name' => 'katb_widget_use_gravatars',
			'title' => esc_html__( 'Use gravatars' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Check to include','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_use_round_images' => array(
			'name' => 'katb_widget_use_round_images',
			'title' => esc_html__( 'Use round gravatars/images' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('All images will be round','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_use_gravatar_substitute' => array(
			'name' => 'katb_widget_use_gravatar_substitute',
			'title' => esc_html__( 'Use gravatar substitute' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Use substitute if Gravatar unavailable','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_gravatar_size' => array(
			'name' => 'katb_widget_gravatar_size',
			'title' => esc_html__('Gravatar size','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				'40',
				'50',
				'60',
				'70', 
				'80',
				'90',
				'100'
			),
			'description' => esc_html__('Select a size for the gravatar','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' => '60',
			'class' => 'select'
		),
		'katb_widget_use_italic_style' => array(
			'name' => 'katb_widget_use_italic_style',
			'title' => esc_html__( 'Use italic font style' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Check to include','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_rotator_speed' => array(
			'name' => 'katb_widget_rotator_speed',
			'title' => esc_html__('Widget time between slides','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				'4000',
				'5000',
				'6000',
				'7000',
				'8000',
				'9000',
				'10000',
				'11000',
				'12000',
				'13000',
				'14000'
			),
			'description' => esc_html__('default: 7000 ms, IE9,IE10 uses default','testimonial-basics'),
			'section' => 'widget_rotator',
			'tab' => 'widget_display',
			'default' => '7000',
			'class' => 'select'
		),
		'katb_widget_rotator_height' => array(
			'name' => 'katb_widget_rotator_height',
			'title' => esc_html__('Widget rotator height in pixels','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				'variable',
				'50',
				'75',
				'100',
				'125',
				'150',
				'175',
				'200',
				'225',
				'250',
				'275',
				'300',
				'325',
				'350'
			),
			'description' => esc_html__('default: variable','testimonial-basics'),
			'section' => 'widget_rotator',
			'tab' => 'widget_display',
			'default' => 'variable',
			'class' => 'select'
		),
		'katb_widget_rotator_transition' => array(
			'name' => 'katb_widget_rotator_transition',
			'title' => esc_html__('Widget rotator transition effect','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				'fade',
				'left to right',
				'right to left'
			),
			'description' => esc_html__('default: fade, IE9,IE10 uses default','testimonial-basics'),
			'section' => 'widget_rotator',
			'tab' => 'widget_display',
			'default' => 'fade',
			'class' => 'select'
		),
		'katb_widget_use_formatted_display' => array(
			'name' => 'katb_widget_use_formatted_display',
			'title' => esc_html__( 'Use formatted display' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => esc_html__('Check to include','testimonial-basics'),
			'section' => 'widget_custom_formats',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),		
		'katb_widget_background_color' => array(
			'name' => 'katb_widget_background_color',
			'title' => esc_html__('Background Color','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('default: #EDEDED','testimonial-basics'),
			'section' => 'widget_custom_formats',
			'tab' => 'widget_display',
			'default' => '#EDEDED',
			'class' => 'ka_color'
		),
		'katb_widget_divider_color' => array(
			'name' => 'katb_widget_divider_color',
			'title' => esc_html__('Divider Color','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('default: #CECECE','testimonial-basics'),
			'section' => 'widget_custom_formats',
			'tab' => 'widget_display',
			'default' => '#CECECE',
			'class' => 'ka_color'
		),
		'katb_widget_font_color' => array(
			'name' => 'katb_widget_font_color',
			'title' => esc_html__('Font Color','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('default: #000000','testimonial-basics'),
			'section' => 'widget_custom_formats',
			'tab' => 'widget_display',
			'default' => '#000000',
			'class' => 'ka_color'
		),
		'katb_widget_author_location_color' => array(
			'name' => 'katb_widget_author_location_color',
			'title' => esc_html__('Author,Location, and Date Color','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('default: #000000','testimonial-basics'),
			'section' => 'widget_custom_formats',
			'tab' => 'widget_display',
			'default' => '#000000',
			'class' => 'ka_color'
		),
		'katb_widget_website_link_color' => array(
			'name' => 'katb_widget_website_link_color',
			'title' => esc_html__('Website Link Color','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('default: #3384E8','testimonial-basics'),
			'section' => 'widget_custom_formats',
			'tab' => 'widget_display',
			'default' => '#3384E8',
			'class' => 'ka_color'
		),
		'katb_widget_website_link_hover_color' => array(
			'name' => 'katb_widget_website_link_hover_color',
			'title' => esc_html__('Website Link Hover Color','testimonial-basics'),
			'type' => 'text',
			'description' => esc_html__('default: #FFFFFF','testimonial-basics'),
			'section' => 'widget_custom_formats',
			'tab' => 'widget_display',
			'default' => '#FFFFFF',
			'class' => 'ka_color'
		),																																				
	);
		
    return apply_filters( 'katb_get_option_parameters', $options );
}

/** katb_testimonial_basics_display_in_code()
 * 
 * This function allows you to use display testimonials in code
 * 
 * It accepts arguments just like in the shortcode and displays accordingly
 *
 * @param string $group group used in database
 * @param string $number: all or a number
 * @param string $by: order or date or random
 * @param string $id: blank or id's of the testimonial separated by a comma
 * @param string $rotate: 'yes' or 'no' used to rotate testimonials
 * @param string $layout: '0','1','2','3','4','5', or '6'
 * @param string $schema: 'default','yes', or 'no'
 * 
 * @uses katb_list_testimonials ( $atts ) in katb_shortcodes.php
 * 
 */
 function katb_testimonial_basics_display_in_code( $group='all', $number='all', $by='random', $id='', $rotate='no', $layout="0", $schema="default" ){
	
	$group = sanitize_text_field( $group );
	$number = strtolower( sanitize_text_field( $number ));
	$by = strtolower( sanitize_text_field( $by ));
	$id = sanitize_text_field($id);
	$rotate = strtolower( sanitize_text_field( $rotate ));
	$layout = sanitize_text_field($layout);
	$schema = sanitize_text_field($schema);
	
	//whitelist rotate
	if( $rotate != 'yes' ) { $rotate = 'no'; }
	
	//white list group
	if( $group == '' || $group == 'All' ) { $group = 'all'; }
	
	//number validation/whitelist
	if( $number == '' || $number == 'All' ) { $number = 'all'; }
	if( $number != 'all' ) {
		if( intval( $number ) < 1 ) {
			$number = 1;
		} else {
			$number = intval( $number );
		}
	}
	
	//Validate $by
	if ( $by != 'date' && $by != 'order') { $by = 'random'; }
	
	//white list layout
	if( $layout == '0' || $layout == '1' || $layout == '2' || $layout == '3' || $layout == '4' || $layout == '5' || $layout == '6' ) {/*do nothing*/}else{ $layout = '0'; }
	
	//white list schema
	if( $schema == 'yes' || $schema == 'no' ){/*do nothing*/}else{$schema = 'default';}
	

	$atts = array(
		'group' => $group,
		'number' => $number,
		'by' => $by,
		'id' => $id,
		'rotate' => $rotate,
		'layout' => $layout,
		'schema' => $schema
	);
	
	echo katb_list_testimonials ( $atts );

}

/** katb_testimonial_basics_input_in_code()
 * 
 * This function allows you to set up the input testimonials form in code
 * 
 * It accepts arguments just like in the shortcode and displays accordingly
 *
 * @param string $group group used in database
 * 
 * @uses katb_display_input_form( $atts ) in katb_shortcodes.php
 * 
 */
 function katb_testimonial_basics_input_in_code( $group='All', $form='1' ){
	
	$group = sanitize_text_field( $group );
	$form = sanitize_text_field( $form );

	//white list group
	if( $group == '' || $group == 'All' || $group == 'all' ) { $group = 'all'; }
	//validate form
	if( $form == '' ){ $form = '1' ;}
	
	$atts = array(
		'group' => $group,
		'form' => $form
	);
	
	echo katb_display_input_form($atts);

}

/**
 * Supplies array of filter parameters for wp_kses($text,$allowed_html)
 * Only this html will be allowed in testimonials submitted by visitors
 * used in katb_check_for_submitted_testimonial()
 * and in katb_input_testimonial_widget.php function widget
 * 
 * @return	array	$allowed_html 
 */
function katb_allowed_html() {
	
	$allowed_html = array (
		'p' => array(),
    	'br' => array(),
		'i' => array(),
		'h1' => array(),
		'h2' => array(),
		'h3' => array(),
		'h4' => array(),
		'h5' => array(),
		'h6' => array(),
		'em' => array(),
		'strong' => array(),
		'q' => array(),
		'a' => array(
					'href' => array(),
					'title' => array(),
					'target' => array()
					),
		//'img' => array(),
	);
		
    return apply_filters( 'katb_allowed_html', $allowed_html );
}

/**
 * Test if Gravatar Exists
 * 
 * source : http://codex.wordpress.org/Using_Gravatars
 *
 * @return	boolean	$has_valid_avatar
 */
function katb_validate_gravatar($email) {
	// Craft a potential url and test its headers
	$hash = md5( strtolower( trim( $email ) ) );
	$uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
	$headers = @get_headers( $uri );
	if ( !preg_match( "|200|" , $headers[0] ) ) {
		$has_valid_avatar = FALSE;
	} else {
		$has_valid_avatar = TRUE;
	}
	return $has_valid_avatar;
}

/**
 * Gets the current page url for use in a redirect after the testimonial has been submitted
 * Taken from the WordPress.org Forum / search: current url
 * 
 * @return string $pageURL
 */ 
function katb_current_page_url() {
	$pageURL = 'http';
	if( isset($_SERVER["HTTPS"]) ) {
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	}
	$pageURL .= '://';
	
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	
	return $pageURL;
}

/**
 * Checks for submitted testimonial through $_POST, and proceeds with form validation and submission
 *
 * This function checks to see if the main input form has submitted a testimonial.
 * It uses the add_action('parse_request','katb_check_for_submitted_testimonial') hook.
 * I don't know why this hook works. I was looking for a different approach to the form 
 * submission and check within the same function as this method was causein duplicate 
 * submissions in some cases. So I took a look at the user-submitted-posts plugin and 
 * adopted their method whic separates the validation and data submission from the form re-load. 
 * I didn't really copy their method just adapted it to a shortcode form submission.
 * The parse_request action hook was used and the documentation in WordPress.org is not very good.
 * It simply says "This action hook is executed at the end of WordPress's built-in request parsing 
 * method in the main WP() class." Anyway it works. 
 * 
 * Once the $_POST is detected the program validates the data, updates the database and send an email for notification.
 * If the validation fails a session flag is set and an error message will be shown on the page after reload
 * 
 * @uses katb_get_options(); array of user options
 * @uses katb_allowed_html(); array of allowed html for validation
 * @uses katb_current_page_url(); gets cuurent page for redirect
 * 
 */
//check for submitted testimonial
function katb_check_for_submitted_testimonial() {
	global $wpdb,$tablename;
	global $katb_group,$katb_author,$katb_email,$katb_website,$katb_location,$katb_rating,$katb_testimonial,$katb_input_error,$katb_input_success;
	$tablename = $wpdb->prefix.'testimonial_basics';
	$katb_options = katb_get_options();
	$exclude_website = $katb_options[ 'katb_exclude_website_input' ];
	$require_website = $katb_options[ 'katb_require_website_input' ];
	$exclude_location = $katb_options[ 'katb_exclude_location_input' ];
	$require_location = $katb_options[ 'katb_require_location_input' ];
	$use_ratings = $katb_options[ 'katb_use_ratings' ];
	$auto_approve = $katb_options[ 'katb_auto_approve' ];
	$use_popup = $katb_options[ 'katb_use_popup_message' ];
	$katb_allowed_html = katb_allowed_html();
	
	if ( isset ( $_POST['katb_submitted'] ) && wp_verify_nonce( $_POST['katb_main_form_nonce'],'katb_nonce_1' ) ) {
	
		//Initialize error message
		$katb_input_error = '';

		//Initialize session variable used to check if testimonial was successfully submitted
		$_SESSION['katb_submitted'] = SHA1('false');
		
		//Set up Form Submnitted session variable for multi input forms
		$katb_form_submitted = sanitize_text_field($_POST['katb_form_no']);
		$_SESSION['katb_form_submitted'] = SHA1($katb_form_submitted);
		//Validate-Sanitize Input
		//Set Defaults
		$katb_order = "";
		
		if( $auto_approve == 1 ) {
			$katb_approved = 1;
		} else {
			$katb_approved = 0;
		}
		
		//$katb_group = "";
		$katb_group = sanitize_text_field($_POST['tb_group']);
		$katb_datetime = current_time('mysql');
		//Validate-Sanitize Author
		$katb_author = sanitize_text_field($_POST['tb_author']);
		$_POST['tb_author'] = '';
		if ($katb_author == '') {
			
			if( $use_popup == 1 ) {
				$katb_input_error .= '\n - '.esc_html__('Author is required','testimonial-basics');
			} else {
				$katb_input_error .= '<br/> - '.esc_html__('Author is required','testimonial-basics');
			}
			
		}
		//Validate-Sanitize E-mail
		$katb_email = sanitize_email($_POST['tb_email']);
		if(!is_email($katb_email)) {
			
			if( $use_popup == 1 ) {
				$katb_input_error .= '\n - '.esc_html__('Valid email is required','testimonial-basics');
			} else {
				$katb_input_error .= '<br/> - '.esc_html__('Valid email is required','testimonial-basics');
			}
			
		}
		//Validate-Sanitize Website
		if( $exclude_website != 1 ) {
			$katb_website = trim($_POST['tb_website']);
			if($katb_website != '') {
				$katb_website = esc_url($katb_website);
			} else {
				if( $require_website == 1 ) {
					if( $use_popup == 1 ) {
						$katb_input_error .= '\n - '.esc_html__('Website is required','testimonial-basics');
					} else {
						$katb_input_error .= '<br/> - '.esc_html__('Website is required','testimonial-basics');
					}
				}
			}
		} else {
			$katb_website = '';
		}
		
		//Validate Location
		if( $exclude_location != 1 ) {
			$katb_location = trim($_POST['tb_location']);
			if($katb_location != '') {
				$katb_location = sanitize_text_field($_POST['tb_location']);
			} else {
				if( $require_location == 1 ) {
					if( $use_popup == 1 ) {
						$katb_input_error .= '\n - '.esc_html__('Location is required','testimonial-basics');
					} else {
						$katb_input_error .= '<br/> - '.esc_html__('Location is required','testimonial-basics');
					}
				}
			}
		} else {
			$katb_location = '';
		}

		//validate rating
		if( $use_ratings == 1 ) {
			$katb_rating = sanitize_text_field($_POST['tb_rating']);
			if( $katb_rating == '0') $katb_rating = '0.0';
			if( $katb_rating == '1') $katb_rating = '1.0';
			if( $katb_rating == '2') $katb_rating = '2.0';
			if( $katb_rating == '3') $katb_rating = '3.0';
			if( $katb_rating == '4') $katb_rating = '4.0';
			if( $katb_rating == '5') $katb_rating = '5.0';
		}
		
			
		//Validate-Sanitize Testimonial
		$katb_testimonial = wp_kses($_POST['tb_testimonial'],$katb_allowed_html);
		if ( $katb_testimonial == "" ) {
			
			if( $use_popup == 1 ) {
				$katb_input_error .= '\n - '.esc_html__('Testimonial is required','testimonial-basics');
			} else {
				$katb_input_error .= '<br/> - '.esc_html__('Testimonial is required','testimonial-basics');
			}
			
		}
		//Captcha Check
		if ( $katb_options['katb_use_captcha'] == TRUE || $katb_options['katb_use_captcha'] == 1 ) {
			
			$katb_captcha_entered = sanitize_text_field( $_POST['verify'] );
		
			if ( $_SESSION['katb_pass_phrase'] !== sha1( $katb_captcha_entered ) ) {
				
				if( $use_popup == 1 ) {
					$katb_input_error .= '\n - '.esc_html__('Captcha is invalid - please try again','testimonial-basics');
				} else {
					$katb_input_error .= '<br/> - '.esc_html__('Captcha is invalid - please try again','testimonial-basics');
				}
				
			}
			
		}
		//Validation complete
		if($katb_input_error == "") {
			//OK $katb_input_error is empty so let's update the database
			$values = array(
				'tb_date' => $katb_datetime,
				'tb_order' => $katb_order,
				'tb_approved' => $katb_approved,
				'tb_group' => $katb_group,
				'tb_name' => $katb_author,
				'tb_email' => $katb_email,
				'tb_location' => $katb_location,
				'tb_url' => $katb_website,
				'tb_pic_url' => '',
				'tb_rating' => $katb_rating,
				'tb_testimonial' => $katb_testimonial
			);
			$formats_values = array('%s','%d','%d','%s','%s','%s','%s','%s','%s','%s','%s');
			$wpdb->insert($tablename,$values,$formats_values);
			
			//send email
			if ( isset( $katb_options['katb_contact_email'] ) && $katb_options['katb_contact_email'] != '' ) {
				$emailTo = $katb_options['katb_contact_email'];
			} else {
				$emailTo = get_option('admin_email');
			}
			$subject = esc_html__('You have received a testimonial!','testimonial-basics');
			$body = esc_html__('Name: ','testimonial-basics').' '.stripcslashes($katb_author)."<br/><br/>"
					.esc_html__('Email: ','testimonial-basics').' '
					.stripcslashes($katb_email)."<br/><br/>"
					.esc_html__('Comments: ','testimonial-basics')."<br/><br/>"
					.stripcslashes($katb_testimonial)."<br/><br/>"
					.esc_html__('Log in to approve or view it:','testimonial-basics').'<a href="'.site_url("/wp-login.php").'" title="your site login">Log In</a>';;
			$headers = 'From: '.stripcslashes($katb_author).' <'.stripcslashes($katb_email).'>';
			add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
			wp_mail( $emailTo, $subject, $body, $headers );
			//Now empty the variables
			$katb_id = "";
			$katb_order = "";
			$katb_approved = "";
			$katb_date = "";
			$katb_time = "";
			$katb_author = "";
			$katb_website = "";
			$katb_location = "";
			$katb_testimonial = "";
			$katb_email = "";
			$katb_rating = "0.0";
			//set testimonial submitted flag
			$_SESSION['katb_submitted'] = SHA1('true');
			//Redirect and load to reset post variables
			//$redirect = katb_current_page_url();
			//wp_redirect( $redirect );
			//exit;
		}
	} else {
		$katb_id = "";
		$katb_order = "";
		$katb_approved = "";
		$katb_date = "";
		$katb_time = "";
		$katb_author = "";
		$katb_website = "";
		$katb_location = "";
		$katb_testimonial = "";
		$katb_email = "";
		$katb_rating = "";
	}
	/* ---------- Reset button is clicked ---------------- */
	if( isset($_POST['katb_reset'] ) ) {
		$katb_author = "";
		$katb_email = "";
		$katb_website = "";
		$katb_location = "";
		$katb_testimonial = "";
		$katb_rating = "";
	}
}
add_action ('parse_request', 'katb_check_for_submitted_testimonial');

/** EXCERPT FILTER
 * @Author: Boutros AbiChedid
 * @Date:   June 20, 2011
 * @Websites: http://bacsoftwareconsulting.com/ ; http://blueoliveonline.com/
 * @Description: Preserves HTML formating to the automatically generated Excerpt.
 * Also Code modifies the default excerpt_length and excerpt_more filters.
 * http://bacsoftwareconsulting.com/blog/index.php/wordpress-cat/how-to-preserve-html-tags-in-wordpress-excerpt-without-a-plugin/
 * Modified by 
 * @Author: Kevin Archibald
 */
function katb_testimonial_excerpt_filter( $length , $text , $classID ) {
	
	//initiate some variables
	$more_requested = false;
	$number_of_words = 0;

	$katb_excerpt = strip_shortcodes( $text );

	//Set the excerpt word count and only break after sentence is complete.
	$excerpt_word_count = $length;
	$excerpt_length = apply_filters('excerpt_length', $excerpt_word_count); 
	$tokens = array();
	$excerptOutput = '';
	$count = 0;

	// Divide the string into tokens; HTML tags, or words, followed by any whitespace
	preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $katb_excerpt, $tokens);

	foreach ($tokens[0] as $token) { 

		if ($count >= $excerpt_word_count && preg_match('/[\,\;\?\.\!]\s*$/uS', $token) && $token != '' ) { 
			// Limit reached, continue until , ; ? . or !occur at the end
			$excerptOutput .= trim($token);
			$number_of_words = $count;
			break;
		}

		// Add words to complete sentence
		$count++;

		// Append what's left of the token
		$excerptOutput .= $token;
		
	}

    $katb_excerpt = trim(force_balance_tags($excerptOutput));
	
	$excerpt_end = '<a href="#" class="katb_excerpt_more" data-id="'.$classID.'" > ...'.__('more','testimonial-basics').'</a>';

	if( $number_of_words >= $excerpt_word_count || $more_requested == true ){
		// After the content
		$katb_excerpt .= $excerpt_end; /*Add read more in new paragraph */
	}

	return $katb_excerpt;   

}
 
/*=====================================================================================================
 *                           Page Navigation Functions
 * ==================================================================================================== */
 
/**
 * This function sets up the array $setup for use by the katb_display_pagination() function
 * @param $offset_name : string, name of session variable that stores the offset
 * @param $span : int, number of entries to display on each page.
 * @param $total_entries : string, total number of testimonials
 * 
 * @return $setup : array, contains the setup variables passed to  katb_display_pagination()
 */
function katb_setup_pagination( $offset_name, $span, $total_entries ){
	
	$paginate_setup = array();

	//prevent divide by 0
	if( $span == '' || $span == 0 ) { $span = 10; }
	
	//Check for offset and set to 0 if not there
	if ( isset( $_SESSION[$offset_name] ) ) {
		$offset = $_SESSION[$offset_name];
	} else {
		$offset = 0;
	}
	
	//Calculate display pages required given the span
	$pages_decimal = $total_entries/$span;
	$pages = ceil( $pages_decimal );
	
	//calculate the page selected based on the offset
	$page_selected = intval( $offset/$span + 1 );
	
	//Safety Checks
	if ( $page_selected > $pages ) {
		$offset = 0;
		$_SESSION[$offset_name] = $offset;
		$page_selected = 1;
	}
	if ( $page_selected < 1 ) $page_selected = 1;
			
	//Figure out the pages to list
	$max_page_buttons = 5;
	//Figure out $page_a
	$j = $max_page_buttons;
	while( $page_selected > $j ){ $j = $j + $max_page_buttons; }
	$page_a = $j - $max_page_buttons + 1;
	
	//Set up display configuration
	//only display the first button if there are a lot of downloads
	$pages > ($max_page_buttons * 2)? $first = 'yes' : $first = 'no';
	
	//only display the previous button if more than 1 set
	$pages > $max_page_buttons?	$previous = 'yes': $previous = 'no';
	
	//set up remaining page buttons
	( $page_a + 1 ) < ( $pages + 1 )? $page_b = $page_a + 1: $page_b = 'no';
	( $page_a + 2 ) < ( $pages + 1 )? $page_c = $page_a + 2: $page_c = 'no';
	( $page_a + 3 ) < ( $pages + 1 )? $page_d = $page_a + 3: $page_d = 'no';
	( $page_a + 4 ) < ( $pages + 1 )? $page_e = $page_a + 4: $page_e = 'no';
	
	//only display middle button for large number of downloads
	$pages > ( $max_page_buttons * 2 )? $middle = 'yes': $middle = 'no';
	
	//only display the next button if more than 1 set
	$pages > $max_page_buttons? $next = 'yes': $next = 'no';
	
	//only display the last button if there are a lot of downloads
	$pages > ( $max_page_buttons * 2 )? $last = 'yes': $last = 'no';
	
	$setup = array(
		'offset' => $offset,
		'pages' => $pages,
		'page_selected' => $page_selected,
		'first' => $first,
		'previous' => $previous,
		'page_a' => $page_a,
		'page_b' => $page_b,
		'page_c' => $page_c,
		'page_d' => $page_d,
		'page_e' => $page_e,
		'middle' => $middle,
		'next' => $next,
		'last' => $last
	);
	
	return $setup;
}

/**
 * This function displays the pagination buttons.
 * It is used by katb_testimonial_basics_edit_page() in katb_testimonial_basics_admin.php, 
 * to provide pagination in the Edit Testimonials panel
 * 
 * @param $setup array : supplied by katb_setup_pagination()
 * 
 */
function katb_display_pagination ( $setup ) {
	echo '<form class="katb-pagination" method="POST">';
	if ( $setup['pages'] > 1 ) {
		echo '<input type="button" class="ka_pages" value="Page '.$setup['page_selected'].' / '.$setup['pages'].'">';
		if ( $setup['first'] != 'no' ) echo '<input type="submit" name="ka_paginate_post" value="<<" title="First" class="ka_paginate" />';
			if ( $setup['previous'] != 'no') echo '<input type="submit" name="ka_paginate_post" value="<" title="Previous" class="ka_paginate" />';
			if ( $setup['page_a'] == $setup['page_selected'] ) {
				echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_a'].'" class="ka_paginate_selected"  />';
			} else {
				echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_a'].'" class="ka_paginate"  />';
			}
			if ( $setup['page_b'] == $setup['page_selected'] ) {
				if ( $setup['page_b'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_b'].'" class="ka_paginate_selected" />';
			} else {
				if ( $setup['page_b'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_b'].'" class="ka_paginate" />';
			}
			if ( $setup['page_c'] == $setup['page_selected'] ) {
				if ( $setup['page_c'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_c'].'" class="ka_paginate_selected" />';
			} else {
				if ( $setup['page_c'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_c'].'" class="ka_paginate" />';
			}
			if ( $setup['page_d'] == $setup['page_selected'] ) {
				if ( $setup['page_d'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_d'].'" class="ka_paginate_selected" />';
			} else {
				if ( $setup['page_d'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_d'].'" class="ka_paginate" />';
			}
			if ( $setup['page_e'] == $setup['page_selected'] ) {
				if ( $setup['page_e'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_e'].'" class="ka_paginate_selected" />';
			} else {
				if ( $setup['page_e'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_e'].'" class="ka_paginate" />';
			}
			if ( $setup['middle'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="^" title="Middle" class="ka_paginate" />';
			if ( $setup['next'] != 'no' ) echo '<input type="submit" name="ka_paginate_post" value=">" title="Next" class="ka_paginate" />';
			if ( $setup['last'] != 'no' ) echo '<input type="submit" name="ka_paginate_post" value=">>" title="Last" class="ka_paginate" />';
		}
	echo '</form>';
}

/**
 * This function sets up the displays the pagination buttons html in a string.
 * It is called by katb_list_testimonials() in katb_shortcodes.php
 * 
 * @param $setup array : supplied by katb_setup_pagination()
 * 
 * @return $html_return - the return string to display the pagination
 * 
 */
function katb_get_display_pagination_string ($setup) {
	
	$html_return = '';
	$html_return .= '<form method="POST" class="katb_paginate">';
	if ( $setup['pages'] > 1 ) {
		$html_return .= '<input type="button" class="ka_display_paginate_summary" value="Page '.$setup['page_selected'].' / '.$setup['pages'].'">';
		if ( $setup['first'] != 'no' ) $html_return .= '<input type="submit" name="ka_paginate_post" value="<<" title="First" class="ka_display_paginate" />';
			if ( $setup['previous'] != 'no') $html_return .=  '<input type="submit" name="ka_paginate_post" value="<" title="Previous" class="ka_display_paginate" />';
			if ( $setup['page_a'] == $setup['page_selected'] ) {
				$html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_a'].'" class="ka_display_paginate_selected"  />';
			} else {
				$html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_a'].'" class="ka_display_paginate"  />';
			}
			if ( $setup['page_b'] == $setup['page_selected'] ) {
				if ( $setup['page_b'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_b'].'" class="ka_display_paginate_selected" />';
			} else {
				if ( $setup['page_b'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_b'].'" class="ka_display_paginate" />';
			}
			if ( $setup['page_c'] == $setup['page_selected'] ) {
				if ( $setup['page_c'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_c'].'" class="ka_display_paginate_selected" />';
			} else {
				if ( $setup['page_c'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_c'].'" class="ka_display_paginate" />';
			}
			if ( $setup['page_d'] == $setup['page_selected'] ) {
				if ( $setup['page_d'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_d'].'" class="ka_display_paginate_selected" />';
			} else {
				if ( $setup['page_d'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_d'].'" class="ka_display_paginate" />';
			}
			if ( $setup['page_e'] == $setup['page_selected'] ) {
				if ( $setup['page_e'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_e'].'" class="ka_display_paginate_selected" />';
			} else {
				if ( $setup['page_e'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_e'].'" class="ka_display_paginate" />';
			}
			if ( $setup['middle'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="^" title="Middle" class="ka_display_paginate" />';
			if ( $setup['next'] != 'no' ) $html_return .=  '<input type="submit" name="ka_paginate_post" value=">" title="Next" class="ka_display_paginate" />';
			if ( $setup['last'] != 'no' ) $html_return .=  '<input type="submit" name="ka_paginate_post" value=">>" title="Last" class="ka_display_paginate" />';
		}
	$html_return .=  '</form>';
	return $html_return;
}

/**
 * This function sets up the offset depending which pagination button is clicked
 * Note : $offset is the last testimonial in the previous page and it is stored in
 * a session variable. It is the variable used to determine where the pagination is at.
 * 
 * @param $offset_name : string, name of session variable that stores the offset
 * @param $span : int, number of entries to display on each page.
 * @param $action : string, the value of the button that was clicked
 * @param $total_entries : string, total number of testimonials
 * 
 */
function katb_offset_setup ( $offset_name, $span, $action, $total_entries ) {
	
	//Start by getting offset
	if ( isset( $_SESSION[$offset_name] ) ) {
		$offset = $_SESSION[$offset_name];
	} else {
		$offset = 0;
	}
	
	//prevent divide by 0
	if( $span == '' || $span == 0 ) { $span = 10; }
	
	//Calculate total pages
	$pages_decimal = $total_entries/$span;
	$pages = ceil( $pages_decimal );
	$page_selected = ( $offset/$span + 1 );
	
	//Safety Checks
	if ( $page_selected > $pages ) {
		$offset = 0;
		$_SESSION[$offset_name] = $offset;
		$page_selected = 1;
	}
	if ( $page_selected < 1 ) { $page_selected = 1; }
	
	$max_page_buttons = 5;
	
	//Figure out $page_a
	$j = 5;
	while( $page_selected > $j ){ $j = $j + $max_page_buttons; }
	$page_a = $j - $max_page_buttons + 1;
	
	//Now that we know where we are at, figure out where we are going :)
	if ( $action == '<<' ) {
		$_SESSION[$offset_name] = 0;
	} elseif ( $action == '<' ) {
		if ( $page_a - $max_page_buttons < 1 ) {
			$_SESSION[$offset_name] = 0;
		} else {
			$offset = ( $page_a - $max_page_buttons - 1 ) * $span;
			$_SESSION[$offset_name] = $offset;
		}
	} elseif ( $action == '^' ) {
		$offset = (floor($pages/2) - 1) * $span;
		$_SESSION[$offset_name] = $offset;
	} elseif ( $action == '>' ) {
		if ( $page_a + $max_page_buttons <= $pages ) {
			$offset = ( $page_a + $max_page_buttons - 1 ) * $span;
			$_SESSION[$offset_name] = $offset;
		}
	} elseif ( $action == '>>' ) {
		$offset = ($pages - 1) * $span;
		$_SESSION[$offset_name] = $offset;
	} else {
		$page_no = intval($action);
		$offset = ( $page_no - 1 ) * $span;
		$_SESSION[$offset_name] = $offset;
	}
	
}

/**
 * Function to add unapproved testimonials count to admin menu
 * Reference: http://wordpress.org/support/topic/add-bubble-for-pending-count-in-admin-dashboard?replies=1
 */
add_action( 'admin_menu', 'katb_add_unapproved_count' );
function katb_add_unapproved_count() {
 	//setup database table
	global $wpdb , $tablename, $menu;
	$tablename = $wpdb->prefix.'testimonial_basics';
	
	$results = $wpdb->get_results( " SELECT COUNT(1) FROM `$tablename` WHERE `tb_approved` = '0' ",ARRAY_A);
	$total = $results[0]['COUNT(1)'];
	
	if( $total != 0 ) {
		foreach ( $menu as $key => $value ) {
			if ( $menu[$key][2] == 'katb_testimonial_basics_admin' ) {
				$menu[$key][0] .= " <span class='update-plugins count-$total'><span class='plugin-count'>" . $total . '</span></span>';
				return;
			}
		}
	}
}

/**
 * This function provides the html for the css rating system
 * 
 * @param $rating is the rating
 * 
 * @return $rating html string 
 */
function katb_css_rating( $rating ){
	$css_rating = '';
	
	switch ( $rating ) {
		
		case 0.0:
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			break;
			
		case 0.5:
			$css_rating .= '<i class="icon-katb-star-half-alt"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			break;
			
		case 1.0:
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			break;
			
		case 1.5:
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star-half-alt"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			break;
			
		case 2.0:
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			break;
			
		case 2.5:
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star-half-alt"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			break;
			
		case 3.0:
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			break;
			
		case 3.5:
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star-half-alt"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			break;
			
		case 4.0:
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			break;
			
		case 4.5:
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star-half-alt"></i>';
			break;
			
		case 5.0:
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			break;
	}
	
	return $css_rating;
	
}
/**
 * This function provides the html for the css rating system
 * 
 * @param $rating is the rating
 * 
 * @return $rating html string 
 */
function katb_hex_to_rgba( $hex ){
	
	 $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

/**
 * This function provides the html for the color option 2
 * 
 */
function katb_color_captcha_2(){
	
	$katb_code_key = array (
		'sIcv1CnLJ6k6',
		'63m1IUWRUjjn',
		'lajBgRjQblvW',
		'Ri0DDNEVbWDX',
		'xSoOfznHgmJp',
		'67WoNF2iAZHR',
		'XxgBqRl4fqXz',
		'YseePGIyWDiG',
		'rWviQrABe1Dj',
		'lnuVuHfVdjal',
		'dZORncMtSOAk',
		'Mg6Ey0TYNFAd',
		'7kLYp8Fp8PnZ',
		'PZfYWIoauaTL',
		'BBDS9jzpsbKG',
		'6UE09Ek8wVYf',
		'Gv4xHuDWPRfs',
		'w3H5BSWnLKpq',
		'KYfeiGkWJowT',
		'Hyt367nHpaL6',
		'4WDPNRqZdJS3',
		'zFi53Wz1l65c',
		'ENM15Ul1bpUh',
		'EQrxJi6CR8zF',
		'cBlPfQ5FaODL',
		'xPxckkMz2uQz',
	);
	$katb_captcha_key = array (
		'sIcv1CnLJ6k6'=>'a',
		'63m1IUWRUjjn'=>'b',
		'lajBgRjQblvW'=>'c',
		'Ri0DDNEVbWDX'=>'d',
		'xSoOfznHgmJp'=>'e',
		'67WoNF2iAZHR'=>'f',
		'XxgBqRl4fqXz'=>'g',
		'YseePGIyWDiG'=>'h',
		'rWviQrABe1Dj'=>'i',
		'lnuVuHfVdjal'=>'j',
		'dZORncMtSOAk'=>'k',
		'Mg6Ey0TYNFAd'=>'l',
		'7kLYp8Fp8PnZ'=>'m',
		'PZfYWIoauaTL'=>'n',
		'BBDS9jzpsbKG'=>'o',
		'6UE09Ek8wVYf'=>'p',
		'Gv4xHuDWPRfs'=>'q',
		'w3H5BSWnLKpq'=>'r',
		'KYfeiGkWJowT'=>'s',
		'Hyt367nHpaL6'=>'t',
		'4WDPNRqZdJS3'=>'u',
		'zFi53Wz1l65c'=>'v',
		'ENM15Ul1bpUh'=>'w',
		'EQrxJi6CR8zF'=>'x',
		'cBlPfQ5FaODL'=>'y',
		'xPxckkMz2uQz'=>'z',
	);
	
	$pass_phrase = '';
	$return_html = '';
	shuffle( $katb_code_key );
	for( $i=0; $i < 5; $i++ ){
		$pass_phrase .= $katb_captcha_key[$katb_code_key[$i]];
		$return_html .= '<img class="single-letter" src="'.plugin_dir_url(__FILE__).'captcha_images/'.$katb_code_key[$i].'.png" alt="captcha" />';
	}
	
	// Store the encrypted pass-phrase in a session variable
	$_SESSION['katb_pass_phrase'] = SHA1( $pass_phrase );
	return $return_html;

}

/**
 * add  custom styles
*/
/**
 * Enqueues front-end CSS for themeslug Theme
 * modified from Twenty Fifteen 1.0
 * @see wp_add_inline_style() to use this function to append the 
 * custom styles to style.css
 * 
 * bring your options into this function to set up your conditional css
 * 
 */
function katb_custom_css() {
	
	$katb_options = katb_get_options();
	 
	$katb_css = '';
	$katb_css .= '/* ==== Testimonial Basics Custom Styles  ==== */';
	//Content Custom Styles
	if ( $katb_options['katb_use_italic_style'] == 1 ) {
		$katb_css .= '.katb_test_text,.katb_test_text_basic {font-style: italic;}';
	}
	$katb_css .= '.katb_test_box,.katb_test_box_basic,';
	$katb_css .= '.katb_test_box_side_meta,.katb_test_box_basic_side_meta,';
	$katb_css .= '.katb_test_box_side_meta,.katb_test_box_basic_side_meta,';
	$katb_css .= '.katb_schema_summary_box_basic,.katb_schema_summary_box_basic_side_meta,';
	$katb_css .= '.katb_schema_summary_box,.katb_schema_summary_box_side_meta,';
	$katb_css .= '.katb_paginate';
	$katb_css .= '{ font-size: '.esc_html( $katb_options['katb_content_font_size'] ).'; }';
	
	if ($katb_options['katb_content_font'] != 'default font') {
		$katb_css .= '.katb_test_wrap *,.katb_test_wrap_basic *,';
		$katb_css .= '.katb_test_wrap_side_meta *,.katb_test_wrap_basic_side_meta *,';
		$katb_css .= '.katb_popup_wrap.katb_content *,.katb_paginate *,';
		$katb_css .= '.katb_schema_summary_wrap *,.katb_schema_summary_wrap *';
		$katb_css .= '{ font-family: '.sanitize_text_field( $katb_options['katb_content_font'] ).';}';
	} else {
		$katb_css .= '.katb_test_wrap *,.katb_test_wrap_basic *,';
		$katb_css .= '.katb_test_wrap_side_meta *,.katb_test_wrap_basic_side_meta *,';
		$katb_css .= '.katb_popup_wrap.katb_content *,';
		$katb_css .= '.katb_schema_summary_wrap *,.katb_paginate *';
		$katb_css .= '{ font-family: inherit; }';
	}
	
	$katb_css .= '.katb_test_wrap,.katb_schema_summary_wrap,';
	$katb_css .= '.katb_test_wrap_side_meta .katb_left_box,';
	$katb_css .= '.katb_schema_summary_box_side_meta .katb_schema_company_wrap_side_meta';
	$katb_css .= '{ background-color: '.esc_html( $katb_options['katb_background_wrap_color'] ).';';
	$katb_css .= 'color: '.esc_html( $katb_options['katb_testimonial_box_font_color'] ).';}';
	
	$katb_css .= '.katb_test_box,.katb_schema_summary_box,';
	$katb_css .= '.katb_test_wrap_side_meta .katb_right_box,';
	$katb_css .= '.katb_schema_summary_box_side_meta .katb_aggregate_wrap_side_meta,';
	$katb_css .= '.katb_test_text *';
	$katb_css .= '{background-color: '.esc_html( $katb_options['katb_testimonial_box_color'] ).';';
	$katb_css .= 'color: '.esc_html( $katb_options['katb_testimonial_box_font_color'] ).'!important; }';
	
	$katb_css .= '.katb_test_text h1,.katb_test_text h2,';	
	$katb_css .= '.katb_test_text h3,.katb_test_text h4,.katb_test_text h5,.katb_test_text h6 {';
	$katb_css .= 'color: '.esc_html( $katb_options['katb_testimonial_box_font_color'] ).'!important; }';
	
	$katb_css .= '/*author,location, and date custom colors */';
	$katb_css .= '.katb_test_box .katb_author,.katb_test_box_side_meta .katb_author,';
	$katb_css .= '.katb_test_box .katb_date,.katb_test_box_side_meta .katb_date,';
	$katb_css .= '.katb_test_box .katb_location,.katb_test_box_side_meta .katb_location';
	$katb_css .= '{color: '.esc_html( $katb_options['katb_author_location_color'] ).'!important; }';	
	
	$katb_css .= '.katb_test_box a,.katb_schema_summary_box a,.katb_test_box_side_meta a,';
	$katb_css .= '.katb_schema_summary_box_side_meta a';
	$katb_css .= '{color: '.esc_html( $katb_options['katb_website_link_color'] ).'!important;}';
	
	$katb_css .= '.katb_test_box a:hover,.katb_schema_summary_box a:hover ,.katb_test_box_side_meta a:hover,';
	$katb_css .= '.katb_schema_summary_box_side_meta a:hover';
	$katb_css .= '{color: '.esc_html( $katb_options['katb_website_link_hover_color'] ).'!important; }';

	$katb_css .= '.katb_paginate input {';
	$katb_css .= 'background-color: '.esc_html( $katb_options['katb_testimonial_box_color'] ).'!important;';
	$katb_css .= 'color: '.esc_html( $katb_options['katb_testimonial_box_font_color'] ).'!important;';
	$katb_css .= 'font-size: '.esc_html( $katb_options['katb_content_font_size'] ).'!important; }';
	
	$katb_css .= '.katb_input_style ';
	$katb_css .= '{font-size: '.esc_html( $katb_options['katb_content_input_font_size'] ).'!important; }';
	
	// Widget Display Custom Styles

	if ( $katb_options['katb_widget_use_italic_style'] == 1 ) {
		$katb_css .= '.katb_widget_text,.katb_widget_text_basic {font-style: italic;}';
	}
		
	$katb_css .= '.katb_widget_box,.katb_widget_box_basic,';
	$katb_css .= '.katb_widget_rotator_box,.katb_widget_rotator_box_basic';
	$katb_css .= '{ font-size: '.esc_html( $katb_options['katb_widget_font_size'] ).' }';
	
	if ( $katb_options['katb_widget_font'] != 'default font' ) {
		$katb_css .= '.katb_widget_wrap *,.katb_widget_wrap_basic *,';
		$katb_css .= '.katb_widget_rotator_wrap *,.katb_widget_rotator_wrap_basic *,';
		$katb_css .= '.katb_popup_wrap.katb_widget *';
		$katb_css .= '{ font-family: '.sanitize_text_field( $katb_options['katb_widget_font'] ).'; }';
	} else {
		$katb_css .= '.katb_widget_wrap *,.katb_widget_wrap_basic *,';
		$katb_css .= '.katb_widget_rotator_wrap *,.katb_widget_rotator_wrap_basic *,';
		$katb_css .= '.katb_popup_wrap.katb_widget *';
		$katb_css .= '{ font-family: inherit; }';
	}
	
	$katb_css .= '.katb_widget_rotator_wrap,.katb_widget_box {';
	$katb_css .= 'background-color: '.esc_html( $katb_options['katb_widget_background_color'] ).'; }';
		
	$katb_css .= '.katb_widget_rotator_wrap .katb_widget_title_bar,';
	$katb_css .= '.katb_widget_wrap .katb_widget_title_bar,';
	$katb_css .= '.katb_widget_text * ';
	$katb_css .= '{	color: '.esc_html( $katb_options['katb_widget_font_color'] ).'!important;}';
		
	$katb_css .= '.katb_widget_box .katb_widget_meta_bottom,.katb_widget_box .katb_widget_meta_top,';
	$katb_css .= '.katb_widget_box .katb_widget_meta_above_or_below,.katb_widget_rotator_box .katb_widget_meta_bottom,';
	$katb_css .= '.katb_widget_rotator_box .katb_widget_meta_top,.katb_widget_rotator_box .katb_widget_meta_above_or_below ';
	$katb_css .= '{color: '.esc_html( $katb_options['katb_widget_author_location_color'] ).';}';
	
	$katb_css .= '.katb_widget_box a,.katb_widget_rotator_box a ';
	$katb_css .= '{color: '.esc_html( $katb_options['katb_widget_website_link_color'] ).'!important;}';
	
	$katb_css .= '.katb_widget_box a:hover,.katb_widget_rotator_box a:hover ';
	$katb_css .= '{color: '.esc_html( $katb_options['katb_widget_website_link_hover_color'] ).'!important;}';
	
	$katb_css .= '.katb_widget_box .katb_image_meta_bottom,';
	$katb_css .= '.katb_widget_rotator_box .katb_image_meta_bottom,';
	$katb_css .= '.katb_widget_box .katb_centered_image_meta_bottom,';
	$katb_css .= '.katb_widget_rotator_box .katb_centered_image_meta_bottom';
	$katb_css .= '{ border-top: 1px solid '.esc_html( $katb_options['katb_widget_divider_color'] ).'; }';
	
	$katb_css .= '.katb_widget_box .katb_image_meta_top,';
	$katb_css .= '.katb_widget_rotator_box .katb_image_meta_top,';
	$katb_css .= '.katb_widget_box .katb_centered_image_meta_top,';
	$katb_css .= '.katb_widget_rotator_box .katb_centered_image_meta_top';
	$katb_css .= '{border-bottom: 1px solid '.esc_html( $katb_options['katb_widget_divider_color'] ).'; }';
	
	//* Widget Input Form

	$katb_css .= '.katb_widget_form {';
	$katb_css .= 'font-size: '.esc_html( $katb_options['katb_widget_input_font_size'] ).'!important; }';
	
	//Other Custom Styles
	if( $katb_options['katb_use_css_ratings'] == 1 ){
		$shadow_color = katb_hex_to_rgba( esc_html( $katb_options[ 'katb_star_shadow_color'] ) );
			
		$katb_css .= '.katb_css_rating i { ';
		$katb_css .= 'color: '.esc_html( $katb_options['katb_star_color'] ).'!important;';
		$katb_css .= 'text-shadow: 2px 2px 2px rgba( '.$shadow_color[0].','.$shadow_color[1].','.$shadow_color[2].',0.5 )!important;}';
	}
		
	$katb_css .= wp_filter_nohtml_kses( $katb_options['katb_custom_css'] );
		
	return $katb_css;
}
