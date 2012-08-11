<?php
	global $wpdb;

	$table_name = $wpdb->prefix . "AffiLinker_db";
	$table_name_stat = $wpdb->prefix . "AffiLinker_db_stat";

	if ($_REQUEST['affl_user_rcpt_chkd_vld'] == '11')
	{
		update_option("affl_num_enable",1);
		if ($_REQUEST['rcpt'] != '')
		{
			update_option("affl_num_count",$_REQUEST['rcpt']);
	//		wp_redirect("admin.php?page=affilinkerActivate");
		}
	}
	else if ($_REQUEST['affl_user_rcpt_chkd_vld'] == '0')
	{
		update_option("affl_num_enable",0);
	}

	if ($_REQUEST['vrr'] == '1')
	{
		update_option("affl_updav", 0);
	}
	else if ($_REQUEST['vrr'] == '100')
	{
		update_option("affl_updurl", $_REQUEST['vrrurl']);
		update_option("affl_updav", 100);
	}
	else
	{
		update_option("affl_updav", 10);
	}

	if($_POST['aal_sent']=='ok') {
			$rowchk = 1;
			$myrows = $wpdb->get_results( "SELECT * FROM ". $table_name);
			$rown = 0;
			$rowchk = $rowchk + 4;
			foreach($myrows as $row) {

			$rown = $rown + 1;
			}
			if ($rown >= ($rowchk-2))
			{
				wp_redirect("admin.php?page=affilinker/affilinker.php#error");
			}
			else
			{

		//	check_admin_referer('AffiLinker_add_link');

			
			$link = filter_input(INPUT_POST, 'link', FILTER_SANITIZE_SPECIAL_CHARS); 
			$keywords = filter_input(INPUT_POST, 'keywords', FILTER_SANITIZE_SPECIAL_CHARS); 

			$link_color = filter_input(INPUT_POST, 'link_color', FILTER_SANITIZE_SPECIAL_CHARS); 
			$bg_color = filter_input(INPUT_POST, 'bg_color', FILTER_SANITIZE_SPECIAL_CHARS); 
			$hover_color = filter_input(INPUT_POST, 'hover_color', FILTER_SANITIZE_SPECIAL_CHARS); 
			$hover_bg_color = filter_input(INPUT_POST, 'hover_bg_color', FILTER_SANITIZE_SPECIAL_CHARS); 
			
			$font_size = filter_input(INPUT_POST, 'font_size', FILTER_SANITIZE_SPECIAL_CHARS); 
			$font_family = filter_input(INPUT_POST, 'font_family', FILTER_SANITIZE_SPECIAL_CHARS); 

$link_style_bold = filter_input(INPUT_POST, 'link_style_bold', FILTER_SANITIZE_SPECIAL_CHARS); 
$link_style_italics = filter_input(INPUT_POST, 'link_style_italics', FILTER_SANITIZE_SPECIAL_CHARS); 
$affl_underline_options = filter_input(INPUT_POST, 'affl_underline_options', FILTER_SANITIZE_SPECIAL_CHARS); 

			$link_nofollow = filter_input(INPUT_POST, 'link_nofollow', FILTER_SANITIZE_SPECIAL_CHARS); 
			$link_target = filter_input(INPUT_POST, 'link_target', FILTER_SANITIZE_SPECIAL_CHARS); 
			$include_keyword = filter_input(INPUT_POST, 'include_keyword', FILTER_SANITIZE_SPECIAL_CHARS); 

			$alt_link_keyword = filter_input(INPUT_POST, 'alt_link_keyword', FILTER_SANITIZE_SPECIAL_CHARS); 
			$keyword_priority =  0;

//$link_hit_count = filter_input(INPUT_POST, 'link_hit_count', FILTER_SANITIZE_SPECIAL_CHARS); 
$link_hit_count = 0;

			$rows_affected = $wpdb->insert( $table_name, array( 'link' => $link, 'keywords' => $keywords, 'link_color' => $link_color, 'bg_color' => $bg_color,
				'hover_color' => $hover_color, 'hover_bg_color' => $hover_bg_color, 'font_size' => $font_size, 'font_family' => $font_family, 
				'link_style_bold' => $link_style_bold, 'link_style_italics' => $link_style_italics, 'affl_underline_options' => $affl_underline_options,
				'link_nofollow' => $link_nofollow, 'link_target' => $link_target, 'include_keyword' => $include_keyword, 'alt_link_keyword' => $alt_link_keyword, 'link_hit_count' => $link_hit_count, 'keyword_priority' => $keyword_priority ) );

			wp_redirect("admin.php?page=affilinker/affilinker.php#down");
			}
	}

	if ($_POST['affl_savegs_changes']=='ok')
	{
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

		update_option("affl_num_of_keywords", $affl_num_of_keywords);
		update_option("affl_num_of_keywords_percomment", $affl_num_of_keywords_percomment);
		update_option("affl_num_samekey_perpost", $affl_num_samekey_perpost);
		update_option("affl_num_samekey_oncommsec", $affl_num_samekey_oncommsec);

		update_option("affl_num_of_wordcount", $affl_num_of_wordcount);
		update_option("affl_postcontrol", $affl_postcontrol);
		update_option("affl_ignoreposts", $affl_ignoreposts);
		update_option("affl_onlyposts", $affl_onlyposts);
		update_option("affl_link_on_comments", $affl_link_on_comments);
		update_option("affl_link_on_homepage", $affl_link_on_homepage);
		update_option("affl_keyword_priority", $affl_keyword_priority);
		update_option("affl_interactive_afflinks", $affl_interactive_afflinks);
		update_option("afflinker_enable", $afflinker_enable);

	}

	if($_POST['SubmitAll']=='Save All Changes')
	{
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
		$alt_link_keywordall = $_POST['alt_link_keyword'];
		$keyword_priorityall = $_POST['keyword_priority'];

		$count = count($linkall);

		for($ids=0; $ids < $count; $ids++)
		{
			$nofollowset = 0;
			for ($i=0; $i < count($link_nofollowall); $i++)
			{
				if ($link_nofollowall[$i] == $idall[$ids])
				{
					$nofollowset = 1;
					break;
				}
			}

			$targetset = 0;
			for ($i=0; $i < count($link_targetall); $i++)
			{
				if ($link_targetall[$i] == $idall[$ids])
				{
					$targetset = 1;
					break;
				}
			}

			$include_keywordset = 0;
			for ($i=0; $i < count($include_keywordall); $i++)
			{
				if ($include_keywordall[$i] == $idall[$ids])
				{
					$include_keywordset = 1;
					break;
				}
			}

			$link_style_boldset = 0;
			for ($i=0; $i < count($link_style_boldall); $i++)
			{
				if ($link_style_boldall[$i] == $idall[$ids])
				{
					$link_style_boldset = 1;
					break;
				}
			}

			$link_style_italicsset = 0;
			for ($i=0; $i < count($link_style_italicsall); $i++)
			{
				if ($link_style_italicsall[$i] == $idall[$ids])
				{
					$link_style_italicsset = 1;
					break;
				}
			}

			$alt_link_keywordset = 0;
			for ($i=0; $i < count($alt_link_keywordall); $i++)
			{
				if ($alt_link_keywordall[$i] == $idall[$ids])
				{
					$alt_link_keywordset = 1;
					break;
				}
			}

			$keyword_priorityset = 0;
			for ($i=0; $i < count($keyword_priorityall); $i++)
			{
				if ($keyword_priorityall[$i] == $idall[$ids])
				{
					$keyword_priorityset = 1;
					break;
				}
			}
		$keywordsall[$ids] = str_replace(array("\r\n"), ' ', $keywordsall[$ids]);
		$rows_affected = $wpdb->update( $table_name, array( 'link' => $linkall[$ids], 'keywords' => $keywordsall[$ids], 'link_color' => $link_colorall[$ids], 'bg_color' => $bg_colorall[$ids],
			'hover_color' => $hover_colorall[$ids], 'hover_bg_color' => $hover_bg_colorall[$ids], 'font_size' => $font_sizeall[$ids], 'font_family' => $font_familyall[$ids], 
			'link_style_bold' => $link_style_boldset, 'link_style_italics' => $link_style_italicsset, 'affl_underline_options' => $affl_underline_optionsall[$ids],
			'link_nofollow' => $nofollowset, 'link_target' => $targetset, 'include_keyword' => $include_keywordset, 'alt_link_keyword' => $alt_link_keywordset, 
			'link_hit_count' => $link_hit_countall[$ids], 'keyword_priority' => $keyword_priorityset ), array( 'id' => $idall[$ids] ));

		}
//echo  '--'.$keywordsall[5];
			wp_redirect("admin.php?page=affilinker/affilinker.php#up");
	}
	
	if($_POST['SubmitAll']=='Delete Selected') {
//		check_admin_referer('AffiLinker_deleteselected');

		$checked = $_POST['checkbox1'];

		$count = count($checked);

		for($ids=0; $ids < $count; $ids++)
		{
			$wpdb->query("DELETE FROM ". $table_name ." WHERE id = '". $checked[$ids] ."' LIMIT 1");
		}

		wp_redirect("admin.php?page=affilinker/affilinker.php#up");
	}

	if($_POST['stats']=='Clear All Stats') {
		global $wpdb;
		$table_name = $wpdb->prefix . "AffiLinker_db_stat";
		$wpdb->query("DELETE FROM ". $table_name);

		$table_name = $wpdb->prefix . "AffiLinker_db_stat_uniq";
		$wpdb->query("DELETE FROM ". $table_name);

		$table_name = $wpdb->prefix . "AffiLinker_db";
		$wpdb->query("UPDATE " . $table_name . " SET link_hit_count=0");
	}
?>
