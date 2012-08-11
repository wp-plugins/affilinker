<?php
/*
Plugin Name: AffiLinker
Plugin URI: http://www.affilinker.com
Description: Automatically convert given keywords into Search Engine Friendly Affiliate Links (+colorful interactive links) throughout your blog. Show Affiliate Link Cloud similar to Tag Cloud.
Author: Mr.Ven
Version: 1.0.0
Author URI: http://www.blasho.com/about
*/

add_action('admin_init', 'AffiLinker_Operations');
add_action('admin_menu', 'AffiLinker_CreateMenu');
add_filter('the_content', 'AffiLinker_InsertAffiliateLinks');
add_filter('get_comment', 'AffiLinker_InsertAffiliateLinksToComment');
add_action( 'widgets_init', 'AffiLinker_create_ad_widget' );
add_action('init', 'AffiLinker_NavigateToLink');

$link = '';
$linkformat = '';
$linkformat4comm = '';
$linknofollow  = '';
$linklink_target = '';
$linkhead = '';
$linkclass = '';
$afflt = array( "AffiLinker Activation Form", "AffiLinker - General Settings" );

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

	echo "\n" . $before_title; echo $affl_widget_title; echo $after_title;

	global $wpdb;
	$table_name = $wpdb->prefix . "AffiLinker_db";

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

	foreach($myrows as $row)
	{
		if ($affl_widget_no_keywords == 0)
			break;
			
		if(!is_null($row->keywords))
		{
			if ($row->include_keyword != 1)
				continue;
				
			$keys = explode(',',$row->keywords);

			foreach($keys as $key) 
			{
				$key = trim($key);
				$direct_style = 0;
				if ($affl_widget_interactive_opt == 1)
				{
					if ( (!is_null($row->link_color)) || (!is_null($row->bg_color)) || (!is_null($row->hover_color)) || (!is_null($row->hover_bg_color))  ||  ($row->font_family != 0) || ($row->link_style_bold == 1) || ($row->link_style_italics == 1)  || ($affl_widget_type == 21))
					{
						$randno4css = 'cw'. rand();

						$linkformat = '<style type="text/css"> a.'.$randno4css . '{';

						if ($affl_widget_type == 21)
						{
							$linkformat = $linkformat . 'font-size:' . rand($affl_widget_font_startpx,$affl_widget_font_endpx) . 'px;';
						}

						if ($row->link_color != '')
						{
							$linkformat = $linkformat . 'color:' . $row->link_color . ';';
						}

						if ($row->bg_color != '')
						{
							$linkformat = $linkformat . 'background-color:' . $row->bg_color . ';';
						}

						if ($row->font_size != 0)
						{
							//$linkformat = $linkformat . 'font-size:' . $row->font_size . 'px;';
						}

						if ($row->font_family != 0)
						{
							$linkformat = $linkformat . 'font-family:' . $family_array[$row->font_family] . ';';
						}

						if ($row->link_style_bold == 1)
						{
							$linkformat = $linkformat . 'font-weight:bold;';
						}

						if ($row->link_style_italics == 1)
						{
							$linkformat = $linkformat . 'font-style:italic;';
						}

						if ($row->affl_underline_options != 0)
						{
							$linkformat = $linkformat . $affl_underline_options_array[$row->affl_underline_options];
						}

						$linkformat = $linkformat . "}";

						if ( ($row->hover_color != '') || ($row->hover_bg_color != '') )
						{
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
				else
				{
					if ($affl_widget_type == 21)
					{
						$linkformat = 'style="';

						$linkformat = $linkformat . 'font-size:' . rand($affl_widget_font_startpx,$affl_widget_font_endpx) . 'px;';

						$linkformat = $linkformat . '"';

						$direct_style = 2;
					}
				}

				if ($row->link_nofollow == 1)
				{
					$linknofollow = ' rel = "nofollow" ';
				}
				else
				{
					$linknofollow = ' ';
				}

				if ($row->link_target == 1)
				{
					$linklink_target = ' target = "_self" ';
				}
				else
				{
					$linklink_target = ' target = "_blank" ';
				}

				if ($row->alt_link_keyword == 1)
				{
//					echo '*' . $key . '*[' . str_replace(' ','-',$key) . ']';


					$link =  'http://'.$_SERVER['HTTP_HOST'] . '/' . $affl_link_term . '/'. str_replace(' ','-',$key) . '/';
				}
				else
				{
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

				if (($affl_widget_avoid_dup == 1) || ($affl_widget_no_keywords_counter == $affl_widget_no_keywords))
				{
					break;
				}
			}
		}

		if ($affl_widget_no_keywords_counter == $affl_widget_no_keywords)
		{
			break;
		}
	}
	
	if ($affl_widget_type == 20)
		echo '</ul>';

	//echo $after_title;
	
	//wp125_write_ads();
	echo $after_widget;
}

    function update($new_instance, $old_instance) {
        //update and save the widget

	return $new_instance;
    }

    	function form($instance)
    	{
			$code=file_get_contents(WP_PLUGIN_DIR."/affilinker/affwfe.php");
		    $code=str_replace('<'.'?php','<'.'?',$code);
		    $code='?'.'>'.trim($code).'<'.'?';
		    eval($code);
 		}
}

function myplugin_register_widgets() {
	register_widget( 'My_Recent_Posts_Widget' );
}




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

	echo "\n" . $before_title; echo $affl_widget_title; echo $after_title;

	global $wpdb;
	$table_name = $wpdb->prefix . "AffiLinker_db";

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

	foreach($myrows as $row)
	{
		if ($affl_widget_no_keywords == 0)
			break;
			
		if(!is_null($row->keywords))
		{
			if ($row->include_keyword != 1)
				continue;

			$keys = explode(',',$row->keywords);

			foreach($keys as $key) 
			{
				$key = trim($key);
				$direct_style = 0;
				if ($affl_widget_interactive_opt == 1)
				{
					if ( (!is_null($row->link_color)) || (!is_null($row->bg_color)) || (!is_null($row->hover_color)) || (!is_null($row->hover_bg_color))  ||  ($row->font_family != 0) || ($row->link_style_bold == 1) || ($row->link_style_italics == 1)  || ($affl_widget_type == 1))
					{
						$randno4css = 'cw'. rand();

						$linkformat = '<style type="text/css"> a.'.$randno4css . '{';

						if ($affl_widget_type == 1)
						{
							$linkformat = $linkformat . 'font-size:' . rand($affl_widget_font_startpx,$affl_widget_font_endpx) . 'px;';
						}

						if ($row->link_color != '')
						{
							$linkformat = $linkformat . 'color:' . $row->link_color . ';';
						}

						if ($row->bg_color != '')
						{
							$linkformat = $linkformat . 'background-color:' . $row->bg_color . ';';
						}

						if ($row->font_size != 0)
						{
							$linkformat = $linkformat . 'font-size:' . $row->font_size . 'px;';
						}

						if ($row->font_family != 0)
						{
							$linkformat = $linkformat . 'font-family:' . $family_array[$row->font_family] . ';';
						}

						if ($row->link_style_bold == 1)
						{
							$linkformat = $linkformat . 'font-weight:bold;';
						}

						if ($row->link_style_italics == 1)
						{
							$linkformat = $linkformat . 'font-style:italic;';
						}

						if ($row->affl_underline_options != 0)
						{
							$linkformat = $linkformat . $affl_underline_options_array[$row->affl_underline_options];
						}

						$linkformat = $linkformat . "}";

						if ( ($row->hover_color != '') || ($row->hover_bg_color != '') )
						{
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
				else
				{
					if ($affl_widget_type == 1)
					{
						$linkformat = 'style="';

						$linkformat = $linkformat . 'font-size:' . rand($affl_widget_font_startpx,$affl_widget_font_endpx) . 'px;';

						$linkformat = $linkformat . '"';

						$direct_style = 2;
					}
				}

				if ($row->link_nofollow == 1)
				{
					$linknofollow = ' rel = "nofollow" ';
				}
				else
				{
					$linknofollow = ' ';
				}

				if ($row->link_target == 1)
				{
					$linklink_target = ' target = "_self" ';
				}
				else
				{
					$linklink_target = ' target = "_blank" ';
				}

				if ($row->alt_link_keyword == 1)
				{
					echo '*' . $key . '*';
					$link =  'http://'.$_SERVER['HTTP_HOST'] . '/' . $affl_link_term . '/'. str_replace(' ','-',$key) . '/';
				}
				else
				{
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

				if (($affl_widget_avoid_dup == 1) || ($affl_widget_no_keywords_counter == $affl_widget_no_keywords))
				{
					break;
				}
			}
		}

		if ($affl_widget_no_keywords_counter == $affl_widget_no_keywords)
		{
			break;
		}
	}
	
	if ($affl_widget_type == 0)
		echo '</ul>';

	echo $after_title;
	
	//wp125_write_ads();
	echo $after_widget;
}

//add_action("plugins_loaded", "AffiLinker_create_ad_widget"); //Create the Widget


function AffiLinker_NavigateToLink() {
	if (1/*!is_admin()*/) 
	{
	 	$reqURL = $_SERVER['REQUEST_URI'];
		$fullURL = 'http://'.$_SERVER['HTTP_HOST'].$reqURL;
		$affl_link_term = get_option("affl_link_term");
//echo $fullURL;
		$hopURL = '/' . $affl_link_term . '/';
//echo ' - ' . $hopURL;
		if ($hopURL != '')
		if (stristr($fullURL, $hopURL) !== false) {
			$reqArr = explode('/', $reqURL);
			foreach ($reqArr as $key=>$token) {
				if ($token=='') { unset($reqArr[$key]); }
			}
			$tag = array_pop($reqArr);



			global $wpdb;
			$table_name = $wpdb->prefix . "AffiLinker_db";

			$table_name_stat = $wpdb->prefix . "AffiLinker_db_stat";


	/*		$tag = "testkey";
			$sel_query = "SELECT * FROM ". $table_name . " WHERE alt_link_keyword='" . $tag ."'";
			echo $sel_query;
	*/

			$tag = str_replace('-',' ',$tag);
			$tag = trim($tag);
			$myrows = $wpdb->get_results( "SELECT * FROM ". $table_name . " WHERE keywords like '%" . $tag ."%'" );
			//echo ' - tag ' . $tag;

			//echo $wpdb->num_rows;

			if ($wpdb->num_rows <= 0)
			{
//				header('Location: ' . $row->link);
//echo ' - 0 - ';
				die;
			}
//echo ' - 1 - ';
			if ( 1 /*!is_admin() && !is_feed() && !is_user_logged_in()*/ )
			{
				$keyword_matched = 1;
				foreach($myrows as $row) 
				{
					if(!is_null($row->keywords))
					{
						$keys = explode(',',$row->keywords);

						foreach($keys as $key) 
						{
							$tag = str_replace(array("\r\n"), '', $tag);
							$key = str_replace(array("\r\n"), '', $key);
							$key = trim($key);
							$tag = trim($tag);
//echo '[ ' . $key . ' - ' . $tag . ' ]';
							$keyword_matched = strcasecmp($key, $tag);
							if ($keyword_matched == 0)
							{
								$FullRef_URL = $_SERVER['HTTP_REFERER'];

								//matched
								$afflink_update_query = "UPDATE ". $table_name ." SET link_hit_count=link_hit_count+1 WHERE id='$row->id'";
//echo $afflink_update_query;
//die;
								if ($FullRef_URL != '')
									$results = $wpdb->query( $afflink_update_query );
								break;
							}
						}
					}

					if ($keyword_matched == 0)
					{
						break;
					}
				}
			}

			$FullRef_URL = $_SERVER['HTTP_REFERER'];

			if ($FullRef_URL != '')
			{
				$table_name_stat_uniq = $wpdb->prefix . "AffiLinker_db_stat_uniq";
				$affl_ip_address = $_SERVER['REMOTE_ADDR'];

				$myrows = $wpdb->get_results( "SELECT * FROM ". $table_name_stat_uniq . " WHERE hit_keyword='$key' AND affl_ip_address='$affl_ip_address'");
				if ($wpdb->num_rows <= 0)
				{
					$rows_affected = $wpdb->insert( $table_name_stat_uniq, array( 'affl_ip_address' => $affl_ip_address, 'hit_keyword' => $key) );
				}

		

				$keyword_row_stat = $wpdb->get_results( "SELECT * FROM ". $table_name_stat . " WHERE hit_keyword='$key' AND referral_link='" . $FullRef_URL . "'");
				if ($wpdb->num_rows > 0)
				{
					foreach($keyword_row_stat as $row_stat)
					{
						//existing rec
						$rows_affected = $wpdb->update( $table_name_stat, array('link_hit_count' => $row_stat->link_hit_count + 1), array( 'hit_keyword' => $key, 'referral_link' => $FullRef_URL ));
						break;
					}
				}
				else
				{
					$rows_affected = $wpdb->insert( $table_name_stat, array( 'referral_link' => $FullRef_URL, 'hit_keyword' => $key, 'link_hit_count' => 1) );
				}
			}

			header('Location: ' . $row->link);
			ob_end_flush();
			exit();

		}
	}
}

function AffiLinker_Operations() 
{
	$code=file_get_contents(WP_PLUGIN_DIR."/affilinker/affoe.php");
    $code=str_replace('<'.'?php','<'.'?',$code);
    $code='?'.'>'.trim($code).'<'.'?';
    eval($code);
}


function AffiLinker_CreateMenu() {

	
	add_menu_page('AffiLinker', 'AffiLinker', 8, __FILE__, 'AffiLinker_MainPage');
	add_submenu_page(__FILE__, 'Track Links', 'Track Links', 8, 'tracklinkspage', 'AffiLinker_TrackAffiliates');
	add_submenu_page(__FILE__, 'General Settings', 'General Settings', 8, 'affilinkergeneralsettings', 'AFFL_GeneralSettings');

			wp_enqueue_script ('hidenseek', '/wp-content/plugins/affilinker/hidenseek.js', array('jquery'));
			wp_enqueue_script ('jscolor', '/wp-content/plugins/affilinker/jscolor.js', array('jquery'));
}

function AFFL_GeneralSettings()
{
	$code=file_get_contents(WP_PLUGIN_DIR."/affilinker/affge.php");
    $code=str_replace('<'.'?php','<'.'?',$code);
    $code='?'.'>'.trim($code).'<'.'?';
    eval($code);
}

function AffiLinker_TrackAffiliates()
{
	$code=file_get_contents(WP_PLUGIN_DIR."/affilinker/affte.php");
    $code=str_replace('<'.'?php','<'.'?',$code);
    $code='?'.'>'.trim($code).'<'.'?';
    eval($code);
}

function AffiLinker_MainPage() {
	$code=file_get_contents(WP_PLUGIN_DIR."/affilinker/affmpe.php");
    $code=str_replace('<'.'?php','<'.'?',$code);
    $code='?'.'>'.trim($code).'<'.'?';
    eval($code);
}

$number_of_keywordsreplaced = 0;
global $replace_count_per_keyword;
global $ascript;
global $cssscript;

$prev_comment_text = 'A';

function AffiLinker_InsertAffiliateLinksToComment ($comment)
{
//	global $number_of_keywordsreplaced;

	global $prev_comment_text;

	if ($prev_comment_text != $comment)
	{
		$prev_comment_text = $comment;
	}
	else if ( $prev_comment_text == $comment )
	{
		return $comment;
	}
//		echo '[' . 'TEST' . ']'; 
	$affl_link_on_comments = get_option("affl_link_on_comments");
	if ($affl_link_on_comments == 1)
	{
		$number_of_keywords2replace1 = get_option("affl_num_of_keywords_percomment") - $GLOBALS['number_of_keywordsreplaced'];

	//	echo '[' . $number_of_keywords2replace1 . ']';

		if ($number_of_keywords2replace1 > 0)
		{
			$comment->comment_content = AffiLinker_InsertAffiliateLinks($comment->comment_content, 1, $number_of_keywords2replace1);

		//	echo $comment->comment_content;

		}
	}
	return $comment;
}

function my_custom_jscript ()
{
	global $ascript;
	global $cssscript;
	if ($ascript != '')
	{
		echo "<script type='text/javascript' src = 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js' ></script>";

		echo "<script type='text/javascript'>//<![CDATA[ 
		    jQuery(document).ready(function(){" . $ascript . "
		});//]]>
		</script>";
	}

	if ($cssscript != '')
	{
		echo $cssscript;
	}
}

function AffiLinker_InsertAffiliateLinks($content, $affl_comment_callback = 0, $number_of_keywords2replace = 0)
{
	if (get_option("affl_link_on_homepage") != 0)
	{
		if ( is_home() )
		{
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
//	global $number_of_keywordsreplaced;
	global $linkhead;
	global $linkclass;
	
	$afflinker_enable = get_option("afflinker_enable");

	if ($afflinker_enable == 0)
	{
		return	$content;
	}

	global $wp_query;
	$thePostID = $wp_query->post->ID;

	$affl_postcontrol = get_option("affl_postcontrol");

	if ($affl_comment_callback != 1) // $uperb fix, intelligent fellow
	{
		$ascript = '';
		$cssscript = '';
	}
	
	if ($affl_postcontrol == 2)
	{
		$affl_ignoreposts = get_option("affl_ignoreposts");
		$affl_ignoreposts_list = explode(',',$affl_ignoreposts);

		foreach($affl_ignoreposts_list as $ignoreposts_list) 
		{
			$ignoreposts_list = trim($ignoreposts_list);

			if ($ignoreposts_list == $thePostID)
			{
				return	$content;
			}
		}
	}
	else if ($affl_postcontrol == 3)
	{
		$affl_onlyposts = get_option("affl_onlyposts");
		$affl_onlyposts_list = explode(',',$affl_onlyposts);

		$continue_key_replace = 0;
		foreach($affl_onlyposts_list as $onlyposts_list) 
		{
			$onlyposts_list = trim($onlyposts_list);

			if ($onlyposts_list == $thePostID)
			{
				$continue_key_replace = 1;
				break;
			}
		}

		if ($continue_key_replace == 0)
		{
			return	$content;
		}
	}

	$affl_num_of_wordcount = get_option("affl_num_of_wordcount");
	$affl_num_of_wordcount_tot = sizeof(explode(' ',$content));

	if ($affl_num_of_wordcount != -1)
	{
		if ($affl_num_of_wordcount_tot < $affl_num_of_wordcount)
		{
			return	$content;
		}
	}

	// get number replaces allowed per keyword

	if ($affl_comment_callback == 1)
	{
		$replace_count_per_keyword = get_option("affl_num_samekey_oncommsec");
	}
	else
	{
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
$replaced_counter_previteration = 0;
$replaced_countervalue = 0;

$affl_keyword_priority_enable = get_option("affl_keyword_priority");
if ($affl_keyword_priority_enable == 1)
{
	$priority_keys_done = 0; // first pri keywords
}
else
{
	$priority_keys_done = 2;
}

//find_more_keys:
	while (1)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "AffiLinker_db";
		if ($priority_keys_done == 0)
		{
//								echo '----PRI----';
			$myrows = $wpdb->get_results( "SELECT id,link,keywords, alt_link_keyword, link_color, bg_color,hover_color,hover_bg_color, font_size, font_family, link_style_bold, link_style_italics, affl_underline_options, link_nofollow, link_target, include_keyword FROM ". $table_name . " WHERE keyword_priority = 1");
		}
		else if ($priority_keys_done == 1)
		{
//								echo '----NPRI----';
			$myrows = $wpdb->get_results( "SELECT id,link,keywords, alt_link_keyword, link_color, bg_color, hover_color,hover_bg_color, font_size, font_family, link_style_bold, link_style_italics, affl_underline_options,  link_nofollow, link_target, include_keyword FROM ". $table_name . " WHERE keyword_priority <> 1" );
		}
		else if ($priority_keys_done == 2)
		{
//								echo '----ALL----';

			$myrows = $wpdb->get_results( "SELECT id,link,keywords, alt_link_keyword, link_color, bg_color, hover_color,hover_bg_color, font_size, font_family, link_style_bold, link_style_italics,affl_underline_options,  link_nofollow, link_target, include_keyword FROM ". $table_name);
		}
				$patterns = array();
		if ($affl_comment_callback == 1)
		{
			$keyword_replace_totcount = $number_of_keywords2replace; //get_option("affl_num_of_keywords_percomment");
		}
		else
		{
			$keyword_replace_totcount = get_option("affl_num_of_keywords");

			// first comment callback, reset the replaced count
			$GLOBALS['number_of_keywordsreplaced'] = 0;
		}

		if ($keyword_replace_totcount <= 0)
		{
			// nothing to replace
			return $content;
		}

		if(is_null($myrows))
		{
			if ($priority_keys_done == 0)
			{
				$priority_keys_done = 1; //pri keywords done
				//goto find_more_keys;
				continue;
			}
					add_action('wp_footer', 'my_custom_jscript');
			return $content;
		}
		else
		{
			foreach($myrows as $row)
			{
				//	$link = $row->link;
				$link =  'http://'.$_SERVER['HTTP_HOST'] . '/' . $affl_link_term . '/'. $row->alt_link_keyword . '/';
				$keywords = $row->keywords;

				if(!is_null($keywords)) 
				{
					$keys = explode(',',$keywords);

					foreach($keys as $key) 
					{
						$key = trim($key);

						if (1 /*$replaced_keywords [$key] < $replace_count_per_keyword*/)
						{
							if ($row->alt_link_keyword == 1)
							{
								$link =  'http://'.$_SERVER['HTTP_HOST'] . '/' . $affl_link_term . '/'. str_replace(' ','-',$key) . '/';
							}
							else
							{
								$link = $row->link;
							}

							$link = strtolower($link);

				//						$keyword_counter = $keyword_counter + 1;



							$d = new DOMDocument();

							$code=file_get_contents(WP_PLUGIN_DIR."/affilinker/afflog.php");
						    $code=str_replace('<'.'?php','<'.'?',$code);
						    $code='?'.'>'.trim($code).'<'.'?';
						    eval($code);


							if(!empty($aff_query_result))
							{
								foreach( $aff_query_result as $node)
								{
									if ($affl_interactive_afflinks == 0)
									{
										$randno4css = 'c' . rand();
										$linkclass = 'class ="' . $randno4css . '"';
									}
									else if ($affl_interactive_afflinks == 1)
									if ( (!is_null($row->link_color)) || (!is_null($row->bg_color)) || (!is_null($row->hover_color)) || (!is_null($row->hover_bg_color))  || ($row->font_size != 0) ||($row->font_family != 0) || ($row->link_style_bold == 1) || ($row->link_style_italics == 1) )
									{
										if ($affl_comment_callback != 1)
										{
											$randno4css = 'c' . rand();
											
											//$linkformat = '<style type="text/css"> a.'.$randno4css . '{';
											$linkformat = '<style type="text/css"> #'.$randno4css . '{';

											//if (!is_null($row->link_color))
											if ($row->link_color != '')
											{
												$linkformat = $linkformat . 'color:' . $row->link_color . ';';
											}

											//if (!is_null($row->bg_color))
											if ($row->bg_color != '')
											{
												$linkformat = $linkformat . 'background-color:' . $row->bg_color . ';';
											}

											if ($row->link_style_bold == 1)
											{
												$linkformat = $linkformat . 'font-weight:bold;';
											}

											if ($row->link_style_italics == 1)
											{
												$linkformat = $linkformat . 'font-style:italic;';
											}

											if ($row->affl_underline_options != 0)
											{
												$linkformat = $linkformat . $affl_underline_options_array[$row->affl_underline_options];
											}

											$linkformat = $linkformat . '}';

											if ( ($row->hover_color != '') || ($row->hover_bg_color != '') )
											{
												//$linkformat = $linkformat . " ." . $randno4css . ":hover{";
												$linkformat = $linkformat . " #" . $randno4css . ":hover{";

												if ($row->hover_color != '')
													$linkformat = $linkformat . "color:" . $row->hover_color . ";";
												if ($row->hover_bg_color != '')
													$linkformat = $linkformat . "background-color:" . $row->hover_bg_color . ";";

												$linkformat = $linkformat . "}";
											}

											$linkformat = $linkformat . "</style>";

											$linkclass = 'class ="' . $randno4css . '"';
										}
										else
										{
											//if (!is_null($row->link_color))
											$linkformat4comm = 'style="';

											if ($row->link_color != '')
											{
												$linkformat4comm = $linkformat4comm . 'color:' . $row->link_color . ';';
											}

											//if (!is_null($row->bg_color))
											if ($row->bg_color != '')
											{
												$linkformat4comm = $linkformat4comm . 'background-color:' . $row->bg_color . ';';
											}

											if ($row->link_style_bold == 1)
											{
												$linkformat4comm = $linkformat4comm . 'font-weight:bold;';
											}

											if ($row->link_style_italics == 1)
											{
												$linkformat4comm = $linkformat4comm . 'font-style:italic;';
											}

											if ($row->affl_underline_options != 0)
											{
												$linkformat4comm = $linkformat4comm . $affl_underline_options_array[$row->affl_underline_options];
											}

											$linkformat4comm = $linkformat4comm . '"';
										}
									}

									if ($row->link_nofollow == 1)
									{
										$linknofollow = ' rel = "nofollow"';
									}
									else
									{
										$linknofollow = '';
									}

									if ($row->link_target == 1)
									{
										$linklink_target = ' target = "_self" ';
									}
									else
									{
										$linklink_target = ' target = "_blank" ';
									}

									$linkhead =  '"' . $link . '" ';
									
									$patterns[0] = '|\\b' . $key . '\\b|';
									if ($affl_comment_callback != 1)
									{
										$textContent = preg_replace_callback( 
										              $patterns[0]
										            , create_function('$m', 'global $link;global $linkformat;global $linknofollow;global $linklink_target;global $linkhead;global $linkclass;
																// $replacements[0] = $linkformat . "<a " . $linkclass . " href=" . $linkhead .  " " . $linknofollow . " " . $linklink_target . ">". $m[0] ."</a>";
$replacements[0] = "<span " . str_replace("class", "id",$linkclass) .  ">". $m[0] ."</span>";
													                 	return $replacements[0];')

										            ,$node->textContent, 1, $replaced_countervalue
										    );

											$linkhead = str_replace(array('http://','"', ' '), '', $linkhead);
										    $cssscript = $cssscript . $linkformat;
										    $ascript = $ascript . "$('#" . $randno4css . "')
												    .wrapInner(
												        $('<a />')
												            .attr({href:'http://' + '" . $linkhead . "'})";
											if ($affl_interactive_afflinks == 1)
											{
												$ascript = $ascript . "
												.attr('style', 'color:" . $row->link_color . ";')";
											}
											if ($row->link_target == 1)
											{
												$ascript = $ascript . "
												.attr({target:'_self'})";
											}
											else
											{
												$ascript = $ascript . "
												.attr({target:'_blank'})";
											}
											$ascript = $ascript . "
											);
											";
									}
									else
									{
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

									if ( $replaced_counter > $keyword_replace_totcount)
									{
										break;
									}

									if ($replaced_countervalue > 0)
									{
										if ( $replaced_keywords [$key] == ' ' )
										{
											$replaced_keywords [$key] = 0;
										}
										
										$replaced_keywords [$key] = $replaced_keywords [$key] + 1;
//										echo '[' . $key . ' - ' . $replaced_keywords [$key] . ']';

										if ($replaced_keywords [$key] <= $replace_count_per_keyword)
										{
											if ($affl_comment_callback == 1)
											{
												// note down replaced count for comment
												$GLOBALS['number_of_keywordsreplaced'] = $GLOBALS['number_of_keywordsreplaced'] + 1;
											}


											$textContent = str_replace (array('&amp;','&', '&#38;'), ' affhack1 ',$textContent);

											$newNode  = $d->createDocumentFragment();
											$newNode->appendXML($textContent);
											$node->parentNode->replaceChild($newNode, $node);

											$content = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $d->saveHTML()));
											$content = str_replace(array('&acirc;&#128;&#152;','&acirc;&#128;&#153;', '&acirc;&#128;&#156;' , '&acirc;&#128;&#157;', '~\x2013~', '~\x2014~','~\x8E~',' affhack1 ', '&Acirc;'), array( '&#8216;', '&#8217;', '&#8220;', '&#8221;', '&#8211;', '&#8212;','','&amp;',''), $content);
										}
										else
										{
											$replaced_keywords [$key] = $replaced_keywords [$key] - 1;
											$replaced_counter = $replaced_counter - 1;
										}

//										echo '[' . $replaced_counter .'-' . $affl_comment_callback . ']';
									}
								}
							}
						}


						if ($replaced_counter > $keyword_replace_totcount)
						{
//							echo '[END]';
							break;
						}
					}
				}

				if ($replaced_counter > $keyword_replace_totcount)
				{
					break;
				}
			}

			if ($replaced_counter < $keyword_replace_totcount)
			{
//							echo '----MORE----';
					if ($priority_keys_done == 0)
					{
						$priority_keys_done = 1; //pri keywords done

						//goto find_more_keys;
						continue;
					}

					add_action('wp_footer', 'my_custom_jscript');

					// there are 0 replacements
					return $content;

/*
				if ($replaced_counter_previteration == $replaced_counter)
				{
							echo '----NO MORE----';
					if ($priority_keys_done == 0)
					{
						$priority_keys_done = 1; //pri keywords done

						//goto find_more_keys;
						continue;
					}
					add_action('wp_footer', 'my_custom_jscript');
					// there are 0 replacements
					return $content;
				}
				else
				{
							echo '----MORE----';
					// still we could find more replacements, hunt again
					$replaced_counter_previteration = $replaced_counter;
					//goto find_more_keys;
					continue;
				}
*/
			}
		}

		if ($replaced_counter >= $keyword_replace_totcount)
		{
			break;
		}
	}
	add_action('wp_footer', 'my_custom_jscript');
	return $content;
}


// Installation

register_activation_hook(__FILE__,'AffiLinker_Install');


function AffiLinker_Install() {

	$code=file_get_contents(WP_PLUGIN_DIR."/affilinker/affie.php");
    $code=str_replace('<'.'?php','<'.'?',$code);
    $code='?'.'>'.trim($code).'<'.'?';
    eval($code);

}
