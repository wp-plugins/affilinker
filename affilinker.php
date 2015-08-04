<?php
/*
Plugin Name: AffiLinker
Plugin URI: http://www.affilinker.com/affiliate-wordpress-plugin/
Description: WordPress plugin (lite version) to automatically convert keywords into Affiliate Links and to show Affiliate Link Cloud widget - <a href="http://www.affilinker.com/affiliate-wordpress-plugin/" target = "_blank">Download Pro-Version here</a> - <a href="http://www.blasho.com/blog" target="_blank">Our Blog</a>
Author: Ven Tesh
Version: 1.6.0
Author URI: http://www.blasho.com/
*/

add_action('admin_init', 'AffiLinker_Operations');
add_action('admin_menu', 'AffiLinker_CreateMenu');
add_filter('the_content', 'AffiLinker_InsertAffiliateLinks');
add_filter('get_comment', 'AffiLinker_InsertAffiliateLinksToComment');


$link = '';
$linkformat = '';
$linkformat4comm = '';
$linknofollow  = '';
$linklink_target = '';
$linkhead = '';
$linkclass = '';
$afflt = array( 'AffiLinker Activation Form', 'AffiLinker - General Settings' );

function AffiLinker_create_ad_widget() {
	register_widget( 'AffiLinkerWidget' );
}

class AffiLinkerWidget extends WP_Widget {
 function AffiLinkerWidget() {
        //Constructor
        parent::WP_Widget(false, $name = 'AffiLinker Cloud', array(
            'description' => 'Widget to create list/cloud of Affiliate links.'
        ));
    }
    
    function widget($args, $instance) {
  	extract($args);
	echo $before_widget;

$affl_underline_options_array = array(
	"",
	"text-decoration: none; border-bottom:1px dotted;",
	"text-decoration: none; border-bottom:2px dotted;",
	"text-decoration: none; border-bottom:1px dashed;",
	"text-decoration: none; border-bottom:2px dashed;",
	"text-decoration: none; border-bottom:1px solid red;",
	"text-decoration: none; border-bottom:2px solid red;",
	"text-decoration: none; border-bottom:3px double;",
	"text-decoration: none; border-bottom:4px double;",
	"text-decoration: underline overline;" );
				$family_array = array(
				"Default Font",
				"Arial",
				"Arial Black",
				"Comic",
				"Comic Sans MS",
				"Courier",
				"Courier New",
				"Franklin Gothic",
				"Georgia",
				"Helvetica",
				"Impact",
				"Lucida Sans",
				"Microsoft Sans Serif",
				"Monaco",
				"MV Boli",
				"Tahoma",
				"Times",
				"Times New Roman",
				"Trebuchet MS",
				"Verdana");

	$affl_widget_title = get_option("affl_widget_title");
	$affl_widget_title = esc_attr($instance['affl_widget_title']);
	$affl_widget_title = $affl_widget_title ? $affl_widget_title : 'AffiLinker Cloud';
	$affl_link_term = get_option("affl_link_term");

        echo "\n" . $before_title;
        echo $affl_widget_title;
        echo $after_title;

	global $wpdb;
	$table_name = $wpdb->prefix . "affilinker_db";

	$myrows = $wpdb->get_results( "SELECT * FROM ". $table_name);

	$affl_widget_no_keywords_counter = 0;
	
	$affl_widget_interactive_opt = esc_attr($instance['affl_widget_interactive_opt']);
	$affl_widget_interactive_opt = $affl_widget_interactive_opt ? $affl_widget_interactive_opt : '0';

	$affl_widget_avoid_dup = esc_attr($instance['affl_widget_avoid_dup']);
	$affl_widget_avoid_dup = affl_widget_avoid_dup ? $affl_widget_avoid_dup : '0';

	$affl_widget_no_keywords = esc_attr($instance['affl_widget_no_keywords']);
	$affl_widget_no_keywords = $affl_widget_no_keywords ? $affl_widget_no_keywords : '10';

	$affl_widget_type = esc_attr($instance['affl_widget_type']);
	$affl_widget_type = $affl_widget_type ? $affl_widget_type : '21';

	$affl_widget_font_startpx = esc_attr($instance['affl_widget_font_startpx']);
	$affl_widget_font_startpx = $affl_widget_font_startpx ? $affl_widget_font_startpx : '10';

	$affl_widget_font_endpx = esc_attr($instance['affl_widget_font_endpx']);
	$affl_widget_font_endpx = $affl_widget_font_endpx ? $affl_widget_font_endpx : '25';

	$affl_widget_no_keywords = esc_attr($instance['affl_widget_no_keywords']);
	$affl_widget_no_keywords = $affl_widget_no_keywords ? $affl_widget_no_keywords : '10';


	if ($affl_widget_type == 20)
		echo '<ul>';

        foreach ($myrows as $row) {
		if ($affl_widget_no_keywords == 0)
			break;
			
            if (!is_null($row->keywords)) {
			if ($row->include_keyword != 1)
				continue;
				
			$keys = explode(',',$row->keywords);

                foreach ($keys as $key) {
				$key = trim($key);
				$direct_style = 0;
                    if ($affl_widget_interactive_opt == 1) {
                        if ((!is_null($row->link_color)) || (!is_null($row->bg_color)) || (!is_null($row->hover_color)) || (!is_null($row->hover_bg_color)) || ($row->font_family != 0) || ($row->link_style_bold == 1) || ($row->link_style_italics == 1) || ($affl_widget_type == 21)) {
						$randno4css = 'cw'. rand();

						$linkformat = '<style type="text/css"> a.'.$randno4css . '{';

                            if ($affl_widget_type == 21) {
							$linkformat = $linkformat . 'font-size:' . rand($affl_widget_font_startpx,$affl_widget_font_endpx) . 'px;';
						}

                            if ($row->link_color != '') {
							$linkformat = $linkformat . 'color:' . $row->link_color . ';';
						}

                            if ($row->bg_color != '') {
							$linkformat = $linkformat . 'background-color:' . $row->bg_color . ';';
						}

                            if ($row->font_size != 0) {
							//$linkformat = $linkformat . 'font-size:' . $row->font_size . 'px;';
						}

                            if ($row->font_family != 0) {
							$linkformat = $linkformat . 'font-family:' . $family_array[$row->font_family] . ';';
						}

                            if ($row->link_style_bold == 1) {
							$linkformat = $linkformat . 'font-weight:bold;';
						}

                            if ($row->link_style_italics == 1) {
							$linkformat = $linkformat . 'font-style:italic;';
						}

                            if ($row->affl_underline_options != 0) {
							$linkformat = $linkformat . $affl_underline_options_array[$row->affl_underline_options];
						}

						$linkformat = $linkformat . "}";

                            if (($row->hover_color != '') || ($row->hover_bg_color != '')) {
							$linkformat = $linkformat . " ." . $randno4css . ":hover{";

							if ($row->hover_color != '')
								$linkformat = $linkformat . "color:" . $row->hover_color . ";";
							if ($row->hover_bg_color != '')
								$linkformat = $linkformat . "background-color:" . $row->hover_bg_color . ";";

							$linkformat = $linkformat . "}";
						}

						$linkformat = $linkformat . "</style>";

						$linkclass = 'class="' . $randno4css . '"';

						$direct_style = 1;
					}
				}
                    else {
                        if ($affl_widget_type == 21) {
						$linkformat = 'style="';

						$linkformat = $linkformat . 'font-size:' . rand($affl_widget_font_startpx,$affl_widget_font_endpx) . 'px;';

						$linkformat = $linkformat . '"';

						$direct_style = 2;
					}
				}

                    if ($row->link_nofollow == 1) {
					$linknofollow = ' rel = "nofollow" ';
                    } else {
					$linknofollow = ' ';
				}

                    if ($row->link_target == 1) {
					$linklink_target = ' target = "_self" ';
                    } else {
					$linklink_target = ' target = "_blank" ';
				}

                    if ($row->alt_link_keyword == 1) {
//					echo '*' . $key . '*[' . str_replace(' ','-',$key) . ']';


					$link =  'http://'.$_SERVER['HTTP_HOST'] . '/' . $affl_link_term . '/'. str_replace(' ','-',$key) . '/';
                    } else {
					$link = $row->link;
				}

				if ($affl_widget_type == 20)
					echo '<li>';

				if ( $direct_style != 1 )
					echo  '<a href="' . $link . '" ' . $linkformat . " " . $linknofollow . $linklink_target . '>' . $key . '</a>';
				else
					echo $linkformat . '<a ' . $linkclass . ' href="' . $link . '" ' . $linknofollow . $linklink_target . '>' . $key . '</a>';

				if ($affl_widget_type == 20)
					echo '</li>';
				else if ($affl_widget_type == 21)
					echo '  ';
					
				$affl_widget_no_keywords_counter = $affl_widget_no_keywords_counter + 1;

                    if (($affl_widget_avoid_dup == 1) || ($affl_widget_no_keywords_counter == $affl_widget_no_keywords)) {
					break;
				}
			}
		}

            if ($affl_widget_no_keywords_counter == $affl_widget_no_keywords) {
			break;
		}
	}
	
	if ($affl_widget_type == 20)
		echo '</ul>';

	//echo $after_title;
	
	echo $after_widget;
}

    function update($new_instance, $old_instance) {
        //update and save the widget

	return $new_instance;
    }

    function form($instance) {
			$affl_widget_title = esc_attr($instance['affl_widget_title']);
			$affl_widget_title = $affl_widget_title ? $affl_widget_title : 'AffiLinker Cloud';

			$affl_widget_no_keywords = esc_attr($instance['affl_widget_no_keywords']);
			$affl_widget_no_keywords = $affl_widget_no_keywords ? $affl_widget_no_keywords : '10';

			$affl_widget_type = esc_attr($instance['affl_widget_type']);
			$affl_widget_type = $affl_widget_type ? $affl_widget_type : '21';

			$affl_widget_font_startpx = esc_attr($instance['affl_widget_font_startpx']);
			$affl_widget_font_startpx = $affl_widget_font_startpx ? $affl_widget_font_startpx : '10';

			$affl_widget_font_endpx = esc_attr($instance['affl_widget_font_endpx']);
			$affl_widget_font_endpx = $affl_widget_font_endpx ? $affl_widget_font_endpx : '25';

			$affl_widget_interactive_opt = esc_attr($instance['affl_widget_interactive_opt']);
			$affl_widget_interactive_opt = $affl_widget_interactive_opt ? $affl_widget_interactive_opt : '0';

			$affl_widget_avoid_dup = esc_attr($instance['affl_widget_avoid_dup']);
			$affl_widget_avoid_dup = $affl_widget_avoid_dup ? $affl_widget_avoid_dup : '0';

			echo '
			Widget Title : <input type="text" id="' . $this->get_field_id('affl_widget_title') . '" name="' . $this->get_field_name('affl_widget_title') . '" value="' . $affl_widget_title . '" /> <br/><br/>
			No of Keywords to Display : <input type="text" id="' . $this->get_field_id('affl_widget_no_keywords') . '" name="' . $this->get_field_name('affl_widget_no_keywords') . '" value = "' . $affl_widget_no_keywords . '" size="3"/> <br/><small>Put -1 to list all keywords</small><br/><br/>
			How To Display AffiLinks ? <br/>';

			echo '<select name="' . $this->get_field_name('affl_widget_type') . '">';
        if ($affl_widget_type == 20) {
			echo '<option selected id="' . $this->get_field_id('affl_widget_type') . '" value="20" > Keywords as List</option>
			<option id="' . $this->get_field_id('affl_widget_type') . '" value="21" >Keywords as Cloud</option></select>';
        } else {
			echo '<option id="' . $this->get_field_id('affl_widget_type') . '" value="20" > Keywords as List</option>
			<option selected id="' . $this->get_field_id('affl_widget_type') . '" value="21" > Keywords as Cloud</option></select>';
			}
			echo '<br/>';

			echo '<br/>For Keywords as Cloud:<br/>   Minimum Font <input type="text" id="' . $this->get_field_id('affl_widget_font_startpx') . '" name="' . $this->get_field_name('affl_widget_font_startpx') . '" value = "' . $affl_widget_font_startpx . '" size="3"/>px<br/>   Maximum Font <input type="text" id="' . $this->get_field_id('affl_widget_font_endpx') . '" name="' . $this->get_field_name('affl_widget_font_endpx') . '" value = "' . $affl_widget_font_endpx . '" size="3"/>px';

        if ($affl_widget_interactive_opt == 1) {
			echo '<br/><br/><input type="checkbox" id="' . $this->get_field_id('affl_widget_interactive_opt') . '" name="' . $this->get_field_name('affl_widget_interactive_opt') . '" value="1"  CHECKED />&nbsp; Enable Interactive AffiLinks';
        } else {
			echo '<br/><br/><input type="checkbox" id="' . $this->get_field_id('affl_widget_interactive_opt') . '" name="' . $this->get_field_name('affl_widget_interactive_opt') . '" value="1"  />&nbsp; Enable Interactive AffiLinks';
			}

        if ($affl_widget_avoid_dup == 1) {
			echo '<br/><input type="checkbox" id="' . $this->get_field_id('affl_widget_avoid_dup') . '" name="' . $this->get_field_name('affl_widget_avoid_dup') . '" value="1"  CHECKED />&nbsp; Show Only Unique AffiLinks';
        } else {
			echo '<br/><input type="checkbox" id="' . $this->get_field_id('affl_widget_avoid_dup') . '" name="' . $this->get_field_name('affl_widget_avoid_dup') . '" value="1"  />&nbsp; Show Only Unique AffiLinks';
			}
			echo '<input type="hidden" name="aff_widget_submit" id="aff_widget_submit" value="1" />';
		}

}

add_action( 'widgets_init', 'AffiLinker_create_ad_widget' );


function AffiLinker_write_ads_widget($args) {
	extract($args);
	echo $before_widget;

$affl_underline_options_array = array(
	"",
	"text-decoration: none; border-bottom:1px dotted;",
	"text-decoration: none; border-bottom:2px dotted;",
	"text-decoration: none; border-bottom:1px dashed;",
	"text-decoration: none; border-bottom:2px dashed;",
	"text-decoration: none; border-bottom:1px solid red;",
	"text-decoration: none; border-bottom:2px solid red;",
	"text-decoration: none; border-bottom:3px double;",
	"text-decoration: none; border-bottom:4px double;",
	"text-decoration: underline overline;" );
				$family_array = array(
				"Default Font",
				"Arial",
				"Arial Black",
				"Comic",
				"Comic Sans MS",
				"Courier",
				"Courier New",
				"Franklin Gothic",
				"Georgia",
				"Helvetica",
				"Impact",
				"Lucida Sans",
				"Microsoft Sans Serif",
				"Monaco",
				"MV Boli",
				"Tahoma",
				"Times",
				"Times New Roman",
				"Trebuchet MS",
				"Verdana");

	$affl_widget_title = get_option("affl_widget_title");

    echo "\n" . $before_title;
    echo $affl_widget_title;
    echo $after_title;

	global $wpdb;
	$table_name = $wpdb->prefix . "affilinker_db";

	$myrows = $wpdb->get_results( "SELECT * FROM ". $table_name);

	$affl_widget_interactive_opt = get_option("affl_widget_interactive_opt");
	$affl_widget_avoid_dup = get_option("affl_widget_avoid_dup");
	$affl_widget_no_keywords = get_option("affl_widget_no_keywords");
	$affl_widget_type = get_option("affl_widget_type");
	$affl_widget_font_startpx = get_option("affl_widget_font_startpx");
	$affl_widget_font_endpx = get_option("affl_widget_font_endpx");
	$affl_link_term = get_option("affl_link_term");

	$affl_widget_no_keywords_counter = 0;

	if ($affl_widget_type == 0)
		echo '<ul>';

    foreach ($myrows as $row) {
		if ($affl_widget_no_keywords == 0)
			break;
			
        if (!is_null($row->keywords)) {
			if ($row->include_keyword != 1)
				continue;

			$keys = explode(',',$row->keywords);

            foreach ($keys as $key) {
				$key = trim($key);
				$direct_style = 0;
                if ($affl_widget_interactive_opt == 1) {
                    if ((!is_null($row->link_color)) || (!is_null($row->bg_color)) || (!is_null($row->hover_color)) || (!is_null($row->hover_bg_color)) || ($row->font_family != 0) || ($row->link_style_bold == 1) || ($row->link_style_italics == 1) || ($affl_widget_type == 1)) {
						$randno4css = 'cw'. rand();

						$linkformat = '<style type="text/css"> a.'.$randno4css . '{';

                        if ($affl_widget_type == 1) {
							$linkformat = $linkformat . 'font-size:' . rand($affl_widget_font_startpx,$affl_widget_font_endpx) . 'px;';
						}

                        if ($row->link_color != '') {
							$linkformat = $linkformat . 'color:' . $row->link_color . ';';
						}

                        if ($row->bg_color != '') {
							$linkformat = $linkformat . 'background-color:' . $row->bg_color . ';';
						}

                        if ($row->font_size != 0) {
							//$linkformat = $linkformat . 'font-size:' . $row->font_size . 'px;';
						}

                        if ($row->font_family != 0) {
							$linkformat = $linkformat . 'font-family:' . $family_array[$row->font_family] . ';';
						}

                        if ($row->link_style_bold == 1) {
							$linkformat = $linkformat . 'font-weight:bold;';
						}

                        if ($row->link_style_italics == 1) {
							$linkformat = $linkformat . 'font-style:italic;';
						}

                        if (!is_null($row->hover_title_text)) {
							$linkformat = $linkformat . "title:'" . $row->hover_title_text . "';";
						}
						
                        if ($row->affl_underline_options != 0) {
							$linkformat = $linkformat . $affl_underline_options_array[$row->affl_underline_options];
						}

						$linkformat = $linkformat . "}";

                        if (($row->hover_color != '') || ($row->hover_bg_color != '')) {
							$linkformat = $linkformat . " ." . $randno4css . ":hover{";

							if ($row->hover_color != '')
								$linkformat = $linkformat . "color:" . $row->hover_color . ";";
							if ($row->hover_bg_color != '')
								$linkformat = $linkformat . "background-color:" . $row->hover_bg_color . ";";

							$linkformat = $linkformat . "}";
						}

						$linkformat = $linkformat . "</style>";

						$linkclass = 'class="' . $randno4css . '"';

						$direct_style = 1;
					}
				}
                else {
                    if ($affl_widget_type == 1) {
						$linkformat = 'style="';

						$linkformat = $linkformat . 'font-size:' . rand($affl_widget_font_startpx,$affl_widget_font_endpx) . 'px;';

						$linkformat = $linkformat . '"';

						$direct_style = 2;
					}
				}

                if ($row->link_nofollow == 1) {
					$linknofollow = ' rel = "nofollow" ';
                } else {
					$linknofollow = ' ';
				}

                if ($row->link_target == 1) {
					$linklink_target = ' target = "_self" ';
                } else {
					$linklink_target = ' target = "_blank" ';
				}

                if ($row->alt_link_keyword == 1) {
					echo '*' . $key . '*';
					$link =  'http://'.$_SERVER['HTTP_HOST'] . '/' . $affl_link_term . '/'. str_replace(' ','-',$key) . '/';
                } else {
					$link = $row->link;
				}

				if ($affl_widget_type == 0)
					echo '<li>';

				if ( $direct_style != 1 )
					echo  '<a href="' . $link . '" ' . $linkformat . " " . $linknofollow . $linklink_target . '>' . $key . '</a>';
				else
					echo $linkformat . '<a ' . $linkclass . ' href="' . $link . '" ' . $linknofollow . $linklink_target . '>' . $key . '</a>';

				if ($affl_widget_type == 0)
					echo '</li>';
				else if ($affl_widget_type == 1)
					echo '  ';
					
				$affl_widget_no_keywords_counter = $affl_widget_no_keywords_counter + 1;

                if (($affl_widget_avoid_dup == 1) || ($affl_widget_no_keywords_counter == $affl_widget_no_keywords)) {
					break;
				}
			}
		}

        if ($affl_widget_no_keywords_counter == $affl_widget_no_keywords) {
			break;
		}
	}
	
	if ($affl_widget_type == 0)
		echo '</ul>';

	echo $after_title;
	
	echo $after_widget;
}

function makeStringSecure ($string) {
   $string = trim($string);
   $string = strip_tags($string);
   $string = htmlentities($string, ENT_NOQUOTES);
   $string = stripslashes($string);
   $string = mysql_real_escape_string($string);
   return $string;
}

add_action('init', 'AffiLinker_NavigateToLink');
function AffiLinker_NavigateToLink() {
    if (1/* !is_admin() */) {
	 	$reqURL = $_SERVER['REQUEST_URI'];
		$fullURL = 'http://'.$_SERVER['HTTP_HOST'].$reqURL;
		$affl_link_term = get_option("affl_link_term");
//echo $fullURL;
		$hopURL = '/' . $affl_link_term . '/';
//echo ' - ' . $hopURL;
		if ($hopURL != '' && $hopURL != '//')
		if (stristr($fullURL, $hopURL) !== false) {
			$reqArr = explode('/', $reqURL);
			foreach ($reqArr as $key=>$token) {
                    if ($token == '') {
                        unset($reqArr[$key]);
			}
                }
			$tag = array_pop($reqArr);



			global $wpdb;
			$table_name = $wpdb->prefix . "affilinker_db";

			$table_name_stat = $wpdb->prefix . "affilinker_db_stat";



			$tag = str_replace('-',' ',$tag);
			$tag = trim($tag);
			if (strpos($tag,'%') != FALSE) {
					$iso_char_found = true;
					$myrows = $wpdb->get_results( "SELECT * FROM ". $table_name);
                } else {
					$iso_char_found = false;
					$myrows = $wpdb->get_results( "SELECT * FROM ". $table_name . " WHERE keywords like '%" . $tag ."%'" );
			}
//			echo ' - tag ' . $tag;

			//echo $wpdb->num_rows;

                if ($wpdb->num_rows <= 0) {
				die;
			}

                if (1) {
				$keyword_matched = 1;
                    foreach ($myrows as $row) {
                        if (!is_null($row->keywords)) {
						$keys = explode(',',$row->keywords);

                            foreach ($keys as $key) {
							$tag = str_replace(array("\r\n"), '', $tag);
							$key = str_replace(array("\r\n"), '', $key);
							$key = trim($key);
							$tag = trim($tag);

                                if ($iso_char_found == true) {
								$key = urldecode($key);
								$tag = urldecode(makeStringSecure($tag));
							}

//echo '[ ' . urldecode( $key) . ' - ' . urldecode(makeStringSecure($tag)) . ' ]';
							$keyword_matched = strcasecmp($key, $tag);
                                if ($keyword_matched == 0) {
								$FullRef_URL = $_SERVER['HTTP_REFERER'];

								//matched
								$afflink_update_query = "UPDATE ". $table_name ." SET link_hit_count=link_hit_count+1 WHERE id='$row->id'";

								if ($FullRef_URL != '')
									$results = $wpdb->query( $afflink_update_query );
								break;
							}
						}
					}

                        if ($keyword_matched == 0) {
						break;
					}
				}
			}

			$FullRef_URL = $_SERVER['HTTP_REFERER'];

                if ($FullRef_URL != '') {
				$table_name_stat_uniq = $wpdb->prefix . "affilinker_db_stat_uniq";
				$affl_ip_address = $_SERVER['REMOTE_ADDR'];

				$myrows = $wpdb->get_results( "SELECT * FROM ". $table_name_stat_uniq . " WHERE hit_keyword='$key' AND affl_ip_address='$affl_ip_address'");
                    if ($wpdb->num_rows <= 0) {
					$rows_affected = $wpdb->insert( $table_name_stat_uniq, array( 'affl_ip_address' => $affl_ip_address, 'hit_keyword' => $key) );
				}

		

				$keyword_row_stat = $wpdb->get_results( "SELECT * FROM ". $table_name_stat . " WHERE hit_keyword='$key' AND referral_link='" . $FullRef_URL . "'");
                    if ($wpdb->num_rows > 0) {
                        foreach ($keyword_row_stat as $row_stat) {
						//existing rec
						$rows_affected = $wpdb->update( $table_name_stat, array('link_hit_count' => $row_stat->link_hit_count + 1), array( 'hit_keyword' => $key, 'referral_link' => $FullRef_URL ));
						break;
					}
                    } else {
					$rows_affected = $wpdb->insert( $table_name_stat, array( 'referral_link' => $FullRef_URL, 'hit_keyword' => $key, 'link_hit_count' => 1) );
				}
			}

			header('Location: ' . $row->link);
			ob_end_flush();
			exit();

		}
	}
}


function AffiLinker_Operations() {
	global $wpdb;

	$table_name = $wpdb->prefix . "affilinker_db";
	$table_name_stat = $wpdb->prefix . "affilinker_db_stat";



	if($_POST['aal_sent']=='ok') {
		
		$rowchk = 4;
		$myrows = $wpdb->get_results( "SELECT * FROM ". $table_name);
		$rown = 0;
		$rowchk = $rowchk - 2;
		foreach($myrows as $row) {

		$rown = $rown + 1;
		}
		if ($rown >= ($rowchk+4))
		{
			wp_redirect("admin.php?page=affilinker/affilinker.php");
		}
		else
		{

		
		$link = filter_input(INPUT_POST, 'link', FILTER_SANITIZE_SPECIAL_CHARS); 
		$keywords = filter_input(INPUT_POST, 'keywords', FILTER_SANITIZE_SPECIAL_CHARS); 
	
		$link_color = filter_input(INPUT_POST, 'link_color', FILTER_SANITIZE_SPECIAL_CHARS); 
		$bg_color = filter_input(INPUT_POST, 'bg_color', FILTER_SANITIZE_SPECIAL_CHARS); 
		$hover_color = filter_input(INPUT_POST, 'hover_color', FILTER_SANITIZE_SPECIAL_CHARS); 
		$hover_bg_color = filter_input(INPUT_POST, 'hover_bg_color', FILTER_SANITIZE_SPECIAL_CHARS); 
		
		$hover_title_text = filter_input(INPUT_POST, 'hover_title_text', FILTER_SANITIZE_SPECIAL_CHARS);

		$font_size = filter_input(INPUT_POST, 'font_size', FILTER_SANITIZE_SPECIAL_CHARS); 
		$font_family = filter_input(INPUT_POST, 'font_family', FILTER_SANITIZE_SPECIAL_CHARS); 

	$link_style_bold = filter_input(INPUT_POST, 'link_style_bold', FILTER_SANITIZE_SPECIAL_CHARS); 
	$link_style_italics = filter_input(INPUT_POST, 'link_style_italics', FILTER_SANITIZE_SPECIAL_CHARS); 
	$affl_underline_options = filter_input(INPUT_POST, 'affl_underline_options', FILTER_SANITIZE_SPECIAL_CHARS); 

		$link_nofollow = filter_input(INPUT_POST, 'link_nofollow', FILTER_SANITIZE_SPECIAL_CHARS); 
		$link_target = filter_input(INPUT_POST, 'link_target', FILTER_SANITIZE_SPECIAL_CHARS); 
		$include_keyword = filter_input(INPUT_POST, 'include_keyword', FILTER_SANITIZE_SPECIAL_CHARS); 

		$alt_link_keyword = filter_input(INPUT_POST, 'alt_link_keyword', FILTER_SANITIZE_SPECIAL_CHARS); 
	$keyword_priority =  filter_input(INPUT_POST, 'keyword_priority', FILTER_SANITIZE_SPECIAL_CHARS); 

	//$link_hit_count = filter_input(INPUT_POST, 'link_hit_count', FILTER_SANITIZE_SPECIAL_CHARS); 
	$link_hit_count = 0;
            if ($keywords != '') {
			$rows_affected = $wpdb->insert( $table_name, array( 'link' => $link, 'keywords' => $keywords, 'link_color' => $link_color, 'bg_color' => $bg_color,
				'hover_color' => $hover_color, 'hover_bg_color' => $hover_bg_color, 'font_size' => $font_size, 'font_family' => $font_family, 
				'link_style_bold' => $link_style_bold, 'link_style_italics' => $link_style_italics, 'affl_underline_options' => $affl_underline_options,
				'link_nofollow' => $link_nofollow, 'link_target' => $link_target, 'include_keyword' => $include_keyword, 'alt_link_keyword' => $alt_link_keyword, 'link_hit_count' => $link_hit_count, 'keyword_priority' => $keyword_priority, 'hover_title_text' => $hover_title_text  ) );
		}
		wp_redirect("admin.php?page=affilinker/affilinker.php#down");
	}			
	}

    if ($_POST['affl_savegs_changes'] == 'ok') {

	check_admin_referer('AffiLinker-AFFL_gsettings');

	$affl_num_of_keywords = filter_input(INPUT_POST, 'affl_num_of_keywords', FILTER_SANITIZE_SPECIAL_CHARS); 
	$affl_num_of_keywords_percomment = filter_input(INPUT_POST, 'affl_num_of_keywords_percomment', FILTER_SANITIZE_SPECIAL_CHARS); 

	$affl_num_samekey_perpost = filter_input(INPUT_POST, 'affl_num_samekey_perpost', FILTER_SANITIZE_SPECIAL_CHARS); 
	$affl_num_samekey_oncommsec = filter_input(INPUT_POST, 'affl_num_samekey_oncommsec', FILTER_SANITIZE_SPECIAL_CHARS); 
	$affl_link_term = filter_input(INPUT_POST, 'affl_link_term', FILTER_SANITIZE_SPECIAL_CHARS); 

	$affl_postcontrol = filter_input(INPUT_POST, 'affl_postcontrol', FILTER_SANITIZE_SPECIAL_CHARS); 
	$affl_ignoreposts = filter_input(INPUT_POST, 'affl_ignoreposts', FILTER_SANITIZE_SPECIAL_CHARS); 

	$affl_onlyposts = filter_input(INPUT_POST, 'affl_onlyposts', FILTER_SANITIZE_SPECIAL_CHARS); 
	$affl_link_on_comments = filter_input(INPUT_POST, 'affl_link_on_comments', FILTER_SANITIZE_SPECIAL_CHARS); 
	$affl_link_on_homepage = filter_input(INPUT_POST, 'affl_link_on_homepage', FILTER_SANITIZE_SPECIAL_CHARS); 

	$affl_keyword_priority = filter_input(INPUT_POST, 'affl_keyword_priority', FILTER_SANITIZE_SPECIAL_CHARS); 
	$affl_interactive_afflinks = filter_input(INPUT_POST, 'affl_interactive_afflinks', FILTER_SANITIZE_SPECIAL_CHARS); 
	$afflinker_enable = filter_input(INPUT_POST, 'afflinker_enable', FILTER_SANITIZE_SPECIAL_CHARS); 
	$affl_num_of_wordcount = filter_input(INPUT_POST, 'affl_num_of_wordcount', FILTER_SANITIZE_SPECIAL_CHARS); 

	$afflinker_jquery_opt = filter_input(INPUT_POST, 'afflinker_jquery_opt', FILTER_SANITIZE_SPECIAL_CHARS); 
	
	
        if ($afflinker_enable == '') {
			$afflinker_enable = 0;
		}
	
        if ($affl_num_of_keywords == '') {
			$affl_num_of_keywords = 5;
		}

        if ($affl_num_of_keywords_percomment == '') {
			$affl_num_of_keywords_percomment = 5;
		}

        if ($affl_num_samekey_perpost == '') {
			$affl_num_samekey_perpost = 2;
		}
		
        if ($affl_num_samekey_oncommsec == '') {
			$affl_num_samekey_oncommsec = 2;
		}
		
        if ($affl_link_term == '') {
			$affl_link_term = 'visit';
		}

        if ($affl_postcontrol == '') {
			$affl_postcontrol = 1;
		}

        if ($affl_link_on_comments == '') {
			$affl_link_on_comments = 0;
		}
        if ($affl_link_on_homepage == '') {
			$affl_link_on_homepage = 1;
		}

        if ($affl_keyword_priority == '') {
            $affl_keyword_priority = 1;
		}
        if ($affl_interactive_afflinks == '') {
			$affl_interactive_afflinks = 1;
		}

        if ($affl_num_of_wordcount == '') {
			$affl_num_of_wordcount = -1;
		}

        if ($afflinker_jquery_opt == '') {
			$afflinker_jquery_opt = 1;
		}

	update_option("affl_num_of_keywords", $affl_num_of_keywords);
	update_option("affl_num_of_keywords_percomment", $affl_num_of_keywords_percomment);
	update_option("affl_num_samekey_perpost", $affl_num_samekey_perpost);
	update_option("affl_num_samekey_oncommsec", $affl_num_samekey_oncommsec);
	update_option("affl_link_term", $affl_link_term);

	update_option("affl_num_of_wordcount", $affl_num_of_wordcount);
	update_option("affl_postcontrol", $affl_postcontrol);
	update_option("affl_ignoreposts", $affl_ignoreposts);
	update_option("affl_onlyposts", $affl_onlyposts);
	update_option("affl_link_on_comments", $affl_link_on_comments);
	update_option("affl_link_on_homepage", $affl_link_on_homepage);
	update_option("affl_keyword_priority", $affl_keyword_priority);
	update_option("affl_interactive_afflinks", $affl_interactive_afflinks);
	update_option("afflinker_enable", $afflinker_enable);
	update_option("afflinker_jquery_opt", $afflinker_jquery_opt);
	}

    if ($_POST['SubmitAll'] == 'Save All Changes') {
	$idall = $_POST['checkboxall'];
	$linkall = $_POST['link'];
	$keywordsall = $_POST['keywords'];
	$link_hit_countall = $_POST['link_hit_count'];

	$link_nofollowall = $_POST['link_nofollow'];
	$link_targetall = $_POST['link_target'];
	$include_keywordall = $_POST['include_keyword'];

	$link_colorall = $_POST['link_color'];
	$bg_colorall = $_POST['bg_color'];
	$hover_colorall = $_POST['hover_color'];
	$hover_bg_colorall = $_POST['hover_bg_color'];
	$font_sizeall = $_POST['font_size'];
	$font_familyall = $_POST['font_family'];
	$link_style_boldall = $_POST['link_style_bold'];
	$link_style_italicsall = $_POST['link_style_italics'];
	$affl_underline_optionsall = $_POST['affl_underline_options'];
	$hover_title_textall = $_POST['hover_title_text'];
	$alt_link_keywordall = $_POST['alt_link_keyword'];
	$keyword_priorityall = $_POST['keyword_priority'];

	$count = count($linkall);

        for ($ids = 0; $ids < $count; $ids++) {
		$nofollowset = 0;
            for ($i = 0; $i < count($link_nofollowall); $i++) {
                if ($link_nofollowall[$i] == $idall[$ids]) {
				$nofollowset = 1;
				break;
			}
		}

		$targetset = 0;
            for ($i = 0; $i < count($link_targetall); $i++) {
                if ($link_targetall[$i] == $idall[$ids]) {
				$targetset = 1;
				break;
			}
		}

		$include_keywordset = 0;
            for ($i = 0; $i < count($include_keywordall); $i++) {
                if ($include_keywordall[$i] == $idall[$ids]) {
				$include_keywordset = 1;
				break;
			}
		}

		$link_style_boldset = 0;
            for ($i = 0; $i < count($link_style_boldall); $i++) {
                if ($link_style_boldall[$i] == $idall[$ids]) {
				$link_style_boldset = 1;
				break;
			}
		}

		$link_style_italicsset = 0;
            for ($i = 0; $i < count($link_style_italicsall); $i++) {
                if ($link_style_italicsall[$i] == $idall[$ids]) {
				$link_style_italicsset = 1;
				break;
			}
		}

		$alt_link_keywordset = 0;
            for ($i = 0; $i < count($alt_link_keywordall); $i++) {
                if ($alt_link_keywordall[$i] == $idall[$ids]) {
				$alt_link_keywordset = 1;
				break;
			}
		}

		$keyword_priorityset = 0;
            for ($i = 0; $i < count($keyword_priorityall); $i++) {
                if ($keyword_priorityall[$i] == $idall[$ids]) {
				$keyword_priorityset = 1;
				break;
			}
		}
	$keywordsall[$ids] = str_replace(array("\r\n"), ' ', $keywordsall[$ids]);
	$rows_affected = $wpdb->update( $table_name, array( 'link' => $linkall[$ids], 'keywords' => $keywordsall[$ids], 'link_color' => $link_colorall[$ids], 'bg_color' => $bg_colorall[$ids],
		'hover_color' => $hover_colorall[$ids], 'hover_bg_color' => $hover_bg_colorall[$ids], 'font_size' => $font_sizeall[$ids], 'font_family' => $font_familyall[$ids], 
		'link_style_bold' => $link_style_boldset, 'link_style_italics' => $link_style_italicsset, 'affl_underline_options' => $affl_underline_optionsall[$ids],
		'link_nofollow' => $nofollowset, 'link_target' => $targetset, 'include_keyword' => $include_keywordset, 'alt_link_keyword' => $alt_link_keywordset, 
		'link_hit_count' => $link_hit_countall[$ids], 'keyword_priority' => $keyword_priorityset, 'hover_title_text' => $hover_title_textall[$ids] ), array( 'id' => $idall[$ids] ));

		wp_redirect("admin.php?page=affilinker/affilinker.php#up");
	}

	}

	if($_POST['SubmitAll']=='Delete Selected') {

	$checked = $_POST['checkbox1'];

	$count = count($checked);

        for ($ids = 0; $ids < $count; $ids++) {
		$wpdb->query("DELETE FROM ". $table_name ." WHERE id = '". $checked[$ids] ."' LIMIT 1");
	}

	wp_redirect("admin.php?page=affilinker/affilinker.php#up");
	}

	if($_POST['stats']=='Clear All Stats') {
	global $wpdb;
	$table_name = $wpdb->prefix . "affilinker_db_stat";
	$wpdb->query("DELETE FROM ". $table_name);

	$table_name = $wpdb->prefix . "affilinker_db_stat_uniq";
	$wpdb->query("DELETE FROM ". $table_name);

	$table_name = $wpdb->prefix . "affilinker_db";
	$wpdb->query("UPDATE " . $table_name . " SET link_hit_count=0");
	}
}

function AffiLinker_CreateMenu() {
	
	add_menu_page('AffiLinker', 'AffiLinker', 8, __FILE__, 'AffiLinker_MainPage');
	add_submenu_page(__FILE__, 'Track Links', 'Track Links', 8, 'tracklinkspage', 'AffiLinker_TrackAffiliates');
	add_submenu_page(__FILE__, 'General Settings', 'General Settings', 8, 'affilinkergeneralsettings', 'AFFL_GeneralSettings');

			wp_enqueue_script ('hidenseek', '/wp-content/plugins/affilinker/js/hidenseek.js', array('jquery'));
			wp_enqueue_script ('jscolor', '/wp-content/plugins/affilinker/jscolor.js', array('jquery'));
}

function AFFL_GeneralSettings()
{
global $afflt;

	echo '<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>';
	echo '<h2>'.$afflt[1].'</h2>
	<br /><br />

	<form name="AFFL_gsettings" method="post">';

		$affl_num_of_keywords = get_option("affl_num_of_keywords");
    if ($affl_num_of_keywords == '') {
			$affl_num_of_keywords = 5;
		}

		$affl_num_of_keywords_percomment = get_option("affl_num_of_keywords_percomment");
    if ($affl_num_of_keywords_percomment == '') {
			$affl_num_of_keywords_percomment = 5;
		}

		$affl_num_samekey_perpost = get_option("affl_num_samekey_perpost");
    if ($affl_num_samekey_perpost == '') {
			$affl_num_samekey_perpost = 2;
		}
		
		$affl_num_samekey_oncommsec = get_option("affl_num_samekey_oncommsec");
    if ($affl_num_samekey_oncommsec == '') {
			$affl_num_samekey_oncommsec = 2;
		}
		
		$affl_link_term = get_option("affl_link_term");
    if ($affl_link_term == '') {
			$affl_link_term = 'visit';
		}

		$affl_postcontrol = get_option("affl_postcontrol");
    if ($affl_postcontrol == '') {
			$affl_postcontrol = 1;
		}

		$affl_ignoreposts = get_option("affl_ignoreposts");
		$affl_onlyposts = get_option("affl_onlyposts");
		$affl_link_on_comments = get_option("affl_link_on_comments");
		$affl_link_on_homepage = get_option("affl_link_on_homepage");

    if ($affl_link_on_comments == '') {
			$affl_link_on_comments = 0;
		}
    if ($affl_link_on_homepage == '') {
			$affl_link_on_homepage = 1;
		}

		$affl_keyword_priority = get_option("affl_keyword_priority");
		$affl_interactive_afflinks = get_option("affl_interactive_afflinks");
		if ($affl_keyword_priority == '')
		{
			$affl_keyword_priority = 0;
		}
    if ($affl_interactive_afflinks == '') {
			$affl_interactive_afflinks = 1;
		}

		$afflinker_jquery_opt = get_option("afflinker_jquery_opt");
    if ($afflinker_jquery_opt == '') {
			$afflinker_jquery_opt = 1;
		}

		$afflinker_enable = get_option("afflinker_enable");


		$affl_num_of_wordcount = get_option("affl_num_of_wordcount");
    if ($affl_num_of_wordcount == '') {
			$affl_num_of_wordcount = -1;
		}

		if ( function_exists('wp_nonce_field') )
			wp_nonce_field('AffiLinker-AFFL_gsettings');
		echo ' 		<div class="update-nag"><strong><a href="http://www.affilinker.com/affiliate-wordpress-plugin/" target = "_blank">Get AffiLinker Pro-Version</a></strong> to manage unlimited Affiliate Links and unlock all features.</div>
		<p>Do the configurations below on how you want AffiLinker to work with your wordpress blog.</p>
		<br/>
	<table class="widefat" cellspacing="10" cellpadding="10" style="background-color:#DBF1FF;box-shadow: 10px 10px 10px 10px #888888;" width="100%" >
		<tr  valign="top" >
			<td height="50px">AffiLinker Troubles You ?</td>
			<td height="50px">';
    if ($afflinker_enable == 1) {
					echo '<input type="checkbox" name="afflinker_enable" value="1" CHECKED/>&nbsp;Enable AffiLinker<br/>';
    } else {
					echo '<input type="checkbox" name="afflinker_enable" value="1" />&nbsp;Enable AffiLinker<br/>';
				}

				echo '<small>Uncheck to keep AffiLinker plugin disabled, it works only in admin area and stays slient on your blog.</small>
			</td>
		</tr>
		<tr  valign="top" >
			<td height="50px">Number of Links per Post/Page </td>
			<td height="50px"><input type="text" name="affl_num_of_keywords" size="5" value="' . $affl_num_of_keywords . '"/><br/>
				<small>Specify the number of Links to add on a particular page or blog post.</small>
			</td>
		</tr>

		<tr  valign="top" >
			<td height="50px">Number of Same Links per Post/Page </td>
			<td height="50px"><input type="text" name="affl_num_samekey_perpost" size="5" value="' . $affl_num_samekey_perpost . '"/><br/>
				<small>Specify the number of same links allowed to add on a particular page or blog post.</small>
			</td>
		</tr>

		<tr  valign="top">
			<td height="100px">Control AffiLinker by Blog Post/Page </td>
			<td height="100px">';
    if ($affl_postcontrol == 1) {
					echo '<input type="radio" name="affl_postcontrol" value="1" checked="yes" />&nbsp;Default - Show In All Blog Posts/Pages&nbsp;';
    } else {
					echo '<input type="radio" name="affl_postcontrol" value="1" />&nbsp;Default - Show In All Blog Posts/Pages&nbsp;';
				}

    if ($affl_postcontrol == 2) {
					echo '<br/> <br/><input type="radio" name="affl_postcontrol" value="2" checked="yes" />&nbsp;Ignore The Below Blog Posts/Pages';
    } else {
					echo '<br/> <br/><input type="radio" name="affl_postcontrol" value="2" />&nbsp;Ignore The Below Blog Posts/Pages';
				}

				echo '<br/><input type="text" name="affl_ignoreposts" value="' . $affl_ignoreposts . '" /> 
				<small>Specify blog post/page IDs seperated by comma, AffiLinker <strong>NEVER</strong> converts any keyword into link on these blog posts.</small>
				<br/> <br/>';

    if ($affl_postcontrol == 3) {
					echo '<input type="radio" name="affl_postcontrol" value="3" checked="yes" />&nbsp;Add Only on Below Blog Posts/Pages';
    } else {
					echo '<input type="radio" name="affl_postcontrol" value="3" />&nbsp;Add Only on Below Blog Posts/Pages';
				}

				echo '<br/><input type="text" name="affl_onlyposts" value="' . $affl_onlyposts . '"/> 
				<small>Specify blog post/page IDs seperated by comma, AffiLinker converts keyword into link <strong>ONLY</strong> on these blog posts.</small>  <br/><br/>
				 </td>
		</tr>';

		echo '<tr  valign="top" >
			<td height="50px" style="color:grey;">Minimum word count required</td>
			<td height="50px"><input type="text" name="affl_num_of_wordcount" size="5" value="' . $affl_num_of_wordcount . '" disabled /><br/>
				<small style="color:grey;">(Pro-Version only) Replaces only the blog posts/pages which has more than the specified number of words. <strong>-1</strong> represents no limit.</small>
			</td>
		</tr>

		<tr  valign="top">
			<td height="50px">Donot Add Links on Homepage</td>
			<td height="50px">';
    if ($affl_link_on_homepage == 0) {
					echo '<input type="checkbox" name="affl_link_on_homepage" value="1" />&nbsp;Donot Add<br/>
					<small>Not recommended when you show only excerpts (instead of full blog post) on homepage.</small>';
    } else {
					echo '<input type="checkbox" name="affl_link_on_homepage" value="1" CHECKED/>&nbsp;Donot Add<br/>
					<small>Not recommended when you show only excerpts (instead of full blog post) on homepage.</small>';
				}
			echo '</td>
		</tr>

		<tr  valign="top">
			<td height="50px">Add Links on Comments</td>
			<td height="50px">';
    if ($affl_link_on_comments == 1) {
					echo '<input type="checkbox" name="affl_link_on_comments" value="1" CHECKED/>&nbsp;Enable<br/>';
    } else {
					echo '<input type="checkbox" name="affl_link_on_comments" value="1" />&nbsp;Enable<br/>';
				}
			echo '</td>
		</tr>
		
		<tr  valign="top" >
			<td height="50px">Number of Links on Comment section </td>
			<td height="50px"><input type="text" name="affl_num_of_keywords_percomment" size="5" value="' . $affl_num_of_keywords_percomment . '"/><br/>
				<small>Specify the number of links to add on the comment section.</small>
			</td>
		</tr>


		<tr  valign="top" >
			<td height="50px">Number of Same Links Allowed on Comment Section </td>
			<td height="50px"><input type="text" name="affl_num_samekey_oncommsec" size="5" value="' . $affl_num_samekey_oncommsec . '"/><br/>
				<small>Specify the number of same links allowed to add on the comment section.</small>
			</td>
		</tr>
		
		<tr  valign="top">
			<td height="80px" style="color:grey;">Priority Keyword </td>
			<td height="80px">';
				if ($affl_keyword_priority == 1)
				{
					echo '<input type="radio" name="affl_keyword_priority" value="1" checked="yes" disabled />&nbsp;Enable<br/>
					<input type="radio" name="affl_keyword_priority" value="0" disabled />&nbsp;Disable<br/>';
				}
				else
				{
					echo '<input type="radio" name="affl_keyword_priority" value="1" disabled />&nbsp;Enable<br/>
					<input type="radio" name="affl_keyword_priority" value="0" checked="yes" disabled />&nbsp;Disable<br/>';
				}
				echo '<small style="color:grey;"> (Pro-Version only) When Enabled, AffiLinker will replace Priority Keywords into links first and then the replacement for Non-Priority Keywords. When Disabled, all keywords are treated as equal priority.</small>
			</td>
		</tr>

		<tr  valign="top">
			<td height="80px">Interactive Affiliate Links </td>
			<td height="80px">';
    if ($affl_interactive_afflinks == 1) {
					echo '<input type="radio" name="affl_interactive_afflinks" value="1" checked="yes" />&nbsp;Enable<br/>';
					echo '<input type="radio" name="affl_interactive_afflinks" value="0" />&nbsp;Disable<br/>';
    } else {
					echo '<input type="radio" name="affl_interactive_afflinks" value="1" />&nbsp;Enable<br/>';
					echo '<input type="radio" name="affl_interactive_afflinks" value="0" checked="yes" />&nbsp;Disable<br/>';
				}
				echo '<small>When Enabled, AffiLinker turns affiliate links into <em>interactive affiliate links</em> based on the font, size, color, link style settings as specified by you for each keyword. When Disabled, links are displayed in default style matching your blog.</small>
			</td>
		</tr>

		<tr  valign="top" >
			<td height="50px" style="color:grey;">Your choice of Link Term : </td>
			<td height="50px" style="color:grey;">http://www.yoursite.com/<input type="text" name="affl_link_term" size="15" value="' . $affl_link_term . '" disabled />/keyword-here/<br/>
				<small style="color:grey;">(Pro-Version only) Spice up the links with your own Link Term.</small>
			</td>
		</tr>

		<tr  valign="top" >
			<td height="50px">JQuery Script</td>
			<td height="50px">';
    if ($afflinker_jquery_opt == 1) {
					echo '<input type="radio" name="afflinker_jquery_opt" value="1" checked="yes" />&nbsp;Enable<br/>';
					echo '<input type="radio" name="afflinker_jquery_opt" value="0" />&nbsp;Disable<br/>';
    } else {
					echo '<input type="radio" name="afflinker_jquery_opt" value="1" />&nbsp;Enable<br/>';
					echo '<input type="radio" name="afflinker_jquery_opt" value="0" checked="yes" />&nbsp;Disable<br/>';
				}

				echo '<small>If there are any JQuery Conflicts, you can Uncheck this. By default this is Enabled.</small>
			</td>
		</tr>

		<tr  valign="top">';
			echo '<td height="50px"><input type="submit" class="button-primary" value="Save Changes" name="save-gs-changes" /></td>
			<td height="50px"><input type="hidden" name="affl_savegs_changes" value="ok" /></td>';
		echo '</tr>

	</table>
	</form>';

	echo '</div>';
}

function AffiLinker_TrackAffiliates() {
echo '<script type="text/javascript">
<!--
      function Affl_confirmAction() {
        return confirm("Do you really want to proceed?");
      }
      
 function elementHideShow(elementToHideOrShow) 
{
	var el = document.getElementById(elementToHideOrShow);
	if (el.style.display == "block") {
		el.style.display = "none";
	}
	else 
	{
		el.style.display = "block";
	}
}

function clearText(field){
    if (field.defaultValue == field.value) field.value = "";
    else if (field.value == "") field.value = field.defaultValue;

}

function changeunderlinecolor(x, color1)
{
var y=document.getElementById(x);
y.style.color = color1;
alert(y.style.color1);
}
//--></script>';
echo '<STYLE type="text/css">
<!--
    .barbg{  
       height:20px;  
      border:1px solid #A1CA68;  
      width:120px;  
      margin-left:20px;  
      float:rightright;  
      text-align:left;  
      }
      .color{  
      height:17px;  
//      background:url(images/bgraph_03.gif) repeat-x top;  
background-color: blue;
      color:#fff;  
      font-weight:bold;  
      font-family:verdana;  
      text-align:center;  
      padding-top:3px;  
    }  
//--></STYLE>';
	global $wpdb;
	$table_name = $wpdb->prefix . "affilinker_db_stat";

	if($_POST['hitcountsort']=='Sort Up') {


		$myrows = $wpdb->get_results( "SELECT * FROM ". $table_name . " GROUP BY hit_keyword ORDER BY SUM(link_hit_count) DESC");
    } else if ($_POST['hitcountsort'] == 'Sort Down') {
		$myrows = $wpdb->get_results( "SELECT * FROM ". $table_name . " GROUP BY hit_keyword ORDER BY SUM(link_hit_count) ASC");
    } else {
		$myrows = $wpdb->get_results( "SELECT * FROM ". $table_name . " GROUP BY hit_keyword");
	}

	echo '<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>';
	echo '<h2>Track Affiliate Links</h2>
	<br /><div class="update-nag"><strong><a href="http://www.affilinker.com/affiliate-wordpress-plugin/" target = "_blank">Get AffiLinker Pro-Version</a></strong> to manage unlimited Affiliate Links and unlock all features.</div>
	<br />';

?>

<?php
echo ' 		<form name="clear-stats" method="post"><input type="submit" class="button-primary" name="stats" value="Clear All Stats" /> </form>
<table class="widefat" style="table-layout:fixed;box-shadow: 10px 10px 10px 10px #888888;" cellspacing="0">
	<thead>
	<tr>
		<form name="sort-hit-count" method="post">';
				$sortlink = '?page=affilinker.php&AffiLinker_Do=sort';
				$sortlink = ( function_exists('wp_nonce_url') ) ? wp_nonce_url($sortlink, 'AffiLinker_sort') : $sortlink;

		echo '<th scope="col" ><center>Keyword</center></th>
		<th scope="col" class="manage-column" align="center"><center>Total Clicks <br/>
		<input type="submit" class="button-primary" value="Sort Up" name="hitcountsort" />
		<input type="submit" class="button-primary" value="Sort Down" name="hitcountsort" />
					</center></th>
		<th scope="col" class="manage-column"><center>Unique Clicks <br/>
<!--		<input type="submit" class="button-primary" value="Sort Up" name="hitcountsort_unq" />
		<input type="submit" class="button-primary" value="Sort Down" name="hitcountsort_unq" /> -->
					</center></th>
<!--		<th scope="col" class="manage-column"><center>% of Clicks</center></th> -->
		</form>

	</tr>
	</thead>

	<tbody class="plugins">
	';
	$table_name_stat_uniq = $wpdb->prefix . "affilinker_db_stat_uniq";
$row_counter = 1;
		foreach($myrows as $row) {

		$row_counter = $row_counter + 1;
		$bluebk = $row_counter % 2;
				
				$id = $row->id;

				$keyword = $row->hit_keyword;


				$link_hit_count = $row->link_hit_count;

				$deletelink = '?page=affilinker.php&AffiLinker_Do=delete&id='. $id;
				$deletelink = ( function_exists('wp_nonce_url') ) ? wp_nonce_url($deletelink, 'AffiLinker_delete_link') : $deletelink;

			//	echo '<li><b>Link:</b> '. $link .'   &nbsp;&nbsp;<b>Keywords:</b> '. $keywords .'  &nbsp;&nbsp; <a href="'. $deletelink .'">Delete</a></li>';
			?>

				<form name="edit-link-<?php echo $id; ?>" method="post">

				<?php
					if ( function_exists('wp_nonce_field') )
						wp_nonce_field('AffiLinker_edit_link');
				?>
		<tr <?php if ($bluebk == 1) { ?> style="background-color:#E8D9FF;" <?php } else { ?> style="background-color:#D2B0FF;" <?php } ?> >
<?php 		
$keyword1 = str_replace(array("\r\n"), ' ', $keyword);
$keyword1 = trim($keyword1);
$keyword1 = str_replace(' ', '-', $keyword1);
?>
                <td><center><?php echo '<a href=javascript:elementHideShow("' . $keyword1 . '");>';
        echo $keyword; ?></a> </center></td>
			<td><center>
			<?php 
				$query_sum = "SELECT SUM(link_hit_count) FROM " . $table_name . " WHERE hit_keyword='$keyword'";

				$result = mysql_query($query_sum);
$row = mysql_fetch_array($result);

        echo $row['SUM(link_hit_count)'];
        ?>
			</center></td>
			<td>
				<center>
					<?php 
						$myrows = $wpdb->get_results( "SELECT * FROM ". $table_name_stat_uniq . " WHERE hit_keyword='$keyword'");
						echo $wpdb->num_rows;
					?>
				</center>
			</td>

<!--			<td>
				<?php /*echo '<div class="barbg">  <div class="color" style="width: 75%;"></div>  </div>'; */?>
			</td> -->
		</tr>
		<?php 
		$mysubrows = $wpdb->get_results( "SELECT * FROM ". $table_name . " WHERE hit_keyword='$keyword'");
		$countfortablehdr = 0;
        foreach ($mysubrows as $subrow) {
            if ($countfortablehdr == 0) {
				echo '<tr><td COLSPAN="3"><table style="display:none;text-align:center;" id ="' . $keyword1 . '"><thead>
	<tr>
		<th><center>Referral URL<center></th><th><center>Total Clicks</center></th> <!-- <th>% of Clicks</th> --> </tr></thead>';
				$countfortablehdr = 1;
			}
			echo '<tr>
				<td><center>' . $subrow->referral_link . '</center></td>
				<td><center>' . $subrow->link_hit_count . '</center></td>
				<td>
					<!-- <div class="barbg"><div class="color" style="width: 75%;"></div></div> -->
				</td>
				</tr>';
		}

        if ($countfortablehdr == 1) {
			echo '</table></td></tr>';
		}
?>
	</form>

		<?php
		}

		echo '
	</tbody>

	<tfoot>
	<tr>
		<th scope="col" class="manage-column"><center>Keyword</center></th>
		<th scope="col" class="manage-column"><center>Total Clicks</center></th>
		<th scope="col" class="manage-column"><center>Unique Clicks</center></th>
<!--		<th scope="col" class="manage-column"><center>% of Clicks</center></th> -->
	</tr>
	</tfoot>
</table>

 </div>
	';

//	print_r($myrows);
}

function AffiLinker_MainPage() {
    
	global $wpdb;
	$table_name = $wpdb->prefix . "affilinker_db";

	if($_GET['AffiLinker_Do']=='sort') {

		$myrows = $wpdb->get_results( "SELECT * FROM ". $table_name . " ORDER BY link_hit_count DESC");
    } else {
		$myrows = $wpdb->get_results( "SELECT * FROM ". $table_name );
	}
	
	echo '<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>';
	echo '<h2>Manage AffiLinker</h2>
	<br /><br />

	<form name="add-link" method="post">';


if ( function_exists('wp_nonce_field') )
	wp_nonce_field('AffiLinker_add_link');

		echo ' 		<div class="update-nag"><strong><a href="http://www.affilinker.com/affiliate-wordpress-plugin/" target = "_blank">Get AffiLinker Pro-Version</a></strong> to manage unlimited Affiliate Links and unlock all features.</div>
		<table class="widefat" cellspacing="10" cellpadding="10" style="background-color:#DBF1FF;box-shadow: 10px 10px 10px 10px #888888;" width="100%" >
		<tr  valign="top" >
		<td COLSPAN="2">
		<h3>AffiLinker - Basic Options</h3><br/>
		<p>Just fill the affiliate link (not only affiliate link, you could add any URL as you like) and add the list of keywords seperated by comma below. Don"t forget to check the Interactive Options. Once you are done, click the "Quickly Add Link" button or "Add Link" button. Now all these Keywords will be replaced by Links in your blog according to your configurations.</p>
		<br/>
		</td>
		</tr>
		<tr  valign="top" >
			<td height="50px">Enter Your Ad/Affiliate Link  :</td>
			<td height="50px"><input type="text" name="link" size="65" value="http://" /></td>
		</tr>
		<tr  valign="top" >
			<td height="150px">Enter Keywords Seperated by Comma :</td>
			<td height="150px"> <!-- <input type="text" name="keywords" /> --> <textarea wrap="hard" name="keywords" rows=4 cols=65></textarea>
							<br/>
				<small>Example: <strong>Canon PowerShot, Canon Camera, canon camera, Digital Camera, Digital camera</strong></small><br/> Keywords are case-sensitive to have more control.</td>
		</tr>
		<tr  valign="top">';
			echo '<td height="50px"><input type="submit" class="button-primary" value="Quickly Add Link" name="Link" /></td>
			<td height="50px"><input type="hidden" name="aal_sent" value="ok" /></td>';
		echo '</tr>

<!--	</table> -->
		<tr  valign="top" >
		<td COLSPAN="2">
		<h3>AffiLinker - Interactive Options</h3><br/>
		<p>The following are the interactive options which helps you to turn a normal Affiliate Link into Interactive Affiliate Link. You can customize the colors, style, font size of the Link so that it appears unique and catchy to your readers.</p>
		<br/>
		</td>
		</tr>
<!--	<table class="widefat" cellspacing="10" cellpadding="10" style="background-color:#DBF1FF" width="100%"> -->
		<tr  valign="top">
			<td height="60px">Choose the Color of Link :</td>
			<td height="60px">
				<input type="text" id="afflink_color" name="link_color" />
<script type="text/javascript">
var myPicker = new jscolor.color(document.getElementById("afflink_color"), {hash:true,required:false,pickerClosable:true})
</script>
				<br/>
				<small> When not selected, it takes the default anchor text link color matching to your blog.</small>
			</td>
		</tr>
<tr  valign="top">
			<td height="60px">Choose the Background Color of Link :</td>
			<td height="60px">
				<input type="text" name="bg_color" id="affbg_color" value=""/>
<script type="text/javascript">
var myPicker = new jscolor.color(document.getElementById("affbg_color"), {hash:true,required:false,pickerClosable:true})
</script>
				<br/>
				<small> When not selected, it takes the default anchor text background color matching to your blog.</small>
			</td>
		</tr>

<tr  valign="top">
			<td height="60px">Choose the Hover Color of Link :</td>
			<td height="60px">
				<input type="text" name="hover_color" id="affhover_color" value=""/>
<script type="text/javascript">
var myPicker = new jscolor.color(document.getElementById("affhover_color"), {hash:true,required:false,pickerClosable:true})
</script>
				<br/>
				<small>Hover color effects are applicable for blog posts, pages only. When not selected, it takes the default hover color matching to your blog.</small>
			</td>
</tr>

<tr  valign="top">
			<td height="60px">Choose the Hover Background Color :</td>
			<td height="60px">
				<input type="text" name="hover_bg_color" id="affhover_bg_color" value=""/>
<script type="text/javascript">
var myPicker = new jscolor.color(document.getElementById("affhover_bg_color"), {hash:true,required:false,pickerClosable:true})
</script>
				<br/>
				<small>Hover background color effects are applicable for blog posts, pages only.  When not selected, it takes the default hover background color matching to your blog.</small>
			</td>
</tr>

		<tr  valign="top">
			<td height="50px" style="color:grey;">Link Font size :</td>
			<td height="50px">
				<select name="font_size"  disabled>
				<option value="0" selected>Default Size</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
				<option value="24">24</option>
				<option value="25">25</option>
				</select>
				<br/>
				<small style="color:grey;"> (Pro-Version only) When not selected, it takes the default anchor text font size matching to your blog.</small>
			</td>
		</tr>

		<tr  valign="top">
			<td height="50px" style="color:grey;">Link Font Name :</td>
			<td height="50px">
				<select name="font_family"  disabled>
				<option value="0" selected>Default Font</option>
				<option value="1">Arial</option>
				<option value="2">Arial Black</option>
				<option value="3">Comic</option>
				<option value="4">Comic Sans MS</option>
				<option value="5">Courier</option>
				<option value="6">Courier New</option>
				<option value="7">Franklin Gothic</option>
				<option value="8">Georgia</option>
				<option value="9">Helvetica</option>
				<option value="10">Impact</option>
				<option value="11">Lucida Sans</option>
				<option value="12">Microsoft Sans Serif</option>
				<option value="13">Monaco</option>
				<option value="14">MV Boli</option>
				<option value="15">Tahoma</option>
				<option value="16">Times</option>
				<option value="17">Times New Roman</option>
				<option value="18">Trebuchet MS</option>
				<option value="19">Verdana</option>
				</select>
<br/>
				<small style="color:grey;"> (Pro-Version only) When not selected, it takes the default anchor text font name matching to your blog.</small>
			</td>
		</tr>
		
		<tr  valign="top">
			<td height="50px">More Link Style Options :</td>
			<td height="50px">
				<input type="checkbox" name="link_style_bold" value="1"> <strong>Bold Link</strong><br/>
				<input type="checkbox" name="link_style_italics" value="1"> <em>Italics Link</em><br/>
			</td>
		</tr>

		<tr  valign="top">
			<td height="50px">Even More Link Style (Underline) Options :</td>
			<td height="50px">
<input type="radio" name="affl_underline_options" value="0" checked="yes" />&nbsp;Default Underline
<br/><br/>

<input type="radio" name="affl_underline_options" value="1" />&nbsp;
<a href="test" style="text-decoration: none; border-bottom:1px dotted;">Light Dotted</a>

&nbsp;&nbsp;&nbsp;
<input type="radio" name="affl_underline_options" value="2" />&nbsp;
<a href="test" style="text-decoration: none; border-bottom:2px dotted;">Weight Dotted </a>
<br/><br/>

<input type="radio" name="affl_underline_options" value="3" />&nbsp;
<a href="test" style="text-decoration: none; border-bottom:1px dashed;">Light Dashed</a>

&nbsp;&nbsp;&nbsp;
<input type="radio" name="affl_underline_options" value="4" />&nbsp;
<a href="test" style="text-decoration: none; border-bottom:2px dashed;">Weight Dashed</a>
<br/><br/>

<input type="radio" name="affl_underline_options" value="5" />&nbsp;
<a href="test" style="text-decoration: none; border-bottom:1px solid red;">Light Solid</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


<input type="radio" name="affl_underline_options" value="6" />&nbsp;
<a href="test" style="text-decoration: none; border-bottom:2px solid red;">Weight Solid</a>
<br/><br/>

<input type="radio" name="affl_underline_options" value="7" />&nbsp;
<a href="test" style="text-decoration: none; border-bottom:3px double;">Light Double</a>
&nbsp;&nbsp;&nbsp;&nbsp;

<input type="radio" name="affl_underline_options" value="8" />&nbsp;
<a href="test" id="my_underline_color" style="text-decoration: none; border-bottom:4px double;">Weight Double</a>
<br/><br/>

<input type="radio" name="affl_underline_options" value="9" />&nbsp;
<a href="test" style="text-decoration: underline overline;" >Line Covered</a>
<!-- <br/><br/>
				<input type="text" name="underline_color"  class="color {required:false}"  onchange="changeunderlinecolor(my_underline_color, this.value);" value=""/> -->

			</td>
		</tr>

<tr  valign="top">
			<td height="60px" style="color:grey;">Title Text :</td>
			<td height="60px">
				<input type="text" name="hover_title_text" value="" size="65" disabled />
				<br/>
				<small style="color:grey;" >(Pro-Version only) The title text that appears when your visitor hovers the mouse over an affiliate link. Leave it blank, if you don&#39;t want to use.</small>
			</td>
</tr>

<!--	</table> -->
		<tr  valign="top" >
		<td COLSPAN="2">
		<h3>AffiLinker - Control Behaviour</h3><br/>
		<p>Now you can control the behaviour of AffiLinker like how to show the Link on-page for users as well as for search engines.</p>
		<br/>
		</td>
		</tr>
	<!--	<table class="widefat" cellspacing="10" cellpadding="10" style="background-color:#DBF1FF" width="100%" > -->
		<tr  valign="top">
			<td height="50px">Make it Search Engine Friendly : </td>
			<td height="50px">
				<input type="checkbox" name="link_nofollow" value="1" CHECKED> Add NoFollow
				<br/><small><strong>Applicable only for Comment section, AffiLinker Widget. Affiliate links on Posts/Pages are always invisible to search engines.</strong></small>
			</td>
		</tr>

		<tr  valign="top">
			<td height="50px">Where to open the page once the link is clicked by user ?</td>
			<td height="50px">
				<input type="checkbox" name="link_target" value="1" CHECKED> Same Window
				<br/><small>Uncheck to open the page in new window.</small>
			</td>
		</tr>

		<tr  valign="top">
			<td height="50px">Hide Affiliate Link with Professional Link </td>
			<td height="50px">
<input type="checkbox" name="alt_link_keyword" value="1" CHECKED>&nbsp; Hide Link. <br/><small>Example: If the keyword is "buy product" and Link Term is "visit", your affiliate link will be automatically replaced by a professional link: <strong>';
    echo bloginfo('url');
    echo '/visit/buy-product/</strong></small>
			</td>
		</tr>

		<tr  valign="top">
			<td height="80px" style="color:grey;">Make this a Priority Keyword : </td>
			<td height="80px"> <input type="checkbox" name="keyword_priority" value="1"  disabled>&nbsp;<div style="color:grey;">Priority Keyword</div><br/>
				<small style="color:grey;">(Pro-Version only) When you make it Priority Keyword, AffiLinker will replace these keywords into links first and then looks for Non-Priority Keywords. This helps when you limit the number of links per post, priority keywords are given more importance than other keywords.</small> </td>
		</tr>

		<tr  valign="top">
			<td height="50px">Show these keywords in AffiLinker Cloud Widget</td>
			<td height="50px">
				<input type="checkbox" name="include_keyword" value="1" CHECKED> Show in Cloud
				<br/><small>Uncheck to exclude these keywords in AffiLinker Cloud Widget.</small>
				<br/><small>Hint: To enable widget, Go to <em>Appearance->Widget</em> and Drag-n-drop the AffiLinker Cloud widget to sidebar or footbar</small>
			</td>
		</tr>

		<tr  valign="top">';
			echo '<td height="50px"><input type="submit" class="button-primary" value="Add Link" name="Link" /></td>
			<td height="50px"><input type="hidden" name="aal_sent" value="ok" /></td>';
		echo '</tr>
	</table>
	</form>

	<br />
	<br />
			<div class="update-nag"><strong><a href="http://www.affilinker.com/affiliate-wordpress-plugin/" target = "_blank">Get AffiLinker Pro-Version</a></strong> to manage unlimited Affiliate Links and unlock all features. Now lite version supports 6 Affiliate Links.</div>
	<div id="icon-options-general" class="icon32"><br /></div>
	<a id="up"></a>
	<h2>Manage All Links</h2>
<br/>';

				$sortlink = '?page=affilinker/affilinker.php&AffiLinker_Do=sort';
				$sortlink = ( function_exists('wp_nonce_url') ) ? wp_nonce_url($sortlink, 'AffiLinker_sort') : $sortlink;
echo '
					<form name="delete-selected" method="post" onsubmit="return Affl_confirmAction();" >';

					if ( function_exists('wp_nonce_field') )
						wp_nonce_field('AffiLinker_deleteselected');


echo '					<input type="submit" class="button-primary" value="Delete Selected" name="SubmitAll" />
					<!-- <input type="hidden" name="delete_selected" value="del_sel" /> --> &nbsp;&nbsp;

	<input type="submit" class="button-primary" value="Save All Changes" name="SubmitAll" />
	<!-- <input type="hidden" name="save_all_forms" value="save_all" /> -->

<table class="widefat" style="box-shadow: 10px 10px 10px 10px #888888;" cellspacing="0" id="active-plugins-table">
	<thead>
	<tr>
		<th scope="col" class="manage-column check-column"><input type="checkbox" /></th>
		<th scope="col" class="manage-column">Affiliate Link</th>
		<th scope="col" class="manage-column">Keywords</th>
		<th scope="col" class="manage-column">Color</th>
		<th scope="col" class="manage-column">Font size</th>
		<th scope="col" class="manage-column">Font Name</th>
		<th scope="col" class="manage-column">Other Options</th>
		<th scope="col" class="manage-column"><a href="'. $sortlink .'">Hit Count</a></th>
	</tr>
	</thead>

	<tbody class="plugins">
		';
$row_counter = 1;
		foreach($myrows as $row) {

		$row_counter = $row_counter + 1;
		$bluebk = $row_counter % 2;
				
				$id = $row->id;
				$link = $row->link;
				$keywords = $row->keywords;

				$link_color = $row->link_color;
				$bg_color = $row->bg_color;
				$hover_color = $row->hover_color;
				$hover_bg_color = $row->hover_bg_color;
				$font_size = $row->font_size;

				$font_family = $row->font_family;
				$link_nofollow = $row->link_nofollow;
				$link_target = $row->link_target;
				$include_keyword = $row->include_keyword;
				$alt_link_keyword = $row->alt_link_keyword;
$keyword_priority = $row->keyword_priority;
  				$link_style_bold = $row->link_style_bold;
  				$link_style_italics = $row->link_style_italics;
$affl_underline_options = $row->affl_underline_options;
$hover_title_text = $row->hover_title_text;

$link_hit_count = $row->link_hit_count;

				$deletelink = '?page=affilinker.php&AffiLinker_Do=delete&id='. $id;
				$deletelink = ( function_exists('wp_nonce_url') ) ? wp_nonce_url($deletelink, 'AffiLinker_delete_link') : $deletelink;

			//	echo '<li><b>Link:</b> '. $link .'   &nbsp;&nbsp;<b>Keywords:</b> '. $keywords .'  &nbsp;&nbsp; <a href="'. $deletelink .'">Delete</a></li>';
			?>

				<?php
					if ( function_exists('wp_nonce_field') )
						wp_nonce_field('AffiLinker_edit_link');
				?>
		<tr <?php if ($bluebk == 1) { ?> style="background-color:#E8D9FF;" <?php } else { ?> style="background-color:#D2B0FF;" <?php } ?> >
		<td class="manage-column check-column">&nbsp;<input type="checkbox" name="checkbox1[]" value="<?php echo $id; ?>" /></td>

		<input type="hidden" name="checkboxall[]" value="<?php echo $id; ?>" />

			<td><input type="text" size="30" name="link[]" value="<?php echo $link; ?>" /></td>

			<td> <textarea wrap="hard" name="keywords[]" rows=4 cols=30><?php echo $keywords; ?></textarea>
<br/><small>Add comma seperated keywords</small>
			</td>
			<td>
				Link Color<br/>
				<input type="text" size= "7" name="link_color[]" id="affedit_link_color<?php echo $id; ?>" value="<?php echo $link_color; ?>" />
<script type="text/javascript">
var myPicker = new jscolor.color(document.getElementById("affedit_link_color<?php echo $id; ?>"), {hash:true,required:false,pickerClosable:true})
</script>
				<br/>Background Color<br/>
				<input type="text" size= "7" name="bg_color[]" id="affedit_bg_color<?php echo $id; ?>" value="<?php echo $bg_color; ?>"/>
<script type="text/javascript">
var myPicker = new jscolor.color(document.getElementById("affedit_bg_color<?php echo $id; ?>"), {hash:true,required:false,pickerClosable:true})
</script>
				<br/>Hover Color<br/>
				<input type="text" size= "7" name="hover_color[]" id="affedit_hover_color<?php echo $id; ?>" value="<?php echo $hover_color; ?>"/>
<script type="text/javascript">
var myPicker = new jscolor.color(document.getElementById("affedit_hover_color<?php echo $id; ?>"), {hash:true,required:false,pickerClosable:true})
</script>

				<br/>Hover Background Color<br/>
				<input type="text" size= "7" name="hover_bg_color[]" id="affedit_hover_bg_color<?php echo $id; ?>" value="<?php echo $hover_bg_color; ?>"/>
<script type="text/javascript">
var myPicker = new jscolor.color(document.getElementById("affedit_hover_bg_color<?php echo $id; ?>"), {hash:true,required:false,pickerClosable:true})
</script>

			</td>
			<td> <select name="font_size[]" disabled>

			<?php
				$size_array = array(0,1, 2, 3, 4, 5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25);

        foreach ($size_array as $i) {
            if ($i == $font_size) {
						echo '<option value="' . $i . '" selected>' . $i . '</option>';
            } else {
						echo '<option value="' . $i . '">' . $i . '</option>';
					}
				}
			?>
				</select></td>
			<td> <select name="font_family[]" disabled>
			<?php
				$family_array = array(
				"Default Font",
				"Arial",
				"Arial Black",
				"Comic",
				"Comic Sans MS",
				"Courier",
				"Courier New",
				"Franklin Gothic",
				"Georgia",
				"Helvetica",
				"Impact",
				"Lucida Sans",
				"Microsoft Sans Serif",
				"Monaco",
				"MV Boli",
				"Tahoma",
				"Times",
				"Times New Roman",
				"Trebuchet MS",
				"Verdana");
				$familyid_array = array(0,1, 2, 3, 4, 5,6,7,8,9,10,11,12,13,14,15,16,17,18,19);

        foreach ($familyid_array as $i) {
            if ($i == $font_family) {
						echo '<option value="' . $i . '" selected>' . $family_array[$i] . '</option>';
            } else {
						echo '<option value="' . $i . '">' . $family_array[$i] . '</option>';
					}
				}
			?>

				</select>
			</td>
			<td>
			<?php
				if ($keyword_priority == 1)
				{
					echo '<input type="checkbox" name="keyword_priority[]" value="'. $id . '" CHECKED disabled> Priority Keyword<br/>';
				}
				else
				{
					echo '<input type="checkbox" name="keyword_priority[]" value="'. $id . '" disabled> Priority Keyword<br/>';
				}

        if ($alt_link_keyword == 1) {
					echo '<input type="checkbox" name="alt_link_keyword[]" value="'. $id . '" CHECKED> Hide Affiliate Link<br/>';
        } else {
					echo '<input type="checkbox" name="alt_link_keyword[]" value="'. $id . '"> Hide Affiliate Link<br/>';
				}

        if ($link_nofollow == 1) {
					echo '<input type="checkbox" name="link_nofollow[]" value="'. $id . '" CHECKED> Add NoFollow<br/>';
        } else {
					echo '<input type="checkbox" name="link_nofollow[]" value="'. $id . '"> Add NoFollow<br/>';
				}
			?>
			<?php
        if ($link_target == 1) {
					echo '<input type="checkbox" name="link_target[]" value="'. $id . '" CHECKED> Same Window<br/>';
        } else {
					echo '<input type="checkbox" name="link_target[]" value="'. $id . '"> Same Window<br/>';
				}

        if ($link_style_bold == 1) {
					echo '<input type="checkbox" name="link_style_bold[]" value="'. $id . '" CHECKED> <strong>Bold</strong><br/>';
        } else {
					echo '<input type="checkbox" name="link_style_bold[]" value="'. $id . '"> <strong>Bold</strong><br/>';
				}

        if ($link_style_italics == 1) {
					echo '<input type="checkbox" name="link_style_italics[]" value="'. $id . '" CHECKED> <em>Italics</em><br/>';
        } else {
					echo '<input type="checkbox" name="link_style_italics[]" value="'. $id . '"> <em>Italics</em><br/>';
				}

        if ($include_keyword == 1) {
					echo '<input type="checkbox" name="include_keyword[]" value="'. $id . '" CHECKED> Show in Cloud<br/>';
        } else {
					echo '<input type="checkbox" name="include_keyword[]" value="'. $id . '"> Show in Cloud<br/>';
				}
				$affl_underline_options_id_array = array(0,1, 2, 3, 4, 5,6,7,8,9);
$affl_underline_options_name_array = array(
	"Default Underline",
	"Light Dotted",
	"Weight Dotted",
	"Light Dashed",
	"Weight Dashed",
	"Light Solid",
	"Weight Solid",
	"Light Double",
	"Weight Double",
	"Line Covered" );
				echo '<select name="affl_underline_options[]">';
        foreach ($affl_underline_options_id_array as $i) {
            if ($i == $affl_underline_options) {
						echo '<option value="' . $i . '" selected>' . $affl_underline_options_name_array[$i] . '</option>';
            } else {
						echo '<option value="' . $i . '">' . $affl_underline_options_name_array[$i] . '</option>';
					}
				}
				echo '</select>';

					echo '<br/>Title: <input type="text" name="hover_title_text[]" value="' . $hover_title_text . '" size="10" disabled><br/>';
			?>
			</td>
<td>
<?php echo $link_hit_count; ?>
</td>


		</tr>

				
		<?php
		}

		echo '
	</tbody>

	<tfoot>
	<tr>
		<th scope="col" class="manage-column check-column"><input type="checkbox" /></th>
		<th scope="col" class="manage-column">Affiliate Link</th>
		<th scope="col" class="manage-column">Keywords</th>
		<th scope="col" class="manage-column">Color</th>
		<th scope="col" class="manage-column">Font size</th>
		<th scope="col" class="manage-column">Font Name</th>
		<th scope="col" class="manage-column">Other Options</th>
		<th scope="col" class="manage-column">Hit Count</th>
	</tr>
	</tfoot>
</table>
	<input type="submit" class="button-primary" value="Delete Selected" name="SubmitAll" />
	<!-- <input type="hidden" name="delete_selected" value="del_sel" /> --> &nbsp;&nbsp;

	<input type="submit" class="button-primary" value="Save All Changes" name="SubmitAll" />
	<!-- <input type="hidden" name="save_all_forms" value="save_all" /> -->

</form>
<a id="down"></a>
 </div>
 <br/><div class="update-nag"><strong><a href="http://www.affilinker.com/affiliate-wordpress-plugin/" target = "_blank">Get AffiLinker Pro-Version</a></strong> to manage unlimited Affiliate Links and unlock all features. Now lite version supports 6 Affiliate Links.</div>
	';

//	print_r($myrows);
}

global $replace_count_per_keyword;
global $ascript;
global $cssscript;

$prev_comment_text = 'A';

function AffiLinker_InsertAffiliateLinksToComment($comment) {

	global $prev_comment_text;

    if ($prev_comment_text != $comment) {
		$prev_comment_text = $comment;
    } else if ($prev_comment_text == $comment) {
		return $comment;
	}

	$affl_link_on_comments = get_option("affl_link_on_comments");
    if ($affl_link_on_comments == 1) {
		$number_of_keywords2replace1 = get_option("affl_num_of_keywords_percomment") - $GLOBALS['number_of_keywordsreplaced'];

	//	echo '[' . $number_of_keywords2replace1 . ']';

        if ($number_of_keywords2replace1 > 0) {
			$comment->comment_content = AffiLinker_InsertAffiliateLinks($comment->comment_content, 1, $number_of_keywords2replace1);

		//	echo $comment->comment_content;

		}
	}
	return $comment;
}

function my_custom_jscript() {
	global $ascript;
	global $cssscript;
/*
    if ($ascript != '') {
		$afflinker_jquery_opt = get_option("afflinker_jquery_opt");
        if ($afflinker_jquery_opt == '') {
			$afflinker_jquery_opt = 1;
			update_option("afflinker_jquery_opt", $afflinker_jquery_opt);
		}

        if ($afflinker_jquery_opt == 1) {
			echo "<script type='text/javascript' src = 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js' ></script>";
		}
		echo "<script type='text/javascript'>//<![CDATA[ 
function getme(el){var s=el.length;var l='';var id=0;while(id <s){l=l+(String.fromCharCode(el.charCodeAt(id)-2));id=id+1;}return l;}

		    jQuery(document).ready(function(){" . $ascript . "
		});//]]>
		</script>";
	}
*/
    if ($cssscript != '') {
		echo $cssscript;
	}
}

function getencryptedLink($linkhead) {
	$linkhead_e = '';
	$len = strlen($linkhead);
	$id = 0;
    while ($id < $len) {
		$linkhead_e = $linkhead_e . chr(ord($linkhead[$id])+2);
		$id = $id + 1;
	}

	return	$linkhead_e;
}

function detectUTF8($string) {
        return preg_match('%(?:
        [\xC2-\xDF][\x80-\xBF]        # non-overlong 2-byte
        |\xE0[\xA0-\xBF][\x80-\xBF]               # excluding overlongs
        |[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}      # straight 3-byte
        |\xED[\x80-\x9F][\x80-\xBF]               # excluding surrogates
        |\xF0[\x90-\xBF][\x80-\xBF]{2}    # planes 1-3
        |[\xF1-\xF3][\x80-\xBF]{3}                  # planes 4-15
        |\xF4[\x80-\x8F][\x80-\xBF]{2}    # plane 16
        )+%xs', $string);
}

function AffiLinker_InsertAffiliateLinks($content, $affl_comment_callback = 0, $number_of_keywords2replace = 0) {
    if (get_option("affl_link_on_homepage") != 0) {
        if (is_home()) {
			return	$content;
		}
	}

	global $ascript;
	global $cssscript;
	global $link;
	global $linkformat;
	global $linkformat4comm;
	global $linknofollow;
	global $linklink_target;
	global $linkhead;
	global $linkclass;
    global $linkhovertitle;
	
	$afflinker_enable = get_option("afflinker_enable");

    if ($afflinker_enable == 0) {
		return	$content;
	}

	global $wp_query;
	$thePostID = $wp_query->post->ID;

	$affl_postcontrol = get_option("affl_postcontrol");

    if ($affl_comment_callback != 1) { // $uperb fix, intelligent fellow
		$ascript = '';
        //$cssscript = ''; //commented to disable js based links
	}
	
    if ($affl_postcontrol == 2) {
		$affl_ignoreposts = get_option("affl_ignoreposts");
		$affl_ignoreposts_list = explode(',',$affl_ignoreposts);

        foreach ($affl_ignoreposts_list as $ignoreposts_list) {
			$ignoreposts_list = trim($ignoreposts_list);

            if ($ignoreposts_list == $thePostID) {
				return	$content;
			}
		}
    } else if ($affl_postcontrol == 3) {
		$affl_onlyposts = get_option("affl_onlyposts");
		$affl_onlyposts_list = explode(',',$affl_onlyposts);

		$continue_key_replace = 0;
        foreach ($affl_onlyposts_list as $onlyposts_list) {
			$onlyposts_list = trim($onlyposts_list);

            if ($onlyposts_list == $thePostID) {
				$continue_key_replace = 1;
				break;
			}
		}

        if ($continue_key_replace == 0) {
			return	$content;
		}
	}

	$affl_num_of_wordcount = get_option("affl_num_of_wordcount");
	$affl_num_of_wordcount_tot = sizeof(explode(' ',$content));

    if ($affl_num_of_wordcount != -1) {
        if ($affl_num_of_wordcount_tot < $affl_num_of_wordcount) {
			return	$content;
		}
	}

	// get number replaces allowed per keyword

    if ($affl_comment_callback == 1) {
		$replace_count_per_keyword = get_option("affl_num_samekey_oncommsec");
    } else {
		$replace_count_per_keyword = get_option("affl_num_samekey_perpost");
	}

	$affl_interactive_afflinks = get_option("affl_interactive_afflinks");
	$affl_link_term = get_option("affl_link_term");

	$affl_underline_options_array = array(
	"",
	"text-decoration: none; border-bottom:1px dotted;",
	"text-decoration: none; border-bottom:2px dotted;",
	"text-decoration: none; border-bottom:1px dashed;",
	"text-decoration: none; border-bottom:2px dashed;",
	"text-decoration: none; border-bottom:1px solid red;",
	"text-decoration: none; border-bottom:2px solid red;",
	"text-decoration: none; border-bottom:3px double;",
	"text-decoration: none; border-bottom:4px double;",
	"text-decoration: underline overline;" );
				$family_array = array(
				"Default Font",
				"Arial",
				"Arial Black",
				"Comic",
				"Comic Sans MS",
				"Courier",
				"Courier New",
				"Franklin Gothic",
				"Georgia",
				"Helvetica",
				"Impact",
				"Lucida Sans",
				"Microsoft Sans Serif",
				"Monaco",
				"MV Boli",
				"Tahoma",
				"Times",
				"Times New Roman",
				"Trebuchet MS",
				"Verdana");
$keyword_counter = 0;
$replaced_counter = 0;
$replaced_countervalue = 0;

$affl_keyword_priority_enable = get_option("affl_keyword_priority");
    if ($affl_keyword_priority_enable == 1) {
	$priority_keys_done = 0; // first pri keywords
    } else {
	$priority_keys_done = 2;
}

    while (1) {
		global $wpdb;
		$table_name = $wpdb->prefix . "affilinker_db";
        if ($priority_keys_done == 0) {
//								echo '----PRI----';
			$myrows = $wpdb->get_results( "SELECT id,link,keywords, alt_link_keyword, link_color, bg_color,hover_color,hover_bg_color, font_size, font_family, link_style_bold, link_style_italics, affl_underline_options, link_nofollow, link_target, include_keyword, hover_title_text  FROM ". $table_name . " WHERE keyword_priority <> 1");
		}
		else if ($priority_keys_done == 1)
		{
//								echo '----NPRI----';
			$myrows = $wpdb->get_results( "SELECT id,link,keywords, alt_link_keyword, link_color, bg_color, hover_color,hover_bg_color, font_size, font_family, link_style_bold, link_style_italics, affl_underline_options,  link_nofollow, link_target, include_keyword, hover_title_text  FROM ". $table_name . " WHERE keyword_priority <> 1" );
        } else if ($priority_keys_done == 2) {
//								echo '----ALL----';

			$myrows = $wpdb->get_results( "SELECT id,link,keywords, alt_link_keyword, link_color, bg_color, hover_color,hover_bg_color, font_size, font_family, link_style_bold, link_style_italics,affl_underline_options,  link_nofollow, link_target, include_keyword, hover_title_text  FROM ". $table_name);
		}
				$patterns = array();
        if ($affl_comment_callback == 1) {
			$keyword_replace_totcount = $number_of_keywords2replace; //get_option("affl_num_of_keywords_percomment");
        } else {
			$keyword_replace_totcount = get_option("affl_num_of_keywords");

			// first comment callback, reset the replaced count
			$GLOBALS['number_of_keywordsreplaced'] = 0;
		}

        if ($keyword_replace_totcount <= 0) {
			// nothing to replace
			return $content;
		}

        if (is_null($myrows)) {
            if ($priority_keys_done == 0) {
				$priority_keys_done = 1; //pri keywords done
				//goto find_more_keys;
				continue;
			}
					add_action('wp_footer', 'my_custom_jscript');
			return $content;
        } else {
            foreach ($myrows as $row) {
				//	$link = $row->link;
				$link =  'http://'.$_SERVER['HTTP_HOST'] . '/' . $affl_link_term . '/'. $row->alt_link_keyword . '/';
				$keywords = $row->keywords;

                if (!is_null($keywords)) {
					$keys = explode(',',$keywords);

                    foreach ($keys as $key) {
						$key = trim($key);

                        if (1) {
                            if ($row->alt_link_keyword == 1) {
								$link =  'http://'.$_SERVER['HTTP_HOST'] . '/' . $affl_link_term . '/'. str_replace(' ','-',$key) . '/';
                            } else {
								$link = $row->link;
							}

							$link = strtolower($link);




							$d = new DOMDocument();


							@$d->loadHTML('<?xml encoding="UTF-8">'.$content);

							foreach ($d->childNodes as $item)
							if ($item->nodeType == XML_PI_NODE)
							$d->removeChild($item);
							$d->encoding = 'UTF-8';

							$x = new DOMXpath($d);

							$aff_query_result =	$x->query("//text()[
							   contains(.,'".$key."')
							   and not(ancestor::h1) 
							   and not(ancestor::h2) 
							   and not(ancestor::h3) 
							   and not(ancestor::h4) 
							   and not(ancestor::h5) 
							   and not(ancestor::h6)
							   and not(ancestor::a)
							   and not(ancestor::img)]");

                            if (!empty($aff_query_result)) {
                                foreach ($aff_query_result as $node) {
                                    if ($affl_interactive_afflinks == 0) {
										$randno4css = 'c' . rand();
										$linkclass = 'class ="' . $randno4css . '"';
                                    } else if ($affl_interactive_afflinks == 1)
                                        if ((!is_null($row->link_color)) || (!is_null($row->bg_color)) || (!is_null($row->hover_color)) || (!is_null($row->hover_bg_color)) || ($row->font_size != 0) || ($row->font_family != 0) || ($row->link_style_bold == 1) || ($row->link_style_italics == 1)) {
                                            if ($affl_comment_callback != 1) {
											$randno4css = 'c' . rand();
                                                $randno4cssid = $randno4css . 'id'; // id for hiding A tag
											

											$linkformat = '';

                                                if ($row->link_color != '') {
												$linkformat = $linkformat . 'color:' . $row->link_color . ';';
											}

											//if (!is_null($row->bg_color))
                                                if ($row->bg_color != '') {
												$linkformat = $linkformat . 'background-color:' . $row->bg_color . ';';
											}

                                                if ($row->font_size != 0) {
												$linkformat = $linkformat . 'font-size:' . $row->font_size . 'px;';
											}

                                                if ($row->font_family != 0) {
												$linkformat = $linkformat . 'font-family:' . $family_array[$row->font_family] . ';';
											}

                                                if ($row->link_style_bold == 1) {
												$linkformat = $linkformat . 'font-weight:bold;';
											}

                                                if ($row->link_style_italics == 1) {
												$linkformat = $linkformat . 'font-style:italic;';
											}

                                                if ($row->affl_underline_options != 0) {
												$linkformat = $linkformat . $affl_underline_options_array[$row->affl_underline_options];
											}

											if ($linkformat != '')
												$linkformat = '<style type="text/css"> #'.$randno4cssid . '{' . $linkformat . '}';

                                                if (($row->hover_color != '') || ($row->hover_bg_color != '')) {
												$linkformat = $linkformat . " #" . $randno4cssid . ":hover{";

												if ($row->hover_color != '')
													$linkformat = $linkformat . "color:" . $row->hover_color . ";";
												if ($row->hover_bg_color != '')
													$linkformat = $linkformat . "background-color:" . $row->hover_bg_color . ";";

												$linkformat = $linkformat . "}";
											}

											if ($linkformat != '')
												$linkformat = $linkformat . "</style>";

											// id for span tag
                                                $linkclass = 'id ="' . $randno4css . 'id"';
										}
                                            else {
											$linkformat4comm = 'style="';

                                                if ($row->link_color != '') {
												$linkformat4comm = $linkformat4comm . 'color:' . $row->link_color . ';';
											}

                                                if ($row->bg_color != '') {
												$linkformat4comm = $linkformat4comm . 'background-color:' . $row->bg_color . ';';
											}

                                                if ($row->font_size != 0) {
												$linkformat4comm = $linkformat4comm . 'font-size:' . $row->font_size . 'px;';
											}

                                                if ($row->font_family != 0) {
												$linkformat4comm = $linkformat4comm . 'font-family:' . $family_array[$row->font_family] . ';';
											}

                                                if ($row->link_style_bold == 1) {
												$linkformat4comm = $linkformat4comm . 'font-weight:bold;';
											}

                                                if ($row->link_style_italics == 1) {
												$linkformat4comm = $linkformat4comm . 'font-style:italic;';
											}

                                                if ($row->affl_underline_options != 0) {
												$linkformat4comm = $linkformat4comm . $affl_underline_options_array[$row->affl_underline_options];
											}

											$linkformat4comm = $linkformat4comm . '"';
										}
									}

                                    if ($row->link_nofollow == 1) {
										$linknofollow = ' rel = "nofollow"';
                                    } else {
										$linknofollow = '';
									}

                                    if ($row->link_target == 1) {
										$linklink_target = ' target = "_self" ';
                                    } else {
										$linklink_target = ' target = "_blank" ';
									}

                                    if (!is_null($row->hover_title_text) && $row->hover_title_text != '') {
                                        $linkhovertitle = "title='" . $row->hover_title_text . "'";
                                    }
									$linkhead =  '"' . $link . '" ';
									
									$patterns[0] = '|\\b' . $key . '\\b|';
                                    if ($affl_comment_callback != 1) {
										$textContent = preg_replace_callback( 
										              $patterns[0]
                                                , create_function('$m', 'global $link;global $linkformat;global $linknofollow;global $linklink_target;global $linkhead;global $linkclass; global $linkhovertitle;
																 $replacements[0] = "<a " . $linkclass . " href=" . $linkhead .  " " . $linknofollow . " " . $linklink_target . " " . $linkhovertitle . ">". $m[0] ."</a>";
//$replacements[0] = "<span " . str_replace("class", "id",$linkclass) .  ">". $m[0] ."</span>";
													                 	return $replacements[0];')

										            ,$node->textContent, 1, $replaced_countervalue
										    );

											//$linkhead = str_replace(array('http://','"', ' '), '', $linkhead);
											$linkhead = str_replace('"', '', $linkhead);
										    $cssscript = $cssscript . $linkformat;

										    if (detectUTF8($key) == 0)
												$ascript = $ascript . "jQuery('#" . $randno4css . "').wrapInner(jQuery('<a />').attr('href', function(){return getme('" . getencryptedLink($linkhead) . "');})";
											else
												$ascript = $ascript . "jQuery('#" . $randno4css . "').wrapInner(jQuery('<a />').attr('href', function(){return '" . $linkhead . "';})";
												
                                        if ($affl_interactive_afflinks == 1) {
												//$ascript = $ascript . ".attr('style', 'color:" . $row->link_color . ";')";
												$ascript = $ascript . ".attr('id', '" . $randno4cssid . "')";
											}
                                        if ($row->link_target == 1) {
												$ascript = $ascript . ".attr({target:'_self'})";
                                        } else {
												$ascript = $ascript . ".attr({target:'_blank'})";
											}
												$ascript = $ascript . ".attr({rel:'nofollow'})";
                                        if (!is_null($row->hover_title_text)) {
	$ascript = $ascript . ".attr({title:'" . $row->hover_title_text . "'})";
}
											$ascript = $ascript . ");";
                                    } else {
								//	echo $linkformat4comm;
										$textContent = preg_replace_callback( 
										              $patterns[0]
										            , create_function('$m', 'global $link;global $linkformat4comm;global $linknofollow;global $linklink_target;global $linkhead;global $linkclass;
																$replacements[0] = "<a " . $linkformat4comm . " href=" . $linkhead .  " " . $linknofollow . " " . $linklink_target . ">". $m[0] ."</a>";
													                 	return $replacements[0];')

										            ,$node->textContent, 1, $replaced_countervalue
										    );
									}

									$replaced_counter = $replaced_counter + $replaced_countervalue;

                                    if ($replaced_counter > $keyword_replace_totcount) {
										break;
									}

                                    if ($replaced_countervalue > 0) {
                                        if ($replaced_keywords [$key] == ' ') {
											$replaced_keywords [$key] = 0;
										}
										
										$replaced_keywords [$key] = $replaced_keywords [$key] + 1;
//										echo '[' . $key . ' - ' . $replaced_keywords [$key] . ']';

                                        if ($replaced_keywords [$key] <= $replace_count_per_keyword) {
                                            if ($affl_comment_callback == 1) {
												// note down replaced count for comment
												$GLOBALS['number_of_keywordsreplaced'] = $GLOBALS['number_of_keywordsreplaced'] + 1;
											}


											$textContent = str_replace (array('&amp;','&', '&#38;'), ' affhack1 ',$textContent);

											$newNode  = $d->createDocumentFragment();
											$newNode->appendXML($textContent);
											$node->parentNode->replaceChild($newNode, $node);

											$content = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $d->saveHTML()));
											$content = str_replace(array('&acirc;&#128;&#152;','&acirc;&#128;&#153;', '&acirc;&#128;&#156;' , '&acirc;&#128;&#157;', '~\x2013~', '~\x2014~','~\x8E~',' affhack1 ', '&Acirc;'), array( '&#8216;', '&#8217;', '&#8220;', '&#8221;', '&#8211;', '&#8212;','','&amp;',''), $content);
                                        } else {
											$replaced_keywords [$key] = $replaced_keywords [$key] - 1;
											$replaced_counter = $replaced_counter - 1;
										}

//										echo '[' . $replaced_counter .'-' . $affl_comment_callback . ']';
									}
								}
							}
						}


                        if ($replaced_counter > $keyword_replace_totcount) {
//							echo '[END]';
							break;
						}
					}
				}

                if ($replaced_counter > $keyword_replace_totcount) {
					break;
				}
			}

            if ($replaced_counter < $keyword_replace_totcount) {
//							echo '----MORE----';
                if ($priority_keys_done == 0) {
						$priority_keys_done = 1; //pri keywords done

						//goto find_more_keys;
						continue;
					}

					add_action('wp_footer', 'my_custom_jscript');

					// there are 0 replacements
					return $content;


					}
				}

        if ($replaced_counter >= $keyword_replace_totcount) {
			break;
		}
	}
	add_action('wp_footer', 'my_custom_jscript');
	return $content;
}


// Installation

register_activation_hook(__FILE__,'AffiLinker_Install');


function AffiLinker_Install() {
	global $wpdb;
	$table_name = $wpdb->prefix . "affilinker_db";

	$affilinker_db_version = "200";
			
    if (strcasecmp($wpdb->get_var("SHOW TABLES LIKE '$table_name'"), $table_name) != 0) {
		add_option("affilinker_db_version", $affilinker_db_version);
		add_option("affl_num_of_keywords", 5);
		add_option("affl_num_of_keywords_percomment", 5);
		add_option("affl_postcontrol", 1);
		add_option("affl_ignoreposts", "0,1,2");
		add_option("affl_onlyposts", "2,1, 0");
		add_option("affl_link_on_comments", 0);
		add_option("affl_link_on_homepage", 1);
		
		add_option("affl_keyword_priority", 0);
		add_option("affl_interactive_afflinks", 1);
		add_option("afflinker_enable", 1);
		add_option("affl_num_of_wordcount", -1);

		add_option("affl_widget_title", "");
		add_option("affl_widget_no_keywords", 10);
		add_option("affl_widget_type", 0);
		add_option("affl_widget_font_startpx", 10);
		add_option("affl_widget_font_endpx", 25);
		add_option("affl_widget_interactive_opt", 0);
		add_option("affl_widget_avoid_dup", 0);

		add_option("affl_num_samekey_perpost", 2);
		add_option("affl_num_samekey_oncommsec", 2);
		add_option("affl_num_enable", 0);
		add_option("affl_num_count", 0);
		add_option("affl_link_term", 'visit');

		add_option("affl_updurl", '');
		add_option("affl_updav", 10);
	}
		$sql = "CREATE TABLE " . $table_name . " (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  link text NOT NULL,
	  keywords text,
	  link_color text,
	  bg_color text,
	  hover_color text,
	  hover_bg_color text,
	  font_size int(12),
	  font_family text,
	  link_style_bold int(12),
	  link_style_italics int(12),
	  affl_underline_options int(12) NOT NULL,
	  link_nofollow int(12) NOT NULL,
	  link_target int(12) NOT NULL,
	  include_keyword int(12) NOT NULL,
	  alt_link_keyword int(12) NOT NULL,
	  link_hit_count int(12),
	 keyword_priority int(12) NOT NULL,
	  hover_title_text text,
	  UNIQUE KEY id (id)
	);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

	$table_name = $wpdb->prefix . "affilinker_db_stat";

		$sql = "CREATE TABLE " . $table_name . " (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  referral_link text,
	  hit_keyword text,
	  link_hit_count int(12),
	  UNIQUE KEY id (id)
	);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

	$table_name = $wpdb->prefix . "affilinker_db_stat_uniq";

	$sql = "CREATE TABLE " . $table_name . " (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  hit_keyword text,
	  affl_ip_address text,
	  UNIQUE KEY id (id)
	);";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);

	update_option("affilinker_db_version", $affilinker_db_version);
}

?>
