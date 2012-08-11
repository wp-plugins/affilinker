<?php
	global $wpdb;
	$table_name = $wpdb->prefix . "AffiLinker_db";

	$affilinker_db_version = "1.0.0";
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) 
	{
		$affilinker_db_stored_version = get_option("affilinker_db_version");
		if ($affilinker_db_stored_version != $affilinker_db_version)
		{
			update_option("affilinker_db_version", $affilinker_db_version);
			update_option("affl_num_of_keywords", 5);
			update_option("affl_num_of_keywords_percomment", 5);
			update_option("affl_postcontrol", 1);
			update_option("affl_ignoreposts", "0,1,2");
			update_option("affl_onlyposts", "2,1, 0");
			update_option("affl_link_on_comments", 0);
			update_option("affl_link_on_homepage", 1);
			
			update_option("affl_keyword_priority", 1);
			update_option("affl_interactive_afflinks", 1);
			update_option("afflinker_enable", 1);
			update_option("affl_num_of_wordcount", -1);

			update_option("affl_widget_title", "");
			update_option("affl_widget_no_keywords", 10);
			update_option("affl_widget_type", 0);
			update_option("affl_widget_font_startpx", 10);
			update_option("affl_widget_font_endpx", 25);
			update_option("affl_widget_interactive_opt", 0);
			update_option("affl_widget_avoid_dup", 0);

			update_option("affl_num_samekey_perpost", 2);
			update_option("affl_num_samekey_oncommsec", 2);
			update_option("affl_num_enable", 0);
			update_option("affl_num_count", 0);
			update_option("affl_link_term", 'visit');

			update_option("affl_updurl", '');
			update_option("affl_updav", 10);
			
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
		  UNIQUE KEY id (id)
		);";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);

		$table_name = $wpdb->prefix . "AffiLinker_db_stat";

			$sql = "CREATE TABLE " . $table_name . " (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  referral_link text,
		  hit_keyword text,
		  link_hit_count int(12),
		  UNIQUE KEY id (id)
		);";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);

		$table_name = $wpdb->prefix . "AffiLinker_db_stat_uniq";

		$sql = "CREATE TABLE " . $table_name . " (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  hit_keyword text,
		  affl_ip_address text,
		  UNIQUE KEY id (id)
		);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

		}
	}
	else
	{
		add_option("affilinker_db_version", $affilinker_db_version);
		add_option("affl_num_of_keywords", 5);
		add_option("affl_num_of_keywords_percomment", 5);
		add_option("affl_postcontrol", 1);
		add_option("affl_ignoreposts", "0,1,2");
		add_option("affl_onlyposts", "2,1, 0");
		add_option("affl_link_on_comments", 0);
		add_option("affl_link_on_homepage", 1);
		
		add_option("affl_keyword_priority", 1);
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
	  UNIQUE KEY id (id)
	);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

	$table_name = $wpdb->prefix . "AffiLinker_db_stat";

		$sql = "CREATE TABLE " . $table_name . " (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  referral_link text,
	  hit_keyword text,
	  link_hit_count int(12),
	  UNIQUE KEY id (id)
	);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

	$table_name = $wpdb->prefix . "AffiLinker_db_stat_uniq";

	$sql = "CREATE TABLE " . $table_name . " (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  hit_keyword text,
	  affl_ip_address text,
	  UNIQUE KEY id (id)
	);";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);

	}
?>
