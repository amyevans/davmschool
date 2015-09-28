<?php
/**
 * This file contains the shortcodes for displaying the testimonial in a content area.
 *
 * @package		Testimonial Basics WordPress Plugin
 * @copyright	Copyright (c) 2015, Kevin Archibald
 * @license		http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author		Kevin Archibald <www.kevinsspace.ca/contact/>
 * Testimonial Basics is distributed under the terms of the GNU GPL
 */

/** ------------------ display testimonials shortcode ---------------------------------
 * useage : [katb_testimonial group="all" number="all" by="date" id="" rotate="no" layout="0" schema="default"] 
 * group : "all" or "group" where group is the identifier in the testimonial
 * by : "date" or "order" or "random"
 * number : "all" or input the number you want to display
 * id : "" or ids of testimonials
 * rotate : "no" do not rotate, "yes" rotate testimonials
 * layout : 0-default,1-no format top meta, 2-no format bottom meta, 3-no format side meta,
 *          4-format top meta, 5-format bottom meta, 6-format side meta
 * schema : default-whatever is set up in the General Options Panel, yes-override to yes, no-override to no
 * 
 * @param array $atts contains the shortcode parameters
 * @uses katb_get_options() function to get plugin options found in katb_functions.php
 * @uses katb_offset_setup() for pagination found in katb_functions.php
 * @uses katb_setup_pagination for pagination  found in katb_functions.php
 * @uses katb_content_display sets up the testimonial display found in katb_functions.php
 * @uses katb_get_display_pagination_string displays pagination  found in katb_functions.php
 * 
 * @return string $katb_html containging the html of the testimonial display request
 * ------------------------------------------------------------------------- */

function katb_list_testimonials ( $atts ) {

	//setup database table
	global $wpdb , $tablename;
	$tablename = $wpdb->prefix.'testimonial_basics';
	
	//initialize main testimonial arrays
	$katb_tdata = array();
	$katb_tdata = '';
	$katb_tnumber = '';

	//get user options
	global $katb_options;
	$katb_options = katb_get_options();
	$use_formatted_display =  intval( $katb_options['katb_use_formatted_display'] );
	$content_layout = sanitize_text_field( $katb_options['katb_layout_option'] );
	$use_schema = intval( $katb_options['katb_use_schema'] );
	$display_reviews = intval( $katb_options['katb_schema_display_reviews'] );
	
	//set up pagination
	$katb_offset_name = home_url().'katb_offset';
	
	//$katb_items_per_page = 10;
	$katb_items_per_page = intval($katb_options['katb_paginate_number']);
	
	//get shortcode variables
	extract(shortcode_atts(array(
		'group' 	=> 'all',
		'number' 	=> 'all',
	    'by' 		=> 'random',
	    'id' 		=> '',
	    'rotate' 	=> 'no',
	    'layout' 	=> '0',
	    'schema'	=> 'default'
    ), $atts));
	 
	//Sanitize data

	$group = sanitize_text_field( $group );
	$number = strtolower( sanitize_text_field( $number ));
	$by = strtolower( sanitize_text_field( $by ));
	$id = sanitize_text_field($id);
	$rotate = strtolower( sanitize_text_field( $rotate ));
	$layout_override = sanitize_text_field( $layout );
	$use_schema_override = sanitize_text_field( $schema );

	//white list rotate
	if( $rotate != 'yes' ) { $rotate = 'no'; }
	
	//white list group
	if( $group == '' ) { $group = 'all'; }
	
	//number validation/whitelist
	if( $number == '' ) { $number = 'all'; }
	if( $number != 'all' ) {
		if( intval( $number ) < 1 ) {
			$number = 1;
		} else {
			$number = intval( $number );
		}
	}
	
	//white list $by
	if ($by != 'date' && $by != 'order') { $by = 'random'; }
	
	//white list layout
	if( $layout_override == '0' || $layout_override == '1' || $layout_override == '2' || $layout_override == '3' || $layout_override == '4' || $layout_override == '5' || $layout_override == '6' ) {/*do nothing*/}else{ $layout_override = '0'; }
	
	//white list schema
	if( $use_schema_override == 'yes' || $use_schema_override == 'no' ){/*do nothing*/}else{$use_schema_override = 'default';}
	
	//check use schema override
	if( $use_schema_override == 'yes' ){
		$use_schema = 1;
	} elseif ( $use_schema_override == 'no' ){
		$use_schema = 0;
	}
	
	//OK let's start by getting the testimonial data from the database
	if( $id != '' ) {
		$id_picks = array();
		$id_picks_processed = array();
		$id_picks = '';
		$id_picks_processed ='';
		$id_picks = explode( ',', $id );
		
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
		
		$katb_tnumber = $count2;

	} else {
	
		if ( $group == 'all' && $number == 'all' && $by == 'date' ) {
			
			if ( isset($katb_options['katb_use_pagination']) && $katb_options['katb_use_pagination'] == 1 && $rotate == 'no' ) {
				
				//Get total entries
				$results = $wpdb->get_results( " SELECT COUNT(1) FROM `$tablename` WHERE `tb_approved` = '1' ",ARRAY_A);
				$total_entries = $results[0]['COUNT(1)'];
					
				//check for offset
				if( isset ( $_POST['ka_paginate_post'] ) ) {
					$ka_paginate_action = $_POST['ka_paginate_post'];
					katb_offset_setup ( $katb_offset_name, $katb_items_per_page, $ka_paginate_action, $total_entries );
				}
						
				//Pagination
				$katb_paginate_setup = katb_setup_pagination( $katb_offset_name, $katb_items_per_page, $total_entries );
				$katb_offset = $katb_paginate_setup['offset'];
				if ($katb_offset < 0 ) { $katb_offset = 0; }
				//get results
				$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_date` DESC LIMIT $katb_items_per_page OFFSET $katb_offset ",ARRAY_A);
			
			} else {
				$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_date` DESC ",ARRAY_A);
			}
			
			$katb_tnumber = $wpdb->num_rows;
				
		} elseif ( $group == 'all' && $number == 'all' && $by == 'order' ) {
			
			if ( isset($katb_options['katb_use_pagination']) && $katb_options['katb_use_pagination'] == 1 && $rotate == 'no' ) {
						
				//Get total entries
				$results = $wpdb->get_results( " SELECT COUNT(1) FROM `$tablename` WHERE `tb_approved` = '1' ",ARRAY_A);
				$total_entries = $results[0]['COUNT(1)'];
						
				//check for offset
				if( isset ( $_POST['ka_paginate_post'] ) ) {
					$ka_paginate_action = $_POST['ka_paginate_post'];
					katb_offset_setup ( $katb_offset_name, $katb_items_per_page, $ka_paginate_action, $total_entries );
				}
					
				//Pagination
				$katb_paginate_setup = katb_setup_pagination( $katb_offset_name, $katb_items_per_page, $total_entries );
				$katb_offset = $katb_paginate_setup['offset'];
				if ($katb_offset < 0 ) { $katb_offset = 0; }
				
				//get results
				$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_order` = '0', `tb_order` ASC,`tb_date` DESC LIMIT $katb_items_per_page OFFSET $katb_offset ",ARRAY_A);
			} else {
				$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_order` = '0', `tb_order` ASC,`tb_date` DESC ",ARRAY_A);
			}
			
			$katb_tnumber = $wpdb->num_rows;
			
		} elseif ( $group == 'all' && $number == 'all' && $by == 'random' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY RAND() ",ARRAY_A);
			$katb_tnumber = $wpdb->num_rows;
		} elseif ( $group == 'all' && $number != 'all' && $by == 'date' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_date` DESC LIMIT 0,$number ",ARRAY_A);
			$katb_tnumber = $wpdb->num_rows;
		} elseif ( $group == 'all' && $number != 'all' && $by == 'order' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_order` = '0',`tb_order` ASC LIMIT 0,$number ",ARRAY_A);
			$katb_tnumber = $wpdb->num_rows;
		} elseif ( $group == 'all' && $number != 'all' && $by == 'random' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY RAND() LIMIT 0,$number ",ARRAY_A);
			$katb_tnumber = $wpdb->num_rows;
		} elseif ( $group != 'all' && $number == 'all' && $by == 'date' ) {
			
			if ( isset($katb_options['katb_use_pagination']) && $katb_options['katb_use_pagination'] == 1 && $rotate == 'no' ) {
					
				//Get total entries
				$results = $wpdb->get_results( " SELECT COUNT(1) FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ",ARRAY_A);
				$total_entries = $results[0]['COUNT(1)'];
					
				//check for offset
				if( isset ( $_POST['ka_paginate_post'] ) ) {
					$ka_paginate_action = $_POST['ka_paginate_post'];
					katb_offset_setup ( $katb_offset_name, $katb_items_per_page, $ka_paginate_action, $total_entries );
				}
					
				//Pagination
				$katb_paginate_setup = katb_setup_pagination( $katb_offset_name, $katb_items_per_page, $total_entries );
				$katb_offset = $katb_paginate_setup['offset'];
				if ($katb_offset < 0 ) { $katb_offset = 0; }
				//get results
				$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_date` DESC LIMIT $katb_items_per_page OFFSET $katb_offset ",ARRAY_A);
			} else {
				$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_date` DESC ",ARRAY_A);
			}
			
			$katb_tnumber = $wpdb->num_rows;
			
		} elseif ( $group != 'all' && $number == 'all' && $by == 'order' ) {
			
			if ( isset($katb_options['katb_use_pagination']) && $katb_options['katb_use_pagination'] == 1 && $rotate == 'no' ) {
					
				//Get total entries
				$results = $wpdb->get_results( " SELECT COUNT(1) FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ",ARRAY_A);
				$total_entries = $results[0]['COUNT(1)'];
					
				//check for offset
				if( isset ( $_POST['ka_paginate_post'] ) ) {
					$ka_paginate_action = $_POST['ka_paginate_post'];
					katb_offset_setup ( $katb_offset_name, $katb_items_per_page, $ka_paginate_action, $total_entries );
				}
				
				//Pagination
				$katb_paginate_setup = katb_setup_pagination( $katb_offset_name, $katb_items_per_page, $total_entries );
				$katb_offset = $katb_paginate_setup['offset'];
				if ($katb_offset < 0 ) $katb_offset = 0;
				
				//get results
				$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_order` = '0',`tb_order` ASC,`tb_date` DESC LIMIT $katb_items_per_page OFFSET $katb_offset ",ARRAY_A);
			} else {
				$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_order` = '0',`tb_order` ASC,`tb_date` DESC ",ARRAY_A);		
			}
			
			$katb_tnumber = $wpdb->num_rows;
			
		} elseif ( $group != 'all' && $number == 'all' && $by == 'random' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY RAND() ",ARRAY_A);	
			$katb_tnumber = $wpdb->num_rows;	
		} elseif ( $group != 'all' && $number != 'all' && $by == 'date' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_date` DESC LIMIT 0,$number ",ARRAY_A);
			$katb_tnumber = $wpdb->num_rows;
		} elseif ( $group != 'all' && $number != 'all' && $by == 'order' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_order` = '0',`tb_order` ASC LIMIT 0,$number ",ARRAY_A);
			$katb_tnumber = $wpdb->num_rows;
		} elseif ( $group != 'all' && $number != 'all' && $by == 'random' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY RAND() LIMIT 0,$number ",ARRAY_A);
			$katb_tnumber = $wpdb->num_rows;
		}
	}
	
		$katb_error = '';
				
		if ( $katb_tnumber < 2 && $rotate == 'yes' ) {
			$katb_error = esc_html__('You must have 2 approved testimonials to use a rotated display!','testimonial-basics');
		} elseif ( $katb_tnumber == 0 ) {
			$katb_error = esc_html__('There are no approved testimonials to display!','testimonial-basics');
		}

	$rotate == 'yes'? $katb_rotate = 1 : $katb_rotate = 0 ;
	
	// Database queried - Lets prepare the return string
	$katb_html = '';
	
	if( $katb_error != '') {
				
		$katb_html .= '<div class="katb_error">'.$katb_error.'</div>';
		
	} else {
			
		$katb_html .= katb_content_display( $use_formatted_display , $use_schema , $katb_tnumber , $katb_tdata , $katb_rotate , $content_layout , $group , $layout_override );

	}
	
	$katb_html .= '<div class="katb_clear_fix"></div>';
	//Pagination
	if( $use_schema == 1 && $display_reviews == 0 ) {
		//don't display pagination
	} else {
		
		if ( isset($katb_options['katb_use_pagination']) && $katb_options['katb_use_pagination'] == 1 && isset($katb_paginate_setup)) {
			$katb_html .= katb_get_display_pagination_string( $katb_paginate_setup );
		}
		
	}
	
	return $katb_html;
}
add_shortcode('katb_testimonial', 'katb_list_testimonials');

/** ------------- display testimonial input form shortcode -------------------
 * displays the testimonial input form
 * useage : [katb_input_testimonials group="All" form="1"] 
 * 
 * @param array $atts array of shortcode parameters, in this case only the group
 * 
 * @uses katb_get_options() array of plugin user options
 * 
 * @return string $input_html which is the html string for the form
 * ------------------------------------------------------------------------- */
function katb_display_input_form($atts) {
	
	$katb_options = katb_get_options();
	$author_label = $katb_options[ 'katb_author_label' ];
	$email_label = $katb_options[ 'katb_email_label' ];
	$website_label = $katb_options[ 'katb_website_label' ];
	$location_label = $katb_options[ 'katb_location_label' ];
	$rating_label =  $katb_options[ 'katb_rating_label' ];
	$testimonial_label = $katb_options[ 'katb_testimonial_label' ];
	$captcha_label = $katb_options[ 'katb_captcha_label' ];
	$submit_label = $katb_options[ 'katb_submit_label' ];
	$reset_label = $katb_options[ 'katb_reset_label' ];
	$required_label = $katb_options[ 'katb_required_label' ];
	$exclude_website = $katb_options[ 'katb_exclude_website_input' ];
	$exclude_location = $katb_options[ 'katb_exclude_location_input' ];
	$use_ratings = $katb_options[ 'katb_use_ratings' ];
	$use_css_ratings = $katb_options['katb_use_css_ratings'];
	$use_popup = $katb_options[ 'katb_use_popup_message' ];
	global $katb_group,$katb_author,$katb_email,$katb_website,$katb_location,$katb_rating,$katb_testimonial,$katb_input_error,$katb_input_success;
	$correct_form = false;
	
	//get shortcode variables
	extract(shortcode_atts(array(
		'group' => 'All',
		'form' => '1'
    ), $atts));
	
	$katb_group = sanitize_text_field($group);
	$katb_input_form_no = sanitize_text_field($form);
	
	if( isset( $_SESSION['katb_form_submitted'] ) && $_SESSION['katb_form_submitted'] != '' ) {
		if( SHA1( $katb_input_form_no ) == $_SESSION['katb_form_submitted'] ) {
			$correct_form = true;
			$_SESSION['katb_form_submitted'] = '';
		}
	}

	$input_html = '';
	
	$input_html .= '<div class="katb_input_style">';

		if( $katb_input_error != '' && $correct_form == true ) {
						
			if( $use_popup == 1 ){
				$error_message = esc_html__('There were errors so the testimonial was not added: ','testimonial-basics').$katb_input_error;
				?> <script>alert('<?php echo $error_message; ?>')</script>
			<?php } else {
				$input_html .= '<span class="katb_error">'.esc_html__('There were errors so the testimonial was not added: ','testimonial-basics').$katb_input_error.'</span>';
			}
			
		}
		
		if( isset($_SESSION['katb_submitted']) && $_SESSION['katb_submitted'] == SHA1('true') && $correct_form == true ) {
			
			if( $use_popup == 1 ){ ?>
				<script><?php echo 'alert("'.esc_html__("Testimonial Submitted - Thank You!","testimonial-basics").'")'; ?></script>
			<?php } else {
				$input_html .= '<span class="katb_test_sent">'.esc_html__('Testimonial Submitted - Thank You!','testimonial-basics').'</span>';
			}
			
			$_SESSION['katb_submitted'] = SHA1('false');
			
		}
		
		if ($katb_options['katb_include_input_title'] == 1) {
			$input_html .= '<h1 class="katb_content_input_title">'.esc_attr( stripcslashes( $katb_options['katb_input_title'] ) ).'</h1>';
		}

		if ($katb_options['katb_include_email_note'] == 1) {
			$input_html .= '<p>'.esc_attr( stripcslashes( $katb_options['katb_email_note'] ) ).'</p>';
		}
	
		$input_html .= '<form method="POST">';
			
			$input_html .= '<input type="hidden"  name="tb_group" value="'.esc_attr( stripcslashes( $katb_group ) ).'" />';
			
			$input_html .= '<label class="katb_input_label1">'.esc_attr( $author_label ).'</label>';
			if( $correct_form == true ) {
				$input_html .= '<input type="text"  maxlength="100" name="tb_author" value="'.esc_attr( stripcslashes( $katb_author ) ).'" /><br/>';
			} else {
				$input_html .= '<input type="text"  maxlength="100" name="tb_author" value="" /><br/>';
			}
			
			$input_html .= '<label class="katb_input_label1">'.esc_attr( $email_label ).'</label>';
			if( $correct_form == true ) {
				$input_html .= '<input type="text"  maxlength="100" name="tb_email" value="'.esc_attr( stripcslashes( $katb_email ) ).'" /><br/>';
			} else {
				$input_html .= '<input type="text"  maxlength="100" name="tb_email" value="" /><br/>';
			}
			
			if( $exclude_website != 1 ) {
				$input_html .= '<label class="katb_input_label1">'.esc_attr( $website_label ).'</label>';
				if( $correct_form == true ) {
					$input_html .= '<input type="text"  maxlength="100" name="tb_website" value="'.esc_url( stripcslashes( $katb_website ) ).'" /><br/>';
				} else {
					$input_html .= '<input type="text"  maxlength="100" name="tb_website" value="" /><br/>';
				}
			}
			
			if( $exclude_location != 1 ) {
				$input_html .= '<label class="katb_input_label1">'.esc_attr( $location_label ).'</label>';
				if( $correct_form == true ) {
					$input_html .= '<input type="text"  maxlength="100" name="tb_location" value="'.esc_attr( stripcslashes( $katb_location ) ).'" /><br/>';
				} else {
					$input_html .= '<input type="text"  maxlength="100" name="tb_location" value="" /><br/>';
				}
			}
			
			if( $use_ratings == 1 ) {
				if( $use_css_ratings != 1 ) {
					if( $katb_rating == '') $katb_rating = '0.0';
					$input_html .= '<label class="katb_input_label1">'.esc_attr( $rating_label ).'</label>';
					$input_html .= '<input type="range" min="0" max="5" value="'.$katb_rating.'" step="0.5" name="tb_rating" id="katb_rateit_input'.$katb_input_form_no.'" class="katb_rating_input">';
					$input_html .= '<div class="rateit katb_input_rating" data-rateit-backingfld="#katb_rateit_input'.$katb_input_form_no.'"></div>';
				} else {
					if( $correct_form == true ) {
						if( $katb_rating == '' ) $katb_rating = '0.0';
					} else {
						$katb_rating = '0.0';
					}
					$input_html .= '<label class="katb_input_label1">'.esc_attr( $rating_label ).'</label>';
					$input_html .= '<select name="tb_rating" class="katb_css_rating_select">';
					$input_html .= '<option value="0.0" '.selected( esc_attr( $katb_rating ),"0.0",false ).'>0.0</option>';
					$input_html .= '<option value="0.5" '.selected( esc_attr( $katb_rating ),"0.5",false ).'>0.5</option>';
					$input_html .= '<option value="1.0" '.selected( esc_attr( $katb_rating ),"1.0",false ).'>1.0</option>';
					$input_html .= '<option value="1.5" '.selected( esc_attr( $katb_rating ),"1.5",false ).'>1.5</option>';
					$input_html .= '<option value="2.0" '.selected( esc_attr( $katb_rating ),"2.0",false ).'>2.0</option>';
					$input_html .= '<option value="2.5" '.selected( esc_attr( $katb_rating ),"2.5",false ).'>2.5</option>';
					$input_html .= '<option value="3.0" '.selected( esc_attr( $katb_rating ),"3.0",false ).'>3.0</option>';
					$input_html .= '<option value="3.5" '.selected( esc_attr( $katb_rating ),"3.5",false ).'>3.5</option>';
					$input_html .= '<option value="4.0" '.selected( esc_attr( $katb_rating ),"4.0",false ).'>4.0</option>';
					$input_html .= '<option value="4.5" '.selected( esc_attr( $katb_rating ),"4.5",false ).'>4.5</option>';
					$input_html .= '<option value="5.0" '.selected( esc_attr( $katb_rating ),"5.0",false ).'>5.0</option>';
					$input_html .= '</select>';
				}
			}
			
			$input_html .= '<label class="katb_input_label2">'.esc_attr( $testimonial_label ).'</label><br/>';
			if( $correct_form == true ) {
				$input_html .= '<textarea rows="5" name="tb_testimonial" >'.wp_kses_post( stripcslashes( $katb_testimonial ) ).'</textarea>';
			} else {
				$input_html .= '<textarea rows="5" name="tb_testimonial" ></textarea>';
			}
			
			
			if ( $katb_options['katb_show_html_content'] == TRUE || $katb_options['katb_show_html_content'] == 1 ) {
				$input_html .= '<p>HTML '.esc_html__('Allowed','testimonial-basics').' : <code>a p br i em strong q h1-h6</code></p>';
			}
	
			if ( $katb_options['katb_use_captcha'] == TRUE || $katb_options['katb_use_captcha'] == 1 ) {
				$input_html .= '<div class="katb_captcha">';
					if( $katb_options['katb_use_color_captcha_2'] == TRUE || $katb_options['katb_use_color_captcha_2'] == 1 ) {
						$input_html .= katb_color_captcha_2();
					} elseif ( $katb_options['katb_use_color_captcha'] == TRUE || $katb_options['katb_use_color_captcha'] == 1 ) {
						$input_html .= '<img src="'.plugin_dir_url(__FILE__).'katb_captcha_color.php" alt="Verification Captcha" />';
					} else {
						$input_html .= '<img src="'.plugin_dir_url(__FILE__).'katb_captcha_bw.php" alt="Verification Captcha" />';
					}
					$input_html .= '<input type="text" id="verify_main" name="verify" value="'.$captcha_label.'" onclick="this.select();" />';
				$input_html .= '</div>';
				
			}
			$input_html .= '<input type="hidden" name="katb_form_no" value="'.$katb_input_form_no.'">';
			$input_html .= '<input class="katb_submit" type="submit" name="katb_submitted" value="'.esc_attr( $submit_label ).'" />';
			$input_html .= '<input class="katb_reset" type="submit" name="katb_reset" value="'.esc_attr( $reset_label ).'" />';
			$input_html .= wp_nonce_field('katb_nonce_1','katb_main_form_nonce',false,false);
		
		$input_html .= '</form>';
		$input_html .= '<div class="katb_clear_fix"></div><p>'.esc_attr( $required_label ).'</p>';
		if ( $katb_options['katb_show_gravatar_link'] == 1 ) {
		
			$input_html .= '<p>'.esc_html__('Add a photo? ','testimonial-basics');
				$input_html .= '<a href="https://en.gravatar.com/" title="Gravatar Site" target="_blank" >';
					$input_html .= '<img class="gravatar_logo" src="'.plugin_dir_url(__FILE__).'Gravatar80x16.jpg" alt="Gravatar Website" title="Gravatar Website" />';
				$input_html .= '</a>';
			$input_html .= '</p>';
		
		}
	$input_html .= '</div>';

	return $input_html;
}
add_shortcode('katb_input_testimonials', 'katb_display_input_form');

/**
 * This is the initial function call to display the testimonials in the content area.
 * 
 * @param boolean $use_formatted_display yes or no
 * @param boolean $use_schema yes or no
 * @param string $katb_tnumber total number of testimonials
 * @param array $katb_tdata array of testimonial data
 * @param boolean $katb_rotate yes or no
 * @param string $layout top meta or bottom meta
 * @param string $group_name group name from shortcode
 * 
 * @uses katb_get_options() user options for plugin from katb_functions.php
 * @uses katb_company_aggregate_display() displays summary of testimonials from this file
 * @uses katb_validate_gravatar() checks for valid gravatar from katb_functions.php
 * @uses katb_setup_popup() setups the popup from this file
 * @uses katb_testimonial_wrap_div() sets up div wrap for options from this file
 * @uses katb_meta_top() supplies top meta string if required from this file
 * @uses katb_insert_gravatar () returns gravatar set up from this file
 * @uses katb_testimonial_excerpt_filter() excerpt for testimonial from katb_functions.php
 * @uses katb_meta_bottom () returns the bottom meta strip from this file
 * 
 * @return $html html string with content
 */

function katb_content_display( $use_formatted_display , $use_schema, $katb_tnumber, $katb_tdata, $katb_rotate, $layout, $group_name, $layout_override ) {
	
	//get user options
	global $katb_options;
	$use_ratings = intval( $katb_options['katb_use_ratings'] );
	$use_css_ratings = intval( $katb_options['katb_use_css_ratings'] );
	$use_excerpts = intval( $katb_options['katb_use_excerpts'] );
	$use_title = intval( $katb_options['katb_show_title'] );
	$use_gravatars = intval( $katb_options['katb_use_gravatars'] );
	$use_round_images = intval( $katb_options['katb_use_round_images'] );
	$use_gravatar_substitute = intval( $katb_options['katb_use_gravatar_substitute'] );
	$gravatar_size = intval( $katb_options['katb_gravatar_size'] );
	$company_name = sanitize_text_field( $katb_options['katb_schema_company_name'] );
	$company_website = esc_url( $katb_options['katb_schema_company_url'] );
	$display_company = intval( $katb_options['katb_schema_display_company'] );
	$display_aggregate = intval( $katb_options['katb_schema_display_aggregate'] );
	$display_reviews = intval( $katb_options['katb_schema_display_reviews'] );
	$use_group_name_for_aggregate = intval( $katb_options['katb_use_group_name_for_aggregate'] );
	$custom_aggregate_name = sanitize_text_field( $katb_options['katb_custom_aggregate_review_name'] );
	$use_individual_group_name = intval( $katb_options['katb_individual_group_name'] );
	$custom_individual_name = sanitize_text_field( $katb_options['katb_individual_custom_name'] );
	$katb_height = intval( $katb_options['katb_rotator_height'] );
	$katb_speed = intval( $katb_options['katb_rotator_speed'] );
	$katb_transition = sanitize_text_field( $katb_options['katb_rotator_transition'] );
	
	//set up constant height option for rotated testimonials
	if( $katb_rotate == 1 && $katb_height != 'variable') {
		$katb_height_option = 'style="min-height:'.esc_attr( $katb_height ).'px;overflow:hidden;"';
		$katb_height_outside = $katb_height + 20;
		$katb_height_option_outside = 'style="min-height:'.esc_attr( $katb_height_outside ).'px;overflow:hidden;"';
	} else {
		$katb_height_option = '';
		$katb_height_option_outside = '';
	}
	
	//apply layout overide if applicable
	if ( $layout_override == '0' ) {
		//don't change the default
	} elseif( $layout_override == '1' ) {
		$layout = 'Top Meta';
		$use_formatted_display = '0';
	} elseif( $layout_override == '2' ) {
		$layout = 'Bottom Meta';
		$use_formatted_display = '0';
	} elseif( $layout_override == '3' ) {
		$layout = 'Side Meta';
		$use_formatted_display = '0';
	} elseif( $layout_override == '4' ) {
		$layout = 'Top Meta';
		$use_formatted_display = '1';
	} elseif( $layout_override == '5' ) {
		$layout = 'Bottom Meta';
		$use_formatted_display = '1';
	} elseif( $layout_override == '6' ) {
		$layout = 'Side Meta';
		$use_formatted_display = '1';
	}
	
	//If we are not displaying anything turn off the schema
	if( $display_company == 0 && $display_aggregate == 0 && $display_reviews == 0 ){$use_schema = 0;}
	
	$html = '';
	
	// Set up the schema wrap, company summary, and aggregate sumary
	if( $use_schema == 1 ) {
		
		$html .= '<div itemscope itemtype="http://schema.org/Organization">';
		
		$html .= katb_company_aggregate_display( $use_formatted_display , $group_name , $layout );
			
	}
	
	//Set up the wrap for all testimonials...lots of code but only one div wrap
	if( $use_schema == 1 && $display_reviews != 1 ) {
		// do not display any individual reviews
	} else {
		//display individual reviews
		if( $katb_rotate == 1 ) {

			if( $use_formatted_display == 1 ) {
				if( $layout == "Side Meta"){
					$html .= '<div '.$katb_height_option_outside.' class="katb_test_wrap_side_meta katb_rotate" data-katb_speed="'.esc_attr( $katb_speed ).'" data-katb_transition="'.esc_attr( $katb_transition ).'">';
				} else {
					$html .= '<div '.$katb_height_option_outside.' class="katb_test_wrap katb_rotate" data-katb_speed="'.esc_attr( $katb_speed ).'" data-katb_transition="'.esc_attr( $katb_transition ).'">';
				}
			} else {
				if( $layout == "Side Meta"){
					$html .= '<div '.$katb_height_option_outside.' class="katb_test_wrap_basic_side_meta katb_rotate" data-katb_speed="'.esc_attr( $katb_speed ).'" data-katb_transition="'.esc_attr( $katb_transition ).'">';
				} else {
					$html .= '<div '.$katb_height_option_outside.' class="katb_test_wrap_basic katb_rotate" data-katb_speed="'.esc_attr( $katb_speed ).'" data-katb_transition="'.esc_attr( $katb_transition ).'">';
				}
			}
			
		} else {
			
			if( $use_formatted_display == 1 ) {
				if( $layout == "Side Meta"){
					$html .= '<div class="katb_test_wrap_side_meta">';
				} else {
					$html .= '<div class="katb_test_wrap">';
				}	
			} else {
				if( $layout == "Side Meta"){
					$html .= '<div class="katb_test_wrap_basic_side_meta">';
				} else {
					$html .= '<div class="katb_test_wrap_basic">';
				}			
			}
			
		}
		
		//Display Individual Testimonials
		for ( $i = 0 ; $i < $katb_tnumber; $i++ ) {
			
			//if gravatars are enabled, check for valid avatar
			if ( $use_gravatars == 1 && $use_gravatar_substitute != 1 ) {
				 $has_valid_avatar = katb_validate_gravatar( $katb_tdata[$i]['tb_email'] ); 
			} else {
				$has_valid_avatar = 0;
			}
			//get the gravatar or photo html
			$gravatar_or_photo = katb_insert_gravatar( $katb_tdata[$i]['tb_pic_url'] , $gravatar_size , $use_gravatars, $use_round_images , $use_gravatar_substitute , $has_valid_avatar , $katb_tdata[$i]['tb_email'] );	
			
			//set up hidden popup if excerpt is used	
			if ( $use_excerpts == 1 ) { $html .= katb_setup_popup( $i, $katb_tdata, $has_valid_avatar  ); }
			
			//Set up the testimonial wrap div
			$html .= katb_testimonial_wrap_div( $use_formatted_display , $use_schema, $katb_rotate, $katb_height_option, $i, $layout );
				
				if( $layout == "Side Meta" ) {
					
					//left box contains the gravatar, and the meta
					$html .= '<div class="katb_left_box">';
						
						if( $gravatar_or_photo != '' ) {
							$html .= '<div class="katb_side_gravatar">'.$gravatar_or_photo.'</div>';
						}
						
						$html .= katb_meta_side( $i, $katb_tdata, $use_schema );
					
					$html .= '</div>';
					
					//right box contains the title, rating and content
					$html .= '<div class="katb_right_box">';
						
						//Set up and return html for title bar
						$html .= katb_insert_title( $use_schema , $use_title , $katb_tdata , $i , $use_individual_group_name , $custom_individual_name );
						
						//Set up and return html for ratings
						$html .= katb_insert_rating( $use_schema , $use_ratings , $use_css_ratings , $katb_tdata, $i );
						
						//display the testimonial, note $gravatar_or_photo passed variable set to ''
						$html .= katb_insert_content( $use_excerpts , $use_schema , $use_formatted_display, $layout , intval( $katb_options['katb_excerpt_length'] ), '' , $i , $katb_tdata );

					$html .= '</div>';
					
				} else {
				
					//Set up and return array for title bar
					$html .= katb_insert_title( $use_schema , $use_title , $katb_tdata , $i , $use_individual_group_name , $custom_individual_name );
					
					//Set up and return html for ratings
					$html .= katb_insert_rating( $use_schema , $use_ratings , $use_css_ratings , $katb_tdata, $i );
					
					//dispay top meta
					if( $layout == 'Top Meta' ) { $html .= katb_meta_top( $i, $katb_tdata, $use_schema ); }
					
					//display the testimonial
					$html .= katb_insert_content( $use_excerpts , $use_schema , $use_formatted_display, $layout , intval( $katb_options['katb_excerpt_length'] ),  $gravatar_or_photo , $i , $katb_tdata );
				
					//display bottom meta
					if( $layout == 'Bottom Meta' )  { $html .=  katb_meta_bottom( $i, $katb_tdata, $use_schema ); }
				
				}
			
			$html .= '</div>';// close the testimonial content wrap
			if($layout == "Side Meta" && $katb_rotate == 1 ) $html .= '</div>';//close the <div class="katb_side_meta_block katb_rotate_show">
			
		} //close i loop
		
		$html .= '</div>';//close all testimonials wrap
		
	}
	
	//close the schema
	if( $use_schema == 1 ) {
	
		$html .= '</div>';//close itemscope itemtype="http://schema.org/Organization"
	}
	
	return $html;
}

/**
 * This function sets up the company and aggregate display and is only used for 
 * if schema is selected and if the user wants to display them.
 * 
 * @param boolean $use_formatted_display 
 * @param string $group_name group name to use for search of testimonials
 * 
 * @uses katb_get_options() from katb_functions.php
 * @uses katb_schema_aggregate_markup() from this file
 * 
 */
 
 function katb_company_aggregate_display( $use_formatted_display , $group_name , $layout ) {
 	
	//get user options
	global $katb_options;
	//$katb_options = katb_get_options();
	$company_name = sanitize_text_field( $katb_options['katb_schema_company_name'] );
	$company_website = esc_url( $katb_options['katb_schema_company_url'] );
	$display_company = intval( $katb_options['katb_schema_display_company'] );
	$display_aggregate = intval( $katb_options['katb_schema_display_aggregate'] );
	$display_reviews = intval( $katb_options['katb_schema_display_reviews'] );
	$use_group_name_for_aggregate = intval( $katb_options['katb_use_group_name_for_aggregate'] );
	$custom_aggregate_name =  sanitize_text_field( $katb_options['katb_custom_aggregate_review_name'] );
	$use_ratings = intval( $katb_options['katb_use_ratings'] );
	
	$html = '';
	
	if( $layout == "Side Meta") { $side_meta_class = '_side_meta'; } else { $side_meta_class = ''; }
	
	if( $display_company != 1 && $display_aggregate != 1 ) {
			
			//if company and aggregate info are not displayed use dummy classes to elimate css formatting
			$html .= '<div class="katb_no_display_wrap">';
				$html .= '<div class="katb_no_display_box">';
			
	} else {
				
		if( $use_formatted_display == 1 ) {
			
			$html .= '<div class="katb_schema_summary_wrap'.$side_meta_class.'">';
				$html .= '<div class="katb_schema_summary_box'.$side_meta_class.'">';
		
		} else {
			
			$html .= '<div class="katb_schema_summary_wrap_basic'.$side_meta_class.'">';
				$html .= '<div class="katb_schema_summary_box_basic'.$side_meta_class.'">';
							
		}
				
	}

					if( $display_company != 1 ) {
						$html .= '<meta content="'.stripcslashes( esc_attr( $company_name ) ).'" itemprop="name" />';
						$html .= '<meta content="'.stripcslashes( esc_url($company_website) ).'" itemprop="url" />';
					} else {
						$html .= '<div class="katb_schema_company_wrap'.$side_meta_class.'">';
							$html .= '<span class="katb_company_name" itemprop="name">'.esc_html__('Company','testimonial-basics').' : '.stripcslashes( esc_attr( $company_name ) ).'</span><br/>';
							$html .= '<span class="katb_company_website">'.esc_html__('Website','testimonial-basics').' : <a class="company_website" href="'.stripcslashes( esc_url( $company_website ) ).'" title="Company Website" target="_blank" itemprop="url">'.$company_website.'</a></span>';
						$html .= '</div>';	
					}

					if( $use_ratings == 1 ){
						//Call function to display the aggregate rating
						$html .= katb_schema_aggregate_markup( $display_aggregate , $group_name, $use_group_name_for_aggregate , $custom_aggregate_name , $layout );
					}
					
			
				$html .= '</div>';
			$html .= '</div>';
			
	return $html;
			
 }

/**
 * This helper sets up the testimonial wrap div. There are eight options so 
 * I thought it better to put it in a helper function.
 * 
 * @param boolean $use_formatted_display
 * @param boolean $use_schema
 * @param boolean $katb_rotate
 * @param string $katb_height_option either 'variable' or a height in pixels
 * @param string $i is the counter tat is used to loop through the testimonials
 * 
 * @return $html string div wrapper
 * 
 */
function katb_testimonial_wrap_div( $use_formatted_display , $use_schema , $katb_rotate, $katb_height_option, $i, $layout ){
	
	if( $layout == "Side Meta" ) { $layout_class = '_side_meta';} else { $layout_class = ''; }
	
	$html = '';
	
	if( $katb_rotate == 1 && $use_formatted_display == 1 && $use_schema == 1 ) {
		
		if( $i == 0 ) {
			if( $layout == "Side Meta" ) {
				$html .= '<div class="katb_side_meta_block katb_rotate_show">';
				$html .= '<div '.$katb_height_option.' class="katb_test_box_side_meta" itemscope itemtype="http://schema.org/Review">';
			} else {
				$html .= '<div '.$katb_height_option.' class="katb_test_box katb_rotate_show" itemscope itemtype="http://schema.org/Review">';
			}		
		} else {
			if( $layout == "Side Meta" ) {
				$html .= '<div class="katb_side_meta_block katb_rotate_noshow">';
				$html .= '<div '.$katb_height_option.' class="katb_test_box_side_meta" itemscope itemtype="http://schema.org/Review">';
			} else {
				$html .= '<div '.$katb_height_option.' class="katb_test_box katb_rotate_noshow" itemscope itemtype="http://schema.org/Review">';
			}
		}
		
	} elseif( $katb_rotate == 1 && $use_formatted_display != 1 && $use_schema == 1 ) {
		
		if( $i == 0 ) {
			if( $layout == "Side Meta" ) {
				$html .= '<div class="katb_side_meta_block katb_rotate_show">';
				$html .= '<div '.$katb_height_option.' class="katb_test_box_basic_side_meta" itemscope itemtype="http://schema.org/Review">';
			} else {
				$html .= '<div '.$katb_height_option.' class="katb_test_box_basic katb_rotate_show" itemscope itemtype="http://schema.org/Review">';
			}
		} else {
			if( $layout == "Side Meta" ) {
				$html .= '<div class="katb_side_meta_block katb_rotate_noshow">';
				$html .= '<div '.$katb_height_option.' class="katb_test_box_basic_side_meta" itemscope itemtype="http://schema.org/Review">';
			} else {
				$html .= '<div '.$katb_height_option.' class="katb_test_box_basic katb_rotate_noshow" itemscope itemtype="http://schema.org/Review">';
			} 
		}
		
	} elseif( $katb_rotate == 1 && $use_formatted_display != 1 && $use_schema != 1 ) {
		
		if( $i == 0 ) {
			if( $layout == "Side Meta" ) {
				$html .= '<div class="katb_side_meta_block katb_rotate_show">';
				$html .= '<div '.$katb_height_option.' class="katb_test_box_basic_side_meta">';
			} else {
				$html .= '<div '.$katb_height_option.' class="katb_test_box_basic katb_rotate_show">';
			}
		} else {
			if( $layout == "Side Meta" ) {
				$html .= '<div class="katb_side_meta_block katb_rotate_noshow">';
				$html .= '<div '.$katb_height_option.' class="katb_test_box_basic_side_meta">';
				} else {
					$html .= '<div '.$katb_height_option.' class="katb_test_box_basic katb_rotate_noshow">';
				} 
		}
	
	} elseif( $katb_rotate == 1 && $use_formatted_display == 1 && $use_schema != 1 ) {
		
		if( $i == 0 ) {
			if( $layout == "Side Meta" ) {
				$html .= '<div class="katb_side_meta_block katb_rotate_show">';
				$html .= '<div '.$katb_height_option.' class="katb_test_box_side_meta">';
			} else {
				$html .= '<div '.$katb_height_option.' class="katb_test_box katb_rotate_show">';
			}	 
		} else {
			if( $layout == "Side Meta" ) {
				$html .= '<div class="katb_side_meta_block katb_rotate_noshow">';
				$html .= '<div '.$katb_height_option.' class="katb_test_box_side_meta">';
			} else {
				$html .= '<div '.$katb_height_option.' class="katb_test_box katb_rotate_noshow">';
			}
		}
			
	} elseif( $katb_rotate != 1 && $use_formatted_display == 1 && $use_schema == 1 ) {
		
		$html .= '<div class="katb_test_box'.$layout_class.'" itemscope itemtype="http://schema.org/Review">';
		
	} elseif( $katb_rotate != 1 && $use_formatted_display != 1 && $use_schema == 1 ) {
		
		$html .= '<div class="katb_test_box_basic'.$layout_class.'" itemscope itemtype="http://schema.org/Review">';
		
	} elseif( $katb_rotate != 1 && $use_formatted_display != 1 && $use_schema != 1 ) {
		
		$html .= '<div class="katb_test_box_basic'.$layout_class.' ">';
		
	} elseif( $katb_rotate != 1 && $use_formatted_display == 1 && $use_schema != 1 ) {
		
		$html .= '<div class="katb_test_box'.$layout_class.' ">';
	}
	
	return $html;
	
}

/**
 * This function is a helper function to inset a gravatar/image if one exists
 * 
 * @param string $image_url if uploaded image, this is the url
 * @param string $gravatar_size user option
 * @param boolean $use_gravatars user option 
 * @param boolean $use_gravatar_substitute user option
 * @param boolean $has_valid_avatar result of avatar check 
 * @param string $email address of author
 * 
 * @return $html gravatar insert html
 */
 function katb_insert_gravatar( $image_url , $gravatar_size , $use_gravatars , $use_round_images , $use_gravatar_substitute, $has_valid_avatar , $email ){
	//If uploaded photo use that, else use gravatar if selected and available
	if( $use_round_images == 1 ){ $round_class = '_round_image'; } else { $round_class = ''; }
	
	$html = '';
	
	if ( $image_url != '' )  {
		$html .= '<span class="katb_avatar'.$round_class.'" style="width:'.esc_attr( $gravatar_size ).'px; height:auto;" ><img class="avatar" src="'.esc_url( $image_url ).'" alt="Author Picture" /></span>';
	} elseif ( $use_gravatars == 1 && $has_valid_avatar == 1 ) {
		$html .= '<span class="katb_avatar'.$round_class.'" style="width:'.esc_attr( $gravatar_size ).'px; height:auto;" >'.get_avatar( $email , $size = $gravatar_size ).'</span>';
	} elseif ( $use_gravatars == 1 && $use_gravatar_substitute == 1 ) {
		$html .= '<span class="katb_avatar'.$round_class.'" style="width:'.esc_attr( $gravatar_size ).'px; height:auto;" >'.get_avatar( $email , $size = $gravatar_size ).'</span>';
	}
	
	return $html;
}
 
/**
 * This function is a helper function to set up the title bar for the testimonial
 * 
 * @param boolean $use_schema user option
 * @param boolean $use_title user option 
 * @param boolean $use_ratings user option
 * @param array $katb_tdata testimonial data 
 * @param string $custom_individual_name user option
 * 
 * @return $html which is the html for the for title bar
 */
 function katb_insert_title( $use_schema , $use_title , $katb_tdata , $i , $use_individual_group_name, $custom_individual_name ){
	
	$html = '';
	
	if( $use_schema == 1 || $use_title == 1 ) {
					
		$html .= '<div class="katb_title_bar">';
		
			//get group name for testimonial
			$individual_group_name = $katb_tdata[$i]['tb_group'];
				
			if( $use_schema !=1 ) {
				if( $use_individual_group_name == 1 && $individual_group_name != '' ) {
					$html .= '<span class="individual_itemreviewed" >'.stripcslashes( esc_attr( $individual_group_name ) ).'</span>&nbsp;';
				} elseif( $custom_individual_name != '' ) {
					$html .= '<span class="individual_itemreviewed" >'.stripcslashes( esc_attr( $custom_individual_name ) ).'</span>&nbsp;';
				}
						
			} else {
				if( $use_individual_group_name == 1 && $individual_group_name != '' ) {
					$html .= '<span class="individual_itemreviewed" itemprop="name">'.stripcslashes( esc_attr( $individual_group_name ) ).'</span>&nbsp;';
					$html .= '<div itemprop="itemReviewed" itemscope itemtype="http://schema.org/Thing">';
					$html .= '<meta itemprop="name" content="'.stripcslashes( esc_attr( $individual_group_name ) ).'"></div>';
				} elseif( $custom_individual_name != '' ) {
					$html .= '<span class="individual_itemreviewed" itemprop="name">'.stripcslashes( esc_attr( $custom_individual_name ) ).'</span>&nbsp;';
					$html .= '<div itemprop="itemReviewed" itemscope itemtype="http://schema.org/Thing">';
					$html .= '<meta itemprop="name" content="'.stripcslashes( esc_attr( $custom_individual_name ) ).'"></div>';
				}
			}
				
		$html .= '</div>';
			
	} 
		
	return $html;
}

/**          RATING HTML HELPER
 * This function is a helper function to set up the rating html
 * 
 * @param boolean $use_schema user option
 * @param boolean $use_ratings user option
 * @param boolean $use_css_ratings user option
 * @param array $katb_tdata testimonial data
 * @param integer $i where we are in the $katb_tdata loop
 * 
 * @return $html_rteturn which is the return html 
 */
 function katb_insert_rating( $use_schema , $use_ratings , $use_css_ratings , $katb_tdata, $i ){
	
	$html = '';	$html2=''; $html3 = ''; $html_meta = '';
	
	if( $use_ratings == 1 ) {
					
		$html2 .= '<div class="katb_rating">';

			//Display the rating if selected
			if ( $use_ratings == 1 ) { 

				$rating = $katb_tdata[$i]['tb_rating'];
				if( $rating == '' ) { $rating = 0; }
				
				if( $rating > 0 ) {
					
					if( $use_css_ratings == 1 ) {
						$html .= '<span class="katb_css_rating">';
						$html .= katb_css_rating( $rating );
						$html .= '</span>';
					} else {
						$html .= '<span class="rateit katb_display_rating" data-rateit-value="'.esc_attr( $rating ).'" data-rateit-ispreset="true" data-rateit-readonly="true"></span>';	
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
 * This function is a helper function to set up the content html for the testimonial
 * 
 * @param boolean $use_excerpts user option
 * @param boolean $use_formatted_display user option 
 * @param boolean $layout user option
 * @param integer $length user option, length of excerpt in characters
 * @param array $katb_tdata testimonial data 
 * @param string $gravatar_or_photo html for inserting gravatar or photo
 * @param integer $i where we are in the testimonial loop
 * @return $html which is the html for the for title bar
 */
function katb_insert_content( $use_excerpts , $use_schema , $use_formatted_display, $layout , $length,  $gravatar_or_photo , $i , $katb_tdata ){
	
	$html = '';
	
	//display the testimonial
	if ( $use_excerpts == 1 ) {
			
		$text = wpautop( wp_kses_post( stripcslashes($katb_tdata[$i]['tb_testimonial'] ) ) );
		$classID = 'katb_content_test_'.sanitize_text_field( $katb_tdata[$i]['tb_id'] );
		$text = katb_testimonial_excerpt_filter( $length , $text , $classID );
		
		if( $use_formatted_display == 1 && $use_schema == 1 ) {
			$html .= '<div class="katb_test_text" itemprop="reviewBody" >'.$gravatar_or_photo.$text.'</div>';
		} elseif( $use_formatted_display == 1 && $use_schema != 1 ) {
			$html .= '<div class="katb_test_text" >'.$gravatar_or_photo.$text.'</div>'; 
		} elseif( $use_formatted_display != 1 && $use_schema == 1 ) {
			$html .= '<div class="katb_test_text_basic" itemprop="reviewBody">'.$gravatar_or_photo.$text.'</div>'; 
		} elseif( $use_formatted_display != 1 && $use_schema != 1 ) {
			$html .= '<div class="katb_test_text_basic" >'.$gravatar_or_photo.$text.'</div>'; 
		}
			
	} else {
		
		if( $use_formatted_display == 1 && $use_schema == 1 ) {
			$html .= '<div class="katb_test_text" itemprop="reviewBody" >'.$gravatar_or_photo.wp_kses_post( wpautop( stripcslashes($katb_tdata[$i]['tb_testimonial'] ) ) ).'</div>';
		} elseif( $use_formatted_display == 1 && $use_schema != 1 ) {
			 $html .= '<div class="katb_test_text" >'.$gravatar_or_photo.wp_kses_post( wpautop( stripcslashes($katb_tdata[$i]['tb_testimonial'] ) ) ).'</div>';
		} elseif( $use_formatted_display != 1 && $use_schema == 1 ) {
			$html .= '<div class="katb_test_text_basic" itemprop="reviewBody">'.$gravatar_or_photo.wp_kses_post( wpautop( stripcslashes( $katb_tdata[$i]['tb_testimonial'] ) ) ).'</div>'; 
		} elseif( $use_formatted_display != 1 && $use_schema != 1 ) {
			$html .= '<div class="katb_test_text_basic" >'.$gravatar_or_photo.wp_kses_post( wpautop( stripcslashes( $katb_tdata[$i]['tb_testimonial'] ) ) ).'</div>';
		}	
				
	}
	
	return $html;
	
}

/**
 * This function sets up the html string for the popup testimonial if called
 * 
 * @param string $i testimonial counter
 * @param array $katb_tdata testimonial data
 * @param boolean $has_valid_avatar result of avatar check
 * 
 * @uses katb_get_options() user options from katb_functions.php
 * @uses katb_meta_top() top meta string from this file
 * @uses katb_meta_bottom() bottom meta string from this file
 * @uses katb_insert_gravatar() 
 * 
 * @return $popup_html string of testimonial used for popup
 */
function katb_setup_popup ( $i, $katb_tdata, $has_valid_avatar ) {

	//get user options
	//$katb_options = katb_get_options();
	global $katb_options;
	$use_ratings = intval( $katb_options['katb_use_ratings'] );
	$use_css_ratings = intval( $katb_options['katb_use_css_ratings'] );
	$use_gravatars = intval( $katb_options['katb_use_gravatars'] );
	$use_round_images = intval( $katb_options['katb_use_round_images'] );
	$use_gravatar_substitute = intval( $katb_options['katb_use_gravatar_substitute'] );
	$gravatar_size = intval( $katb_options['katb_gravatar_size'] );
	$use_title = intval( $katb_options['katb_show_title'] );
	$use_individual_group_name = intval( $katb_options['katb_individual_group_name'] );
	$custom_individual_name = sanitize_text_field( $katb_options['katb_individual_custom_name'] );
	$layout = sanitize_text_field( $katb_options['katb_layout_option'] );
	$group_name = sanitize_text_field( $katb_tdata[$i]['tb_group'] );
	$use_schema = 0;//used to ensure no schema markup in meta
	$schema_on_for_title = intval( $katb_options['katb_use_schema'] );//used to decide on title display
	
	$popup_html = '';
	
	$popup_html .= '<div class="katb_topopup" id="katb_content_test_'.sanitize_text_field( $katb_tdata[$i]['tb_id'] ).'">';
	
		$popup_html .= '<div class="katb_close"></div>';
		
		$popup_html .= '<div class="katb_popup_wrap katb_content">';
		
			if( $use_title == 1 || $use_ratings == 1 ) {
				
				$popup_html .= '<div class="katb_title_bar">';
					
					//title for testimonial
					if( $use_title == 1 ) {
							
						//get group name for testimonial
						$individual_group_name = $katb_tdata[$i]['tb_group'];

						if( $use_individual_group_name == 1 && $individual_group_name != '' ) {
							$popup_html .= '<span class="individual_itemreviewed" >'.stripcslashes( esc_attr( $individual_group_name ) ).'</span>&nbsp;';
						} elseif( $custom_individual_name != '' ) {
							$popup_html .= '<span class="individual_itemreviewed" >'.stripcslashes( esc_attr( $custom_individual_name ) ).'</span>&nbsp;';
						}
							
					} //close use title
						
					//Display the rating if selected
					if ( $use_ratings == 1 ) { 
				
						$rating = $katb_tdata[$i]['tb_rating'];
						if( $rating == '' ) { $rating = 0; }
						
						if($rating > 0 ) {
						
							if( $use_css_ratings != 1 ) {
								$popup_html .= '<span class="rateit katb_display_rating" data-rateit-value="'.esc_attr( $rating ).'" data-rateit-ispreset="true" data-rateit-readonly="true"></span><br/>';
							} else {
								$popup_html .= '<span class="katb_css_rating">';
								$popup_html .= katb_css_rating( $rating );
								$popup_html .= '</span>';
							}
						
						}	
						
					}
						
				$popup_html .= '</div>';
						
			}
					
			if( $layout == 'Top Meta' || $layout == 'Side Meta' ) { $popup_html .= katb_meta_top( $i, $katb_tdata, $use_schema ); }
			
			$gravatar_or_photo = katb_insert_gravatar( $katb_tdata[$i]['tb_pic_url'] , $gravatar_size , $use_gravatars , $use_round_images , $use_gravatar_substitute, $has_valid_avatar , $katb_tdata[$i]['tb_email'] );
			
			$popup_html .= '<div class="katb_test_text_basic" >'.$gravatar_or_photo.wp_kses_post( wpautop( stripcslashes( $katb_tdata[$i]['tb_testimonial'] ) ) ).'</div>';
			
			if( $layout == 'Bottom Meta' )  { $popup_html .=  katb_meta_bottom( $i, $katb_tdata, $use_schema ); }
	
		$popup_html .= '</div>';
		
	$popup_html .= '</div>';	
		
	$popup_html .= '<div class="katb_loader"></div>';
	
	$popup_html .= '<div class="katb_excerpt_popup_bg" id="katb_content_test_'.sanitize_text_field( $katb_tdata[$i]['tb_id'] ).'_bg"></div>';
	
	return $popup_html;	
}

/**
 * This function sets up the html string for the aggregate markup
 * 
 * The database is queried for the group name to get the average rating, the 
 * review count with ratings and the total review count. It then sets up the 
 * return string based on whether or not the summary is to be dispayed or hidden with
 * meta tags
 * 
 * @param boolean $display_aggregate
 * @param string $group_name
 * @param boolean $use_group_name_for_aggregate
 * @param string $custom_aggregate_name
 * 
 * @return $agg_html string of html
 */
function katb_schema_aggregate_markup ( $display_aggregate , $group_name, $use_group_name_for_aggregate , $custom_aggregate_name , $layout ) {

	//setup database table
	global $wpdb,$tablename;
	$tablename = $wpdb->prefix.'testimonial_basics';
	
	$katb_options = katb_get_options();
	$use_css_ratings = $katb_options['katb_use_css_ratings'];
	
	if( $layout == "Side Meta" ){ $side_meta_class =  "_side_meta"; } else { $side_meta_class = ''; }
	
	$agg_html = '';
	
	//query database 
	if( $group_name != 'all' ) {
	
		$aggregate_data = $wpdb->get_results( " SELECT `tb_rating` FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group_name' ",ARRAY_A);
		$aggregate_total_approved = $wpdb->num_rows;
			
	} else {
		
		$aggregate_data = $wpdb->get_results( " SELECT `tb_rating` FROM `$tablename` WHERE `tb_approved` = '1' ",ARRAY_A);
		$aggregate_total_approved = $wpdb->num_rows;
						
	}
		
	$count = 0;
	$sum = 0;
	for ( $j = 0 ; $j < $aggregate_total_approved; $j++ ) {
		//wp_die($aggregate_data[j]['tb_rating']);
		$rating = (float) $aggregate_data[$j]['tb_rating'];
		if( $rating != '' && $rating > 0 ) {
			$count = $count + 1;
			$sum = $sum + (float)$aggregate_data[$j]['tb_rating'] ;
		}			
	}
	$total_votes = $count;
	
	if( $count == 0 ) {
		$avg_rating = 0;
	} else {
		$avg_rating = round( $sum / $count, 1 );
	}
	
	if( $avg_rating == 0 ) {
		
		$rounded_avg_rating = 0;
		
	} else {
		
		//round to nearest 0.5 out of 5
		if( $avg_rating >= ceil( $avg_rating ) - 0.25 ) {
			$rounded_avg_rating = ceil( $avg_rating );
		} elseif( $avg_rating >= ceil( $avg_rating ) - 0.75 ) {
			$rounded_avg_rating = ceil( $avg_rating ) - 0.50;
		} else {
			$rounded_avg_rating = floor( $avg_rating );
		}
		
	}
	
	if( $count > 1 && $avg_rating > 0 && $rounded_avg_rating > 0 ) {
		
		if( $display_aggregate != 1 ) {
					
			$agg_html .= '<div class="katb_no_display" itemscope itemtype="http://data-vocabulary.org/Review-aggregate">';
				
				if( $use_group_name_for_aggregate == 1 && $group_name != 'all' ) {
					$agg_html .= '<meta content="'.stripcslashes( esc_attr( $group_name ) ).'" itemprop="itemreviewed" />';
				} else if( $use_group_name_for_aggregate != 1 && $custom_aggregate_name != '' ) {
					$agg_html .= '<meta content="'.stripcslashes( esc_attr( $custom_aggregate_name ) ).'" itemprop="itemreviewed" />';
				} else {
					$agg_html .= '<meta content="'.esc_html__('All Reviews','testimonial-basics').'" itemprop="itemreviewed" />';
				}
			
				$agg_html .= '<span itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">';
					$agg_html .= '<meta content="'.stripcslashes( esc_attr( $avg_rating ) ).'" itemprop="average" />';
					$agg_html .= '<meta content="0" itemprop="worst" />';
					$agg_html .= '<meta content="5" itemprop="best" />';
				$agg_html .= '</span>';
				$agg_html .= '<meta content="'.stripcslashes( esc_attr( $total_votes ) ).'" itemprop="votes" />';
				$agg_html .= '<meta content="'.stripcslashes( esc_attr( $aggregate_total_approved ) ).'" itemprop="count" />';
					  		
			$agg_html .= '</div>';
			
		} else {
			
			$agg_html .= '<div class="katb_aggregate_wrap'.$side_meta_class.'" itemscope itemtype="http://data-vocabulary.org/Review-aggregate">';
				
				$agg_html .= '<span class="aggregate_review_label">'.esc_html__( 'Aggregate Review','testimonial-basics' ).' :</span> ';
				
				if( $use_group_name_for_aggregate == 1 && $group_name != 'all' ) {
					$agg_html .= '<span class="aggregate_itemreviewed" itemprop="itemreviewed">'.stripcslashes( esc_attr( $group_name ) ).'</span><br/>';
				} else if( $use_group_name_for_aggregate != 1 && $custom_aggregate_name != '' ) {
					$agg_html .= '<span class="aggregate_itemreviewed" itemprop="itemreviewed">'.stripcslashes( esc_attr( $custom_aggregate_name ) ).'</span><br/>';
				} else {
					$agg_html .= '<span class="aggregate_itemreviewed" itemprop="itemreviewed">'.esc_html__('All Reviews','testimonial-basics').'</span><br/>';	
				}
				
				if( $use_css_ratings != 1 ) {
					$agg_html .= '<span class="rateit katb_display_rating" data-rateit-value="'.stripcslashes( esc_attr( $rounded_avg_rating ) ).'" data-rateit-ispreset="true" data-rateit-readonly="true"></span>';
				} else {
					$agg_html .= '<span class="katb_css_rating katb_aggy">';
					$agg_html .= katb_css_rating( $rounded_avg_rating );
					$agg_html .= '</span>';
				}
				
				$agg_html .= ' - ';
				$agg_html .= '<span itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">';
					$agg_html .= '<span class="average_number" itemprop="average">'.stripcslashes( esc_attr( $avg_rating ) ).'</span>';
					$agg_html .= '<span class="out_of">&nbsp;'.esc_html__('out of','testimonial-basics').'&nbsp;</span>';
					$agg_html .= '<span class="best" itemprop="best">5</span>';
				$agg_html .= '</span>';
				$agg_html .= ', ';
				if( $total_votes == 1 ) {
					$agg_html .= '<span class="total_votes" itemprop="votes">'.stripcslashes( esc_attr( $total_votes ) ).'&nbsp;</span>';
					$agg_html .= '<span class="votes_label">'.esc_html__('vote','testimonial-basics').'</span>';
				} else if ( $total_votes == 0 ) {
					$agg_html .= '<span class="votes_label">'.esc_html__('not rated','testimonial-basics').'</span>';
				} else {
					$agg_html .= '<span class="total_votes" itemprop="votes">'.stripcslashes( esc_attr( $total_votes ) ).'&nbsp;</span>';
					$agg_html .= '<span class="votes_label">'.esc_html__('votes','testimonial-basics').'</span>';
				}
				$agg_html .= ', ';
				if( $aggregate_total_approved == 0 ) {
					$agg_html .= '<span class="reviews_label">'.esc_html__('no reviews yet','testimonial-basics').'</span>';
				} elseif( $aggregate_total_approved == 1 ) {
					$agg_html .= '<span class="total_reviews">'.stripcslashes( esc_attr( $aggregate_total_approved ) ).'&nbsp;</span>';
					$agg_html .= '<span class="reviews_label">'.esc_html__('review','testimonial-basics').'</span>';	
				} else {
					$agg_html .= '<span class="total_reviews">'.stripcslashes( esc_attr( $aggregate_total_approved ) ).'&nbsp;</span>';
					$agg_html .= '<span class="reviews_label">'.esc_html__('reviews','testimonial-basics').'</span>';
				}

			$agg_html .= '</div>';
			
		}
	}
	
	return $agg_html;
	
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
 * @return $meta_btm html string
 */
function katb_meta_bottom( $i , $katb_tdata , $use_schema ){
	
	//get user options
	$katb_options = katb_get_options();
	
	$meta_btm = '';
	
	$meta_btm .= '<div class="katb_meta_bottom">';
		
		//author		
		if( $use_schema != 1 ) {
			$meta_btm .= '<span class="katb_author">'.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_name'] ) ).'</span>';
		} else {
			$meta_btm .= '<div itemprop="author" itemscope itemtype="http://schema.org/Person">';
			$meta_btm .= '<span class="katb_author" itemprop="name">'.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_name'] ) ).'</span></div>';
		}
			
		//date
		if ( $katb_options['katb_show_date'] == 1 ) {
			
			$katb_date = sanitize_text_field( $katb_tdata[$i]['tb_date'] );
			if( $use_schema != 1 ) {
				$meta_btm .= '<span class="katb_date">&nbsp;&nbsp;'.mysql2date(get_option( 'date_format' ), $katb_date ).'</span>';
			} else { 
				$meta_btm .= '<span class="katb_date">';
				$meta_btm .= '<meta itemprop="datePublished" content="'.mysql2date( 'Y-m-d' , $katb_date ).'">';
				$meta_btm .= '&nbsp;&nbsp;'.mysql2date( 'Y-m-d' , $katb_date ).'</span>';
			}
			
		}
		
		//location
		if ( $katb_options['katb_show_location'] == 1 && $katb_tdata[$i]['tb_location'] != '' ) {
			
			 $meta_btm .= '<span class="katb_location">&nbsp;&nbsp;'.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_location'] ) ).'</span>';
		
		}
		
		//website		
		if ( $katb_options['katb_show_website'] == 1 && $katb_tdata[$i]['tb_url'] != '' ) {
			
			$meta_btm .= '<span class="katb_website">&nbsp;&nbsp;<a href="'.esc_url( $katb_tdata[$i]['tb_url'] ).'" title="'.esc_url( $katb_tdata[$i]['tb_url'] ).'" target="_blank" >Website</a></span>';
			
		}

	$meta_btm .= '</div>';
	
	return $meta_btm;
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
 * @return $meta_side html string 
 */
function katb_meta_top( $i, $katb_tdata, $use_schema ){
	
	//get user options
	$katb_options = katb_get_options();
	
	$meta_top = '';
	
	$meta_top .= '<div class="katb_meta_top">';
		
		//author		
		if( $use_schema != 1 ) {
			$meta_top .= '<span class="katb_author">'.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_name'] ) ).'</span>';
		} else {
			$meta_top .= '<div itemprop="author" itemscope itemtype="http://schema.org/Person">';
			$meta_top .= '<span class="katb_author" itemprop="name">'.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_name'] ) ).'</span></div>';
		}
		
		//date
		if ( $katb_options['katb_show_date'] == 1 ) {
			
			$katb_date = sanitize_text_field( $katb_tdata[$i]['tb_date'] );
			if( $use_schema != 1 ) {
				$meta_top .= '<span class="katb_date">&nbsp;&nbsp;'.mysql2date(get_option( 'date_format' ), $katb_date ).'</span>';
			} else { 
				$meta_top .= '<span class="katb_date">';
				$meta_top .= '<meta itemprop="datePublished" content="'.mysql2date( 'Y-m-d' , $katb_date ).'">';
				$meta_top .= '&nbsp;&nbsp;'.mysql2date( 'Y-m-d' , $katb_date ).'</span>';
			}
			
		}
		
		//location
		if ($katb_options['katb_show_location'] == 1 && $katb_tdata[$i]['tb_location'] != '') {
			
			 $meta_top .= '<span class="katb_location">&nbsp;&nbsp;'.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_location'] ) ).'</span>';
		
		}
		
		//website		
		if ( $katb_options['katb_show_website'] == 1 && $katb_tdata[$i]['tb_url'] != '' ) {
			
			$meta_top .= '<span class="katb_website">&nbsp;&nbsp;<a href="'.esc_url( $katb_tdata[$i]['tb_url'] ).'" title="'.esc_url( $katb_tdata[$i]['tb_url'] ).'" target="_blank" >Website</a></span>';
		
		}

	$meta_top .= '</div>';
	
	return $meta_top;
}

/**
 * This function provides the meta for the left box of the side meta layout
 * for the testimonial
 * 
 * @param string $i is the testimonial count in the loop
 * @param array $katb_tdata is the testimonial data
 * @param boolean $use_schema
 * 
 * @uses katb_get_options() user options from katb_functions.php
 * 
 * @return $meta_side html string 
 */
function katb_meta_side( $i, $katb_tdata, $use_schema ){
	
	//get user options
	$katb_options = katb_get_options();
	
	$meta_side = '';
	
	$meta_side .= '<div class="katb_meta_side">';
		
		//author		
		if( $use_schema != 1 ) {
			$meta_side .= '<span class="katb_author">'.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_name'] ) ).'</span>';
		} else {
			$meta_side .= '<div itemprop="author" itemscope itemtype="http://schema.org/Person">';
			$meta_side .= '<span class="katb_author" itemprop="name">'.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_name'] ) ).'</span></div>';
		}
		
		//location
		if ($katb_options['katb_show_location'] == 1 && $katb_tdata[$i]['tb_location'] != '') {
			
			 $meta_side .= '<br/><span class="katb_location">'.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_location'] ) ).'</span>';
		
		}
		
		//website		
		if ( $katb_options['katb_show_website'] == 1 && $katb_tdata[$i]['tb_url'] != '' ) {
			
			$meta_side .= '<br/><span class="katb_website"><a href="'.esc_url( $katb_tdata[$i]['tb_url'] ).'" title="'.esc_url( $katb_tdata[$i]['tb_url'] ).'" target="_blank" >Website</a></span>';
		
		}
		
		//date
		if ( $katb_options['katb_show_date'] == 1 ) {
			
			$katb_date = sanitize_text_field( $katb_tdata[$i]['tb_date'] );
			if( $use_schema != 1 ) {
				$meta_side .= '<br/><span class="katb_date">'.mysql2date(get_option( 'date_format' ), $katb_date ).'</span>';
			} else { 
				$meta_side .= '<span class="katb_date">';
				$meta_side .= '<meta itemprop="datePublished" content="'.mysql2date( 'Y-m-d' , $katb_date ).'">';
				$meta_side .= '&nbsp;&nbsp;'.mysql2date( 'Y-m-d' , $katb_date ).'</span>';
			}
			
		}

	$meta_side .= '</div>';
	
	return $meta_side;
}