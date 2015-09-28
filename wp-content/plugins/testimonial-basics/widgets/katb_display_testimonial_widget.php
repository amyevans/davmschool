<?php
/**
Plugin Name: Testimonial Basics Display Widget
Plugin URI: http://kevinsspace.ca/testimonial-basics-wordpress-plugin/
Description: A plugin to display testimonials in a widget
Version: 4.2.1
Author: Kevin Archibald
Author URI: http://kevinsspace.ca/
License: GPLv3
 * @package		Testimonial Basics WordPress Plugin
 * @copyright	Copyright (c) 2015, Kevin Archibald
 * @license		http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author		Kevin Archibald <www.kevinsspace.ca/contact/>
 * Testimonial Basics is distributed under the terms of the GNU GPL
 */
 
 // use widgets_init action hook to execute custom function
 add_action ( 'widgets_init','katb_display_register_widget' );

//register our widget 
 function katb_display_register_widget() {
 	register_widget ( 'katb_display_testimonial_widget' );
 }
 
 //widget class
class katb_display_testimonial_widget extends WP_Widget {

    //process the new widget
    public function __construct() {
        $widget_ops = array( 
			'classname' => 'katb_display_widget_class', 
			'description' => esc_html__('Display Testimonials.','testimonial-basics') 
			); 
        parent::__construct( 'katb_display_testimonial_widget', esc_html__('Testimonial Display Widget','testimonial-basics'), $widget_ops );
    }
 	
 	// Form for widget setup
 	public function form ( $instance ) {
 		$katb_display_defaults = array(
			'katb_display_widget_title' => 'Testimonials',
			'katb_display_widget_group' => 'all',
			'katb_display_widget_number' => 'all',
			'katb_display_widget_by' => 'date',
			'katb_display_widget_ids' => '',
			'katb_display_widget_rotate' => 'no',
			'katb_display_widget_layout_override' => '',
			'katb_display_widget_schema_override' => 'default'
		);
		$instance = wp_parse_args( (array) $instance, $katb_display_defaults );
		$title = $instance['katb_display_widget_title'];
		$group = $instance['katb_display_widget_group'];
		$number = $instance['katb_display_widget_number'];
		$by = $instance['katb_display_widget_by'];
		$ids = $instance['katb_display_widget_ids'];
		$rotate = $instance['katb_display_widget_rotate'];
		$layout_override = $instance['katb_display_widget_layout_override'];
		$use_schema_override = $instance['katb_display_widget_schema_override'];
		?>
		
		<p><?php _e('Title : ','testimonial-basics'); ?><input class="widefat" id="<?php echo $this->get_field_id('katb_display_widget_title'); ?>" name="<?php echo $this->get_field_name('katb_display_widget_title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<p><?php _e('Group : ','testimonial-basics'); ?><input class="widefat" id="<?php echo $this->get_field_id('katb_display_widget_group'); ?>" name="<?php echo $this->get_field_name('katb_display_widget_group'); ?>" type="text" value="<?php echo $group; ?>" /></p>
		<p><?php _e('Number : ','testimonial-basics'); ?><input class="widefat" id="<?php echo $this->get_field_id('katb_display_widget_number'); ?>" name="<?php echo $this->get_field_name('katb_display_widget_number'); ?>" type="text" value="<?php echo $number; ?>" /></p>
		<p><?php _e('By : ','testimonial-basics'); ?>
			<select name="<?php echo $this->get_field_name('katb_display_widget_by'); ?>">
				<option value="date" <?php selected( $by, "date" ); ?>>date</option>
				<option value="order" <?php selected( $by, "order" ); ?>>order</option>
				<option value="random" <?php selected( $by, "random" ); ?>>random</option>
			</select> 
		</p>
		<p><?php _e('IDs : ','testimonial-basics'); ?><input class="widefat" id="<?php echo $this->get_field_id('katb_display_widget_ids'); ?>" name="<?php echo $this->get_field_name('katb_display_widget_ids'); ?>" type="text" value="<?php echo $ids; ?>" /></p>
		<p><?php _e('Rotate : ','testimonial-basics'); ?>
			<select name="<?php echo $this->get_field_name('katb_display_widget_rotate'); ?>">
				<option value="no" <?php selected( $rotate, "no" ); ?>>no</option>
				<option value="yes" <?php selected( $rotate, "yes" ); ?>>yes</option>
			</select> 
		</p>
		<p><?php _e('Layout : ','testimonial-basics'); ?><br/>
			<select style="font-size:12px;" name="<?php echo $this->get_field_name('katb_display_widget_layout_override'); ?>">
				<option value="0" <?php selected( $layout_override, "0" ); ?>>default</option>
				<option value="1" <?php selected( $layout_override, "1" ); ?>>no format-meta top</option>
				<option value="2" <?php selected( $layout_override, "2" ); ?>>no format-meta bottom</option>
				<option value="3" <?php selected( $layout_override, "3" ); ?>>no format-image meta top</option>
				<option value="4" <?php selected( $layout_override, "4" ); ?>>no format-image meta bottom</option>
				<option value="5" <?php selected( $layout_override, "5" ); ?>>no format-centered image meta top</option>
				<option value="6" <?php selected( $layout_override, "6" ); ?>>no format-centered image meta bottom</option>
				<option value="7" <?php selected( $layout_override, "7" ); ?>>format-meta top</option>
				<option value="8" <?php selected( $layout_override, "8" ); ?>>format-meta bottom</option>
				<option value="9" <?php selected( $layout_override, "9" ); ?>>format-image meta top</option>
				<option value="10" <?php selected( $layout_override, "10" ); ?>>format-image meta bottom</option>
				<option value="11" <?php selected( $layout_override, "11" ); ?>>format-centered image meta top</option>
				<option value="12" <?php selected( $layout_override, "12" ); ?>>format-centered image meta bottom</option>
			</select> 
		</p>
		<p><?php _e('Use Schema : ','testimonial-basics'); ?>
			<select name="<?php echo $this->get_field_name('katb_display_widget_schema_override'); ?>">
				<option value="default" <?php selected( $use_schema_override, "yes" ); ?>>use default</option>
				<option value="no" <?php selected( $use_schema_override, "no" ); ?>>no</option>
				<option value="yes" <?php selected( $use_schema_override, "yes" ); ?>>yes</option>
			</select> 
		</p>
		<?php	
	}
	
	//save the widget settings
	public function update ( $new_instance, $old_instance ) {
		$instance = $old_instance;
        $instance['katb_display_widget_title'] = sanitize_text_field( $new_instance['katb_display_widget_title'] );
		$instance['katb_display_widget_group'] = sanitize_text_field( $new_instance['katb_display_widget_group'] );
		$instance['katb_display_widget_number'] = sanitize_text_field( $new_instance['katb_display_widget_number'] );
		$instance['katb_display_widget_by'] = strtolower(sanitize_text_field( $new_instance['katb_display_widget_by'] ));
		$instance['katb_display_widget_ids'] = sanitize_text_field( $new_instance['katb_display_widget_ids'] );
		$instance['katb_display_widget_rotate'] = strtolower(sanitize_text_field( $new_instance['katb_display_widget_rotate'] ));
		$instance['katb_display_widget_layout_override'] = sanitize_text_field( $new_instance['katb_display_widget_layout_override'] );
		$instance['katb_display_widget_schema_override'] = sanitize_text_field( $new_instance['katb_display_widget_schema_override'] );
		
		//rotate flag whitelist
		if( $instance['katb_display_widget_rotate'] != 'yes' ) $instance['katb_display_widget_rotate'] = 'no';
		
		// group validation/whitelist
		if( $instance['katb_display_widget_group'] == '' ) $instance['katb_display_widget_group'] = 'all';
		
		//number validation/whitelist
		if( $instance['katb_display_widget_number'] == '' ) $instance['katb_display_widget_number'] = 'all';
		if( $instance['katb_display_widget_number'] != 'all' ) {
			if( intval($instance['katb_display_widget_number']) < 1 ) {
				$instance['katb_display_widget_number'] = 1;
			} else {
				$instance['katb_display_widget_number'] = intval($instance['katb_display_widget_number']);
			}
		}
		
		//by whitelist
		if( $instance['katb_display_widget_by'] != 'date' && $instance['katb_display_widget_by'] != 'order') $instance['katb_display_widget_by'] = 'random';
		
		//layout option 1-12
		if( $instance['katb_display_widget_layout_override'] == '0' ) {
			//do nothing
		} elseif( intval($instance['katb_display_widget_layout_override'] ) < 1 ) {
			$instance['katb_display_widget_layout_override'] = '0';
		} elseif( intval($instance['katb_display_widget_layout_override'] ) > 12 ) {
			$instance['katb_display_widget_layout_override'] = '0';
		} else {
			$instance['katb_display_widget_layout_override'] = sanitize_text_field($instance['katb_display_widget_layout_override']);
		}
		
		//schema override
		if( $instance['katb_display_widget_schema_override'] == 'yes' ) {
			//do nothing
		} elseif( $instance['katb_display_widget_schema_override'] == 'no' ) {
			//do nothing
		} else {
			$instance['katb_display_widget_schema_override'] = 'default';
		}
		
		return $instance;
	}
	
	/**
	 * display the widget
	 * 
	 * 
	 * @param array $args
	 * @param $instance
	 * 
	 * @uses katb_get_options() user options from katb_functions.php
	 * @uses katb_widget_get_testimonials() from this file
	 * @uses katb_widget_schema_company_aggregate() from this file
	 * @uses katb_widget_display_testimonial () from this file
	 * 
	 */
    public function widget($args, $instance) {
    	
    	//get user options
    	global $katb_options;
    	$katb_options = katb_get_options();
		$company_name = sanitize_text_field( $katb_options['katb_schema_company_name'] );
		$company_website = esc_url( $katb_options['katb_schema_company_url'] );
		$use_aggregate_group_name = intval( $katb_options['katb_use_group_name_for_aggregate'] );
		$custom_aggregate_name = sanitize_text_field( $katb_options['katb_custom_aggregate_review_name'] );
		$use_schema = intval( $katb_options['katb_use_schema'] );
		
		$katb_tdata_array = array();
    	extract ( $args);
		echo $before_widget;
		
		$title = apply_filters( 'widget_title', $instance['katb_display_widget_title'] );
		$group = sanitize_text_field($instance['katb_display_widget_group']);
		$number = sanitize_text_field($instance['katb_display_widget_number']);
		$by = sanitize_text_field($instance['katb_display_widget_by']);
		$rotate = sanitize_text_field($instance['katb_display_widget_rotate']);
		$ids = sanitize_text_field($instance['katb_display_widget_ids']);
		$layout_override = sanitize_text_field( $instance['katb_display_widget_layout_override'] );
		$schema_override = sanitize_text_field( $instance['katb_display_widget_schema_override'] );
		
		if( $rotate == 'yes' ) { $rotate = 1; }
		
		//schema override - change if yes or no do nothing if default
		if( $schema_override == 'yes' ){
			$use_schema = 1;
		}elseif ( $schema_override == 'no' ) {
			$use_schema = 0;
		}
		
		//display the title
		if ( !empty( $title ) ) { echo $before_title.$title.$after_title; }
		
		//get the testimonials
		$katb_tdata_array = katb_widget_get_testimonials( $group, $number, $by, $ids );
		
		$katb_widget_tdata = $katb_tdata_array[0];
		
		$katb_widget_tnumber = $katb_tdata_array[1];

		$katb_widget_error = "";
				
		if ( $katb_widget_tnumber < 2 && $rotate == 1 ) {
			$katb_widget_error = esc_html__('You must have 2 approved testimonials to use a rotated display!','testimonial-basics');
		} elseif ( $katb_widget_tnumber == 0 ) {
			$katb_widget_error = esc_html__('There are no approved testimonials to display!','testimonial-basics');
		}

		// Database queried
		//Lets display the selected testimonial(s)

		if( $katb_widget_error != '') { ?>
			
			<div class="katb_display_widget_error"><?php echo esc_attr( $katb_widget_error ); ?></div>
			
		<?php } else {
			
			if( $use_schema == 1 ) {
				katb_widget_schema_company_aggregate( $company_name, $company_website, $group, $use_aggregate_group_name, $custom_aggregate_name  ); 
			}
			
			katb_widget_display_testimonial ( $use_schema, $katb_widget_tdata, $katb_widget_tnumber, $rotate, $group, $layout_override );
			
			if( $use_schema == 1 ) { ?>
				</div>
			<?php }
			 
		} ?>
		
		<br style="clear:both;" />
		
		<?php echo $after_widget; 

	}

}//close the class

/**
 * Go into the database and get the testimonials to display in the widget
 * 
 * @param string $group All or group name for search
 * @param string $number All or number to search
 * @param string $by date, order, random
 * @param string $ids contains ids of testimonials
 * 
 * @return $katb_tdata_array of testimonial data
 * 
 */
function katb_widget_get_testimonials( $group , $number , $by , $ids ) {
	
	global $wpdb,$tablename;
	$tablename = $wpdb->prefix.'testimonial_basics';
	$katb_tdata_array = array();
	
	if( $ids != '' ) {
		
		$id_picks_widget = array();
		$id_picks_processed = array();
		$id_picks = explode( ',', $ids );
		$counter = 0;
		foreach( $id_picks as $pick ) {
			$id_picks_processed[$counter] = intval( $id_picks[$counter] );
			if( $id_picks_processed[$counter] < 1 ) $id_picks_processed[$counter] = 1;
			$counter++;
		}
		
		$count = 0;
		$count2 = 0;
		foreach( $id_picks_processed as $pick ) {
			$pick_id = $id_picks_processed[$count];
			$tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_id` = '$pick_id' ",ARRAY_A);
			$tnumber = $wpdb->num_rows;
			if( $tnumber == 1 ) {
				$katb_tdata[ $count2 ] = $tdata[0];
				$count2++;
			}
			$count++;					
		}
		
		$katb_tdata_array[0] = $katb_tdata;
		$katb_tdata_array[1] = $count2;
		return $katb_tdata_array;
		
	} else {
		//get the testimonials from the database
		if ( $group == 'all' && $number == 'all' && $by == 'date' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_date` DESC ",ARRAY_A);
		} elseif ( $group == 'all' && $number == 'all' && $by == 'order' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_order` = '0',`tb_order` ASC ",ARRAY_A);
		} elseif ( $group == 'all' && $number == 'all' && $by == 'random' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY RAND() DESC ",ARRAY_A);
		} elseif ( $group == 'all' && $number != 'all' && $by == 'date' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_date` DESC LIMIT 0,$number ",ARRAY_A);
		} elseif ( $group == 'all' && $number != 'all' && $by == 'order' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_order` = '0',`tb_order` ASC LIMIT 0,$number ",ARRAY_A);
		} elseif ( $group == 'all' && $number != 'all' && $by == 'random' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY RAND() DESC LIMIT 0,$number ",ARRAY_A);
		} elseif ( $group != 'all' && $number == 'all' && $by == 'date' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_date` DESC ",ARRAY_A);
		} elseif ( $group != 'all' && $number == 'all' && $by == 'order' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_order` = '0',`tb_order` ASC ",ARRAY_A);	
		} elseif ( $group != 'all' && $number == 'all' && $by == 'random' ) {	
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY RAND() ",ARRAY_A);
		} elseif ( $group != 'all' && $number != 'all' && $by == 'date' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_date` DESC LIMIT 0,$number ",ARRAY_A);
		} elseif ( $group != 'all' && $number != 'all' && $by == 'order' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_order` = '0',`tb_order` ASC LIMIT 0,$number ",ARRAY_A);
		} elseif ( $group != 'all' && $number != 'all' && $by == 'random' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY RAND() LIMIT 0,$number ",ARRAY_A);
		}
				
		$katb_tdata_array[0] = $katb_tdata;
		$katb_tdata_array[1] = $wpdb->num_rows;
		return $katb_tdata_array; 

	}

}

/**
 * This function is called if the widget requires a schema aggregate set up.
 * It sets up the company name and website in meta tags, and does a aggregate 
 * average rating.
 * 
 * @param string $company_name user option
 * @param string $company_website user option
 * @param string $group_name user option
 * @param boolean $use_aggregate_group_name user option
 * @param string $custom_aggregate_name user option
 * 
 * 
 */
function katb_widget_schema_company_aggregate ( $company_name, $company_website, $group_name, $use_aggregate_group_name, $custom_aggregate_name ) {
	
	global $wpdb,$tablename;
	$tablename = $wpdb->prefix.'testimonial_basics';
	
	//query database 
	if( $group_name != 'all' ) {
	
		$aggregate_data = $wpdb->get_results( " SELECT `tb_rating` FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group_name' ",ARRAY_A);
		$aggregate_total_approved = $wpdb->num_rows;
			
	} else {
		
		$aggregate_data = $wpdb->get_results( " SELECT `tb_rating` FROM `$tablename` WHERE `tb_approved` = '1' ",ARRAY_A);
		$aggregate_total_approved = $wpdb->num_rows;
						
	}
	
	//Get the average of the ratings				
	$count = 0;
	$sum = 0;
	for ( $j = 0 ; $j < $aggregate_total_approved; $j++ ) {

		$rating = (float) $aggregate_data[$j]['tb_rating'];
		if( $rating != '' && $rating > 0 ) {
			$count = $count + 1;
			$sum = $sum + (float)$aggregate_data[$j]['tb_rating'] ;
		}			
	}

	if( $count == 0 ) $count = 1;
	$avg_rating = round( $sum / $count, 1 );			
					
	?>
	
	<div itemscope itemtype="http://schema.org/Organization">
		
		<meta content="<?php echo stripcslashes( esc_attr( $company_name ) ); ?>" itemprop="name" />
		<meta content="<?php echo esc_url( $company_website ); ?>" itemprop="url" />
		
		<?php if( $count > 1 && $avg_rating > 0 ) { ?>
		
			<div itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
			
				<?php if( $custom_aggregate_name != '' ) { ?>
					<meta content="<?php echo stripcslashes( esc_attr( $custom_aggregate_name ) ); ?>" itemprop="itemreviewed" />
				<?php } else { ?>
					<meta content="<?php echo stripcslashes( esc_attr( $group_name ) ); ?>" itemprop="itemreviewed" />
				<?php }	?>
				
				<div itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">
					<meta content="<?php echo $avg_rating; ?>" itemprop="average"/>
					<meta content="0" itemprop="worst" />
					<meta content="5" itemprop="best" />
				</div>
				<meta content="<?php echo $count; ?>" itemprop="votes" />
				<meta content="<?php echo $aggregate_total_approved; ?>" itemprop="count" />
				
			</div>
		
		<?php }
}

/**
 * This function displays the testimonial.
 * 
 * @param array $katb_widget_tdata testimonial data
 * @param string $katb_widget_tnumber total number of testimonials
 * @param boolean $rotate 
 * @param string $group_name group name from widget data
 * 
 * @uses katb_get_options() user options from katb_functions.php
 * @uses katb_validate_gravatar() check for gravatar from this file
 * @uses katb_widget_popup() set up popup  from this file
 * @uses katb_widget_testimonial_wrap_div() sets up main formatting div wrap from this file
 * @uses katb_meta_widget_top() html for top meta from this file
 * @uses katb_testimonial_excerpt_filter()  from this file
 * @uses katb_widget_insert_gravatar()  from this file
 * @uses katb_meta_widget_bottom() html for bottom meta from this file
 */
 
function katb_widget_display_testimonial ( $use_schema, $katb_widget_tdata, $katb_widget_tnumber, $rotate, $group_name , $layout_override ) {
	
	//get user options
	global $katb_options;
	//$katb_options = katb_get_options();
	
	$use_ratings = intval( $katb_options['katb_use_ratings'] );
	$use_css_ratings = intval( $katb_options['katb_use_css_ratings'] );
	$use_excerpts = intval( $katb_options['katb_widget_use_excerpts'] );
	$use_gravatars = intval( $katb_options['katb_widget_use_gravatars'] );
	$use_round_images = intval( $katb_options['katb_widget_use_round_images'] );
	$use_gravatar_substitute = intval( $katb_options['katb_widget_use_gravatar_substitute'] );
	$gravatar_size = intval( $katb_options['katb_widget_gravatar_size'] );
	$layout = sanitize_text_field( $katb_options['katb_widget_layout_option'] );
	$use_individual_group_name = intval( $katb_options['katb_individual_group_name'] );
	$custom_individual_name = sanitize_text_field( $katb_options['katb_individual_custom_name'] );
	$use_title_non_schema =  intval( $katb_options['katb_widget_show_title'] );
	$use_formatted_display = intval( $katb_options['katb_widget_use_formatted_display'] );
	$katb_widget_height = intval( $katb_options['katb_widget_rotator_height'] );

	//set up widget height restriction if any
	if( $katb_widget_height != 'variable') {
		$katb_widget_height_option = 'style="min-height:'.$katb_widget_height.'px;overflow:hidden;"';
		$katb_widget_height_outside = $katb_widget_height + 20;
		$katb_widget_height_option_outside = 'style="min-height:'.$katb_widget_height_outside.'px;overflow:hidden;"';
	} else {
		$katb_widget_height_option = '';
		$katb_widget_height_option_outside = '';
	}

	/* since 4.1.0 added layout override */
	if( $layout_override != '0' ) {
		if( $layout_override == '1' ){
			$layout = 'Top Meta';
			$use_formatted_display = '0';
		} elseif ( $layout_override == '2' ){
			$layout = 'Bottom Meta';
			$use_formatted_display = '0';
		} elseif ( $layout_override == '3' ){
			$layout = 'Image & Meta Top';
			$use_formatted_display = '0';
		} elseif ( $layout_override == '4' ){
			$layout = 'Image & Meta Bottom';
			$use_formatted_display = '0';
		} elseif ( $layout_override == '5' ){
			$layout = 'Centered Image & Meta Top';
			$use_formatted_display = '0';
		} elseif ( $layout_override == '6' ){
			$layout = 'Centered Image & Meta Bottom';
			$use_formatted_display = '0';
		} elseif ( $layout_override == '7' ){
			$layout = 'Top Meta';
			$use_formatted_display = '1';
		} elseif ( $layout_override == '8' ){
			$layout = 'Bottom Meta';
			$use_formatted_display = '1';
		} elseif ( $layout_override == '9' ){
			$layout = 'Image & Meta Top';
			$use_formatted_display = '1';
		} elseif ( $layout_override == '10' ){
			$layout = 'Image & Meta Bottom';
			$use_formatted_display = '1';
		} elseif ( $layout_override == '11' ){
			$layout = 'Centered Image & Meta Top';
			$use_formatted_display = '1';
		} elseif ( $layout_override == '12' ){
			$layout = 'Centered Image & Meta Bottom';
			$use_formatted_display = '1';
		}
	}
	
	/* since ver 4.1.0 added Image & Meta Top and Image & Meta Bottom layouts
	   to allow independent styling will add the following classes when needed
	   note this is different from the content mods as an extra class was added 
	   rather then appending classes */
	if( $layout == 'Image & Meta Top' ) {
		$new_layout_class = ' img_meta_top';
	} elseif ( $layout == 'Image & Meta Bottom' ) {
		$new_layout_class = ' img_meta_bot';
	} else {
		$new_layout_class = '';
	}

	if( $rotate == 1 ) {
				
		$katb_widget_speed = $katb_options['katb_widget_rotator_speed'];
		$katb_widget_transition = $katb_options['katb_widget_rotator_transition'];
		if( $use_formatted_display == 1 ) { ?>
			<div class="katb_widget_rotate katb_widget_rotator_wrap<?php echo ' '.$new_layout_class; ?>" <?php echo $katb_widget_height_option_outside; ?> 
				data-katb_speed="<?php echo esc_attr( $katb_widget_speed ); ?>" 
				data-katb_transition="<?php echo esc_attr( $katb_widget_transition ); ?>">
		<?php } else { ?>
			<div class="katb_widget_rotate katb_widget_rotator_wrap_basic<?php echo ' '.$new_layout_class; ?>" <?php echo $katb_widget_height_option_outside; ?> 
				data-katb_speed="<?php echo esc_attr( $katb_widget_speed ); ?>" 
				data-katb_transition="<?php echo esc_attr( $katb_widget_transition ); ?>">
		<?php }
			
	} else {
		
		if( $use_formatted_display == 1 ) { ?>
			<div class="katb_widget_wrap<?php echo $new_layout_class; ?>">
		<?php } else { ?>
			<div class="katb_widget_wrap_basic<?php echo $new_layout_class; ?>">
		<?php }
		
	}
			
			for ( $i = 0 ; $i < $katb_widget_tnumber; $i++ ) {
				
				//if gravatars are enabled, check for valid avatar
				if ( $use_gravatars == 1 && $use_gravatar_substitute != 1 ) {
					$has_valid_avatar = katb_validate_gravatar( $katb_widget_tdata[$i]['tb_email'] ); 
				} else {
					$has_valid_avatar = 0;
				}
					
				//set up hidden popup if excerpt is used
				if ( $use_excerpts == 1 ) katb_widget_popup( $has_valid_avatar , $katb_widget_tdata , $i , $layout );
					
				//<div class=.... > wrap
				$div_prop = katb_widget_testimonial_wrap_div( $use_formatted_display , $use_schema , $rotate, $katb_widget_height_option, $i );
				//title html
				$title = katb_widget_insert_title( $use_schema , $use_title_non_schema , $katb_widget_tdata, $i, $use_individual_group_name, $custom_individual_name );
				//rating html 
				$rating = katb_widget_insert_rating( $use_schema , $use_ratings , $use_css_ratings , $katb_widget_tdata, $i );
				//get gravatar html
				$photo_or_gravatar = katb_widget_insert_gravatar( $katb_widget_tdata[$i]['tb_pic_url'] , $gravatar_size , $use_gravatars , $use_round_images , $use_gravatar_substitute , $has_valid_avatar , $katb_widget_tdata[$i]['tb_email'] );
				//get widget testimonial content
				$widget_content = katb_widget_content( $use_excerpts , $katb_widget_tdata , $i , $use_schema , $photo_or_gravatar , $use_formatted_display , $layout );
								
				echo $div_prop; //<div class=.... > wrap
					
					if( $layout == "Top Meta" ) {
						
						echo $title;
						echo $rating;
						katb_meta_widget_top( $i , $katb_widget_tdata, $use_schema );
						echo $widget_content;
						
					} elseif( $layout == "Bottom Meta" ) {	
						
						echo $title;
						echo $rating;
						echo $widget_content;
						katb_meta_widget_bottom( $i , $katb_widget_tdata, $use_schema );

					} elseif( $layout == "Image & Meta Top" ) {
						
						$width_adj = $gravatar_size + 10;
						echo '<div class="katb_image_meta_top">';
							echo '<div class="katb_gravatar_top">'.$photo_or_gravatar.'</div>';
							echo '<div class="katb_meta_rating_top_wrap" style="width:calc(100% - '.$width_adj.'px);">';
								katb_meta_widget_with_image( $i, $katb_widget_tdata, $use_schema );
								echo $rating;
							echo '</div>';
						echo '</div>';
						echo $title;
						echo $widget_content;
						
					} elseif( $layout == "Image & Meta Bottom" ) {
						
						$width_adj = $gravatar_size + 10;
						echo $title;
						echo $widget_content;
						echo '<div class="katb_image_meta_bottom">';
							echo '<div class="katb_gravatar_bottom">'.$photo_or_gravatar.'</div>';
							echo '<div class="katb_meta_rating_bottom_wrap" style="width:calc(100% - '.$width_adj.'px);">';
								katb_meta_widget_with_image( $i, $katb_widget_tdata, $use_schema );
								echo $rating;
							echo '</div>';
						echo '</div>';
							
					} elseif( $layout == "Centered Image & Meta Top" ) {
						
						echo '<div class="katb_centered_image_meta_top">';
							echo '<div class="katb_centered_gravatar_top">'.$photo_or_gravatar.'</div>';
							echo '<div class="katb_centered_meta_rating_top_wrap">';
								katb_meta_widget_with_image( $i, $katb_widget_tdata, $use_schema );
								echo $rating;
							echo '</div>';
						echo '</div>';
						echo $title;
						echo $widget_content;
						
					} elseif( $layout == "Centered Image & Meta Bottom" ) {
						
						$width_adj = $gravatar_size + 10;
						echo $title;
						echo $widget_content;
						echo '<div class="katb_centered_image_meta_bottom">';
							echo '<div class="katb_centered_gravatar_bottom">'.$photo_or_gravatar.'</div>';
							echo '<div class="katb_centered_meta_rating_bottom_wrap" >';
								katb_meta_widget_with_image( $i, $katb_widget_tdata, $use_schema );
								echo $rating;
							echo '</div>';
						echo '</div>';
						
					}
				echo '</div>'; // close katb_widget_box/katb_widget_box_basic
			
			}
				
		echo '</div>';
			
}

/**
 * Set up and display the pop p html
 * 
 * @param boolean $has_valid_avatar
 * @param array $katb_widget_tdata testimonial data
 * @param $i counter for testimonial loop
 * 
 * @uses katb_get_options() user options from katb_functions.php
 * @uses katb_meta_top() html meta strip from this file
 * @uses katb_widget_insert_gravatar() html for gravatar from this file
 * @uses katb_meta_bottom() from this file
 * 
 */
function katb_widget_popup( $has_valid_avatar , $katb_widget_tdata , $i , $layout ) {
	
	//get user options
	global $katb_options;
	//$katb_options = katb_get_options();
	$use_ratings = intval( $katb_options['katb_use_ratings'] );
	$use_css_ratings = intval( $katb_options['katb_use_css_ratings'] );
	$use_gravatars = intval( $katb_options['katb_widget_use_gravatars'] );
	$use_round_images = intval( $katb_options['katb_widget_use_round_images'] );
	$use_gravatar_substitute = intval( $katb_options['katb_widget_use_gravatar_substitute'] );
	$gravatar_size = intval( $katb_options['katb_widget_gravatar_size'] ); //note this is size for content and not the widget
	$use_individual_group_name = intval( $katb_options['katb_individual_group_name'] );
	$custom_individual_name = sanitize_text_field( $katb_options['katb_individual_custom_name'] );
	$use_title =  intval( $katb_options['katb_widget_show_title'] );
	$use_schema = 0;//used to ensure no schema markup in meta
	$schema_on_for_title = intval( $katb_options['katb_use_schema'] );//used to decide on title display

	?><div class="katb_topopup" id="katb_widget_<?php echo sanitize_text_field( $katb_widget_tdata[$i]['tb_id'] ); ?>">
		
		<div class="katb_close"></div>
		
		<div class="katb_popup_wrap katb_widget">

			<?php
					
				if( $use_title == 1 || $use_ratings == 1 ) { ?>
					
					<div class="katb_title_bar">
						
						<?php
						//title for testimonial
						if( $schema_on_for_title == 1 || $use_title == 1 ) {
								
							//get group name for testimonial
							$individual_group_name = $katb_widget_tdata[$i]['tb_group'];
								
							if( $use_individual_group_name == 1 && $individual_group_name != '' ) {
								echo '<span class="individual_itemreviewed" >'.stripcslashes( esc_attr( $individual_group_name ) ).'</span>&nbsp;';
							} elseif( $custom_individual_name != '' ) {
								echo '<span class="individual_itemreviewed" >'.stripcslashes( esc_attr( $custom_individual_name ) ).'</span>&nbsp;';
							}
								
						} //close use title
							
						//Display the rating if selected
						
	
						if ( $use_ratings == 1 ) {
							
							$rating = $katb_widget_tdata[$i]['tb_rating'];
							if( $rating == '' ) { $rating = 0; }	
							
							if($rating > 0 ) {
								 
								if( $use_css_ratings !=1 ) {
									echo '<span class="rateit katb_display_rating" data-rateit-value="'.esc_attr( $rating ).'" data-rateit-ispreset="true" data-rateit-readonly="true"></span><br/>';
								} else {
									$html = '';
									$html .= '<span class="katb_css_rating">';
									$html .= katb_css_rating( $rating );
									$html .= '</span>';
									echo $html;
								}
							
							}
							
						} ?>
							
					</div>
							
				<?php }
						
				if( $layout == 'Top Meta' || $layout == 'Image & Meta Top' || $layout == 'Centered Image & Meta Top' ) { echo katb_meta_widget_top( $i, $katb_widget_tdata, $use_schema ); }
				
				$gravatar_or_photo = katb_widget_insert_gravatar( $katb_widget_tdata[$i]['tb_pic_url'] , $gravatar_size , $use_gravatars , $use_round_images , $use_gravatar_substitute, $has_valid_avatar , $katb_widget_tdata[$i]['tb_email'] );
				
				echo '<div class="katb_test_text_basic" >'.$gravatar_or_photo.wp_kses_post( wpautop( stripcslashes( $katb_widget_tdata[$i]['tb_testimonial'] ) ) ).'</div>';
				
				if( $layout == 'Bottom Meta' || $layout == 'Image & Meta Bottom' || $layout == 'Centered Image & Meta Bottom' )  { echo  katb_meta_widget_bottom( $i, $katb_widget_tdata, $use_schema ); } 

			?>
				
			
		</div>
		
	</div>	
		
	<div class="katb_loader"></div>
		
	<div class="katb_excerpt_popup_bg" id="katb_widget_<?php echo sanitize_text_field( $katb_widget_tdata[$i]['tb_id'] ); ?>_bg"></div>
		
	<?php return;
		
}

/**
 * Testimonial content wrap helper - sets up the div
 * 
 * @param boolean 
 * @param boolean 
 * @param boolean 
 * @param string either variable or a height in pixels
 * @param $i counter for testimonial loop
 * 
 * @return $div_prop 
 */
function katb_widget_testimonial_wrap_div( $use_formatted_display , $use_schema , $katb_rotate, $katb_widget_height_option, $i ) {
	
	$div_prop = '';

	if( $katb_rotate == 1 && $use_formatted_display == 1 && $use_schema == 1 ) {
		
		if( $i == 0 ) {
			$div_prop .= '<div class="katb_widget_rotator_box katb_widget_rotate_show" itemscope itemtype="http://schema.org/Review" '.$katb_widget_height_option.'>';
		} else {
			$div_prop .= '<div class="katb_widget_rotator_box katb_widget_rotate_noshow" itemscope itemtype="http://schema.org/Review" '.$katb_widget_height_option.'>';
		}
		
	} elseif( $katb_rotate == 1 && $use_formatted_display != 1 && $use_schema == 1 ) {
		
		if( $i == 0 ) {
			$div_prop .= '<div class="katb_widget_rotator_box_basic katb_widget_rotate_show" itemscope itemtype="http://schema.org/Review" '.$katb_widget_height_option.'>';
		} else {
			$div_prop .= '<div class="katb_widget_rotator_box_basic katb_widget_rotate_noshow" itemscope itemtype="http://schema.org/Review" '.$katb_widget_height_option.'>';
		}
		
	} elseif( $katb_rotate == 1 && $use_formatted_display != 1 && $use_schema != 1 ) {
		
		if( $i == 0 ) {
			$div_prop .= '<div class="katb_widget_rotator_box_basic katb_widget_rotate_show" '.$katb_widget_height_option.'>';
		} else {
			$div_prop .= '<div class="katb_widget_rotator_box_basic katb_widget_rotate_noshow" '.$katb_widget_height_option.'>';
		}
	
	} elseif( $katb_rotate == 1 && $use_formatted_display == 1 && $use_schema != 1 ) {
		
		if( $i == 0 ) {
			$div_prop .= '<div class="katb_widget_rotator_box katb_widget_rotate_show" '.$katb_widget_height_option.'>';
		} else {
			$div_prop .= '<div class="katb_widget_rotator_box katb_widget_rotate_noshow" '.$katb_widget_height_option.'>';
		}
			
	} elseif( $katb_rotate != 1 && $use_formatted_display == 1 && $use_schema == 1 ) {
		
		$div_prop .= '<div class="katb_widget_box" itemscope itemtype="http://schema.org/Review"'.'>';
		
	} elseif( $katb_rotate != 1 && $use_formatted_display != 1 && $use_schema == 1 ) {
		
		$div_prop .= '<div class="katb_widget_box_basic" itemscope itemtype="http://schema.org/Review"'.'>';
		
	} elseif( $katb_rotate != 1 && $use_formatted_display != 1 && $use_schema != 1 ) {
		
		$div_prop .= '<div class="katb_widget_box_basic"'.'>';
		
	} elseif( $katb_rotate != 1 && $use_formatted_display == 1 && $use_schema != 1 ) {
		
		$div_prop .= '<div class="katb_widget_box"'.'>';
			
	}
	
	return $div_prop;
	
}

/**                 TITLE HELPER
 * This function is a helper function to set up the title bar html
 * 
 * @param boolean $use_schema user option
 * @param boolean $use_title_non_schema user option 
 * @param array $katb_widget_tdata testimonial data
 * @param integer $i where we are in the $katb_widget_tdata loop
 * @param boolean $use_individual_group_name user option
 * @param string $custom_individual_name user option
 * 
 * @return $html which is the html for the for title bar
 */
function katb_widget_insert_title( $use_schema , $use_title_non_schema , $katb_widget_tdata, $i, $use_individual_group_name, $custom_individual_name ){
	
	$html = '';
	
	if( $use_schema == 1 || $use_title_non_schema == 1 ) {
			
		$html .= '<div class="katb_widget_title_bar">';

			//get group name for testimonial
			$individual_group_name = sanitize_text_field( $katb_widget_tdata[$i]['tb_group'] );
			
			if( $use_schema !=1 ) {
				if( $use_individual_group_name == 1 && $individual_group_name != '' ) {
					$html .= '<span class="individual_itemreviewed" >'.stripcslashes( esc_attr( $individual_group_name ) ).'</span>';
				} elseif( $custom_individual_name != '' ) {
					$html .= '<span class="individual_itemreviewed" >'.stripcslashes( esc_attr( $custom_individual_name ) ).'</span>';
				}
					
			} else {
				if( $use_individual_group_name == 1 && $individual_group_name != '' ) {
					$html .= '<span class="individual_itemreviewed" itemprop="name">'.stripcslashes( esc_attr( $individual_group_name ) ).'</span>';
					$html .= '<div itemprop="itemReviewed" itemscope itemtype="http://schema.org/Thing">';
					$html .= '<meta itemprop="name" content="'.stripcslashes( esc_attr( $individual_group_name ) ).'"></div>';
				} elseif( $custom_individual_name != '' ) {
					$html .= '<span class="individual_itemreviewed" itemprop="name">'.stripcslashes( esc_attr( $custom_individual_name ) ).'</span>';
					$html .= '<div itemprop="itemReviewed" itemscope itemtype="http://schema.org/Thing">';
					$html .= '<meta itemprop="name" content="'.stripcslashes( esc_attr( $custom_individual_name ) ).'"></div>';
				}
			}
		
		$html .= '</div>';
		
		return $html;
	}
	
}

/**          RATING HTML HELPER
 * This function is a helper function to set up the rating html
 * 
 * @param boolean $use_schema user option
 * @param boolean $use_ratings user option
 * @param boolean $use_css_ratings user option
 * @param array $katb_widget_tdata testimonial data
 * @param integer $i where we are in the $katb_widget_tdata loop
 * 
 * @return $html which is the html for the for title bar
 */
 function katb_widget_insert_rating( $use_schema , $use_ratings , $use_css_ratings , $katb_widget_tdata, $i ){
	
	$html = '';	$html2=''; $html3 = ''; $html_meta = '';
	
	if( $use_ratings == 1 ) {
					
		$html2 .= '<div class="katb_widget_rating">';

			//Display the rating if selected
			if ( $use_ratings == 1 ) { 

				$rating = $katb_widget_tdata[$i]['tb_rating'];
				if( $rating == '' ) { $rating = 0; }
				
				if( $rating > 0 ) {
					
					if( $use_css_ratings == 1 ) {
						$html .= '<span class="katb_css_rating">';
						$html .= katb_css_rating( $rating );
						$html .= '</span>';
					} else {
						$html .= '<span class="rateit smallstars katb_widget_display_rating" data-rateit-starwidth="12" data-rateit-starheight="12" data-rateit-value="'.esc_attr( $rating ).'" data-rateit-ispreset="true" data-rateit-readonly="true"></span>';	
					}
					
					//schema schema schema :)
					if( $use_schema == 1 ) {
						$html_meta .= '<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating"> ';
						$html_meta .= '<meta itemprop="worstRating" content="0" />';
						$html_meta .= '<meta itemprop="ratingValue" content="'.esc_attr( $rating ).'" />';
						$html_meta .= '<meta itemprop="bestRating" content="5" />';
						$html_meta .= '</div>';
					}
				
				}
				
			}
			
		$html3 .= '</div>';
			
	}
	$html_return = '';
	if( $html == '' ){
		if( $html_meta != ''){
			$html_return .= $html_meta;
		}
	} else {
		$html_return .= $html2.$html.$html_meta.$html3;
	}
	
	return $html_return;
}

/**
 * This function is a helper to insert a gravatar or image
 * 
 * @param string $image_url if uploaded image, this is the url
 * @param string $gravatar_size user option
 * @param boolean $use_gravatars user option 
 * @param boolean $use_gravatar_substitute user option
 * @param boolean $has_valid_avatar result of avatar check 
 * @param string $email address of author
 * 
 */
 
function katb_widget_insert_gravatar( $image_url , $gravatar_size , $use_gravatars , $use_round_images , $use_gravatar_substitute , $has_valid_avatar , $email ){
	
	if( $use_round_images == 1 ){ $round_image_class = '_round_image'; } else { $round_image_class = ''; }
	//If uploaded photo use that, else use gravatar if selected and available
	$html = '';
	if ( $image_url != '' )  {
		//$html = '<span class="katb_widget_avatar'.$round_image_class.'"><img class="avatar" src="'.esc_url( $image_url ).
		//			'" alt="Author Picture" style="width:'.esc_attr( $gravatar_size ).'px; height:auto;" /></span>';
		$html = '<span class="katb_widget_avatar'.$round_image_class.'" style="width:'.esc_attr( $gravatar_size ).'px; height:auto;" >
					<img class="avatar" src="'.esc_url( $image_url ).'" alt="Author Picture" /></span>';
	} elseif ( $use_gravatars == 1 && $has_valid_avatar == 1 ) {
		//$html = '<span class="katb_widget_avatar'.$round_image_class.'" >'.get_avatar( $email , $size = $gravatar_size ).'</span>';
		$html = '<span class="katb_widget_avatar'.$round_image_class.'"  style="width:'.esc_attr( $gravatar_size ).'px; height:auto;" >'.get_avatar( $email , $size = $gravatar_size ).'</span>';
	} elseif ( $use_gravatars == 1 && $use_gravatar_substitute == 1 ) {
		//$html = '<span class="katb_widget_avatar'.$round_image_class.'" >'.get_avatar( $email , $size = $gravatar_size ).'</span>';
		$html = '<span class="katb_widget_avatar'.$round_image_class.'"  style="width:'.esc_attr( $gravatar_size ).'px; height:auto;" >'.get_avatar( $email , $size = $gravatar_size ).'</span>';
	}
	
	return $html;
	
}

/** WIDGET CONTENT HTML
 * This function is a helper to insert a gravatar or image
 * 
 * @param string $image_url if uploaded image, this is the url
 * @param string $gravatar_size user option
 * @param boolean $use_gravatars user option 
 * @param boolean $use_gravatar_substitute user option
 * @param boolean $has_valid_avatar result of avatar check 
 * @param string $email address of author
 * 
 */
 
function katb_widget_content( $use_excerpts , $katb_widget_tdata, $i, $use_schema, $photo_or_gravatar, $use_formatted_display, $layout ){
	
	$katb_options = katb_get_options();
	if( $layout == "Image & Meta Top" || $layout == "Image & Meta Bottom" || $layout == "Centered Image & Meta Top" || $layout == "Centered Image & Meta Bottom" ) 
	{ $photo_or_gravatar = ''; }
	
	$html = '';
	
	//display the content
	if ( $use_excerpts == 1 ) {
		
		$text = wpautop( wp_kses_post( stripcslashes($katb_widget_tdata[$i]['tb_testimonial'] ) ) );
		$length = intval( $katb_options['katb_widget_excerpt_length'] );
		$classID = 'katb_widget_'.sanitize_text_field( $katb_widget_tdata[$i]['tb_id'] );
		$text2 = katb_testimonial_excerpt_filter( $length, $text, $classID );
		
		if( $use_schema != 1 ) {
			
			if( $use_formatted_display == 1 ) {
				$html .= '<div class="katb_widget_text">'.$photo_or_gravatar.$text2.'</div>';
			} else {
				$html .= '<div class="katb_widget_text_basic">'.$photo_or_gravatar.$text2.'</div>';
			}
			
		} else {
			
			if( $use_formatted_display == 1 ) {
				$html .= '<div class="katb_widget_text" itemprop="reviewBody">'.$photo_or_gravatar.$text2.'</div>';
			} else {
				$html .= '<div class="katb_widget_text_basic" itemprop="reviewBody">'.$photo_or_gravatar.$text2.'</div>';
			}
			
		}
		
	} else {
		
		if( $use_schema != 1 ) {
			
			if( $use_formatted_display == 1 ) {
				$html .= '<div class="katb_widget_text" >'.$photo_or_gravatar.wp_kses_post( wpautop( stripcslashes( $katb_widget_tdata[$i]['tb_testimonial'] ) ) ).'</div>';
			} else {
				$html .= '<div class="katb_widget_text_basic" >'.$photo_or_gravatar.wp_kses_post( wpautop( stripcslashes( $katb_widget_tdata[$i]['tb_testimonial'] ) ) ).'</div>';
			}
			
		} else {
			
			if( $use_formatted_display == 1 ) {
				$html .= '<div class="katb_widget_text" itemprop="description">'.$photo_or_gravatar.wp_kses_post( wpautop( stripcslashes( $katb_widget_tdata[$i]['tb_testimonial'] ) ) ).'</div>';
			} else {
				$html .= '<div class="katb_widget_text_basic" itemprop="description">'.$photo_or_gravatar.wp_kses_post( wpautop( stripcslashes( $katb_widget_tdata[$i]['tb_testimonial'] ) ) ).'</div>';
			}
			
		}
	}
	
	return $html;
	
}
 
/**
 * This function provides the meta for the bottom of the testimonial
 * 
 * @param string $i is the testimonial count in the loop
 * @param array $katb_tdata is the testimonial data
 * @param boolean $use_schema
 * 
 * @uses katb_get_options() user options from katb_functions.php
 * 
 */
function katb_meta_widget_bottom( $i, $katb_tdata, $use_schema ){
	
	//get user options
	$katb_options = katb_get_options();
	$show_date = $katb_options['katb_widget_show_date'];
	$show_location = $katb_options['katb_widget_show_location'];
	$show_website = $katb_options['katb_widget_show_website'];
	
	
	?><div class="katb_widget_meta_bottom"><?php
				
		//author		
		if( $use_schema != 1 ) { ?>
			<span class="katb_widget_author"><?php echo sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_name'] ) ); ?></span>
		<?php } else { ?>
			<div itemprop="author" itemscope itemtype="http://schema.org/Person">
				<span class="katb_author" itemprop="name"><?php echo sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_name'] ) ); ?></span>
			</div>
		<?php }
		
		//date
		if ( $show_date == 1 ) {
			
			$katb_date = sanitize_text_field( $katb_tdata[$i]['tb_date'] );
			if( $use_schema != 1 ) { ?>
				<span class="katb_widget_date">&nbsp;&nbsp;<?php echo mysql2date(get_option( 'date_format' ), $katb_date ); ?></span>
			<?php } else { ?>
				<span class="katb_widget_date">
					<meta itemprop="datePublished" content="<?php echo mysql2date( 'Y-m-d' , $katb_date ); ?>">
					&nbsp;&nbsp;<?php echo mysql2date( 'Y-m-d' , $katb_date ); ?>
				</span>
			<?php }
			
		}
		
		//location
		if ( $show_location == 1 && $katb_tdata[$i]['tb_location'] != '') { ?>
			
			<span class="katb_widget_location">&nbsp;&nbsp;<?php echo sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_location'] ) ); ?></span>
		
		<?php }
		
		//website		
		if ( $show_website == 1 && $katb_tdata[$i]['tb_url'] != '' ) { ?>
			
			<span class="katb_widget_website">&nbsp;&nbsp;<a href="<?php echo esc_url( $katb_tdata[$i]['tb_url'] ); ?>" title="<?php echo esc_url( $katb_tdata[$i]['tb_url'] ); ?>" target="_blank" >Website</a></span>
			
		<?php } ?>
	
	</div>
	
	<?php return;
}

/**
 * This function provides the meta for the top of the testimonial
 * 
 * @param string $i is the testimonial count in the loop
 * @param array $katb_tdata is the testimonial data
 * @param boolean $use_schema
 * 
 * @uses katb_get_options() user options from katb_functions.php
 * 
 */
function katb_meta_widget_top( $i, $katb_tdata, $use_schema ){
	
	//get user options
	$katb_options = katb_get_options();
	$show_date = $katb_options['katb_widget_show_date'];
	$show_location = $katb_options['katb_widget_show_location'];
	$show_website = $katb_options['katb_widget_show_website'];
	
	?><div class="katb_widget_meta_top"><?php
		
		//author		
		if( $use_schema != 1 ) { ?>
			<span class="katb_widget_author"><?php echo sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_name'] ) ); ?></span>
		<?php } else { ?>
			<div itemprop="author" itemscope itemtype="http://schema.org/Person">
				<span class="katb_widget_author" itemprop="name"><?php echo sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_name'] ) ); ?></span>
			</div>
		<?php }
		
		//date
		if ( $show_date == 1 ) {
			$katb_date = sanitize_text_field( $katb_tdata[$i]['tb_date'] );
			if( $use_schema != 1 ) { ?>
				<span class="katb_widget_date">&nbsp;&nbsp;<?php echo mysql2date(get_option( 'date_format' ), $katb_date ); ?></span>
			<?php } else { ?> 
				<span class="katb_widget_date">
					<meta itemprop="datePublished" content="<?php echo mysql2date( 'Y-m-d' , $katb_date ); ?>">
					&nbsp;&nbsp;<?php echo mysql2date( 'Y-m-d' , $katb_date ); ?>
				</span>
		<?php }
			
		}
		
		//location
		if ( $show_location == 1 && $katb_tdata[$i]['tb_location'] != '') { ?>
			
			<span class="katb_widget_location">&nbsp;&nbsp;<?php echo sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_location'] ) ); ?></span>
		
		<?php }
		
		//website		
		if ( $show_website == 1 && $katb_tdata[$i]['tb_url'] != '' ) { ?>
			
			<span class="katb_widget_website">&nbsp;&nbsp;<a href="<?php echo esc_url( $katb_tdata[$i]['tb_url'] ); ?>" title="<?php echo esc_url( $katb_tdata[$i]['tb_url'] ); ?>" target="_blank" >Website</a></span>
		
		<?php } ?>

	</div>
	
	<?php return;
}

/**
 * This function provides the meta html for the case 
 * where the meta is displayed with an image above or below the content
 * 
 * @param string $i is the testimonial count in the loop
 * @param array $katb_tdata is the testimonial data
 * @param boolean $use_schema
 * 
 * @uses katb_get_options() user options from katb_functions.php
 * 
 */
function katb_meta_widget_with_image( $i, $katb_widget_tdata, $use_schema ){
	
	//get user options
	$katb_options = katb_get_options();
	$show_date = $katb_options['katb_widget_show_date'];
	$show_location = $katb_options['katb_widget_show_location'];
	$show_website = $katb_options['katb_widget_show_website'];
	
	?><div class="katb_widget_meta_above_or_below"><?php
		
		//author		
		if( $use_schema != 1 ) { ?>
			<span class="katb_widget_author"><?php echo sanitize_text_field( stripcslashes($katb_widget_tdata[$i]['tb_name'] ) ); ?></span>
		<?php } else { ?>
			<div itemprop="author" itemscope itemtype="http://schema.org/Person">
				<span class="katb_widget_author" itemprop="name"><?php echo sanitize_text_field( stripcslashes( $katb_widget_tdata[$i]['tb_name'] ) ); ?></span>
			</div>
		<?php }
		
		//location
		if ( $show_location == 1 && $katb_widget_tdata[$i]['tb_location'] != '') { ?>
			
			<span class="katb_widget_location"><?php echo sanitize_text_field( stripcslashes( $katb_widget_tdata[$i]['tb_location'] ) ); ?></span>
		
		<?php }
		
		//website		
		if ( $show_website == 1 && $katb_widget_tdata[$i]['tb_url'] != '' ) { ?>
			
			<span class="katb_widget_website"><a href="<?php echo esc_url( $katb_widget_tdata[$i]['tb_url'] ); ?>" title="<?php echo esc_url( $katb_widget_tdata[$i]['tb_url'] ); ?>" target="_blank" >Website</a></span>
		
		<?php } 
		
		//date
		if ( $show_date == 1 ) {
			
			$katb_date = sanitize_text_field( $katb_widget_tdata[$i]['tb_date'] );
			if( $use_schema != 1 ) { ?>
				<span class="katb_widget_date"><?php echo mysql2date(get_option( 'date_format' ), $katb_date ); ?></span>
			<?php } else { ?> 
				<span class="katb_widget_date">
					<meta itemprop="datePublished" content="<?php echo mysql2date( 'Y-m-d' , $katb_date ); ?>">
					&nbsp;&nbsp;<?php echo mysql2date( 'Y-m-d' , $katb_date ); ?>
				</span>
			<?php }
			
		} ?>

	</div>
	
	<?php return;
}