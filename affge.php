<?php
global $afflt;

	echo '<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>';
	echo '<h2>'.$afflt[1].'</h2>
	<br /><br />

	<form name="AFFL_gsettings" method="post">';

		$affl_num_of_keywords = get_option("affl_num_of_keywords");
		$affl_num_of_keywords_percomment = get_option("affl_num_of_keywords_percomment");
		$affl_num_samekey_perpost = get_option("affl_num_samekey_perpost");
		$affl_num_samekey_oncommsec = get_option("affl_num_samekey_oncommsec");
		$affl_link_term = get_option("affl_link_term");

		$affl_postcontrol = get_option("affl_postcontrol");
		$affl_ignoreposts = get_option("affl_ignoreposts");
		$affl_onlyposts = get_option("affl_onlyposts");
		$affl_link_on_comments = get_option("affl_link_on_comments");
		$affl_link_on_homepage = get_option("affl_link_on_homepage");
		
		$affl_keyword_priority = get_option("affl_keyword_priority");
		$affl_interactive_afflinks = get_option("affl_interactive_afflinks");
		$afflinker_enable = get_option("afflinker_enable");
		$affl_num_of_wordcount = get_option("affl_num_of_wordcount");

		if ( function_exists('wp_nonce_field') )
			wp_nonce_field('AffiLinker-AFFL_gsettings');
		echo '
		<div class="update-nag"><strong><a href="http://www.affilinker.com/affiliate-wordpress-plugin/" target = "_blank">Get AffiLinker Premium Version</a></strong> to manage unlimited Affiliate Links and more features.</div>

		<p>Do the configurations below on how you want AffiLinker to work with your wordpress blog.</p>
		<br/>
	<table class="widefat" cellspacing="10" cellpadding="10" style="background-color:#DBF1FF" width="100%" >
		<tr  valign="top" >
			<td height="50px">AffiLinker Troubles You ?</td>
			<td height="50px">';
				if ($afflinker_enable == 1)
				{
					echo '<input type="checkbox" name="afflinker_enable" value="1" CHECKED/>&nbsp;Keep it Active<br/>';
				}
				else
				{
					echo '<input type="checkbox" name="afflinker_enable" value="1" />&nbsp;Keep me Active<br/>';
				}

				echo '<small>Uncheck to keep AffiLinker deactivated, it works in admin area and becomes slient on live blog.</small>
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
				if ($affl_postcontrol == 1)
				{
					echo '<input type="radio" name="affl_postcontrol" value="1" checked="yes" />&nbsp;Default - Show In All Blog Posts/Pages&nbsp;';
				}
				else
				{
					echo '<input type="radio" name="affl_postcontrol" value="1" />&nbsp;Default - Show In All Blog Posts/Pages&nbsp;';
				}

				if ($affl_postcontrol == 2)
				{
					echo '<br/> <br/><input type="radio" name="affl_postcontrol" value="2" checked="yes" />&nbsp;Ignore The Below Blog Posts/Pages';
				}
				else
				{
					echo '<br/> <br/><input type="radio" name="affl_postcontrol" value="2" />&nbsp;Ignore The Below Blog Posts/Pages';
				}

				echo '<br/><input type="text" name="affl_ignoreposts" size="180" value="' . $affl_ignoreposts . '" /> 
				<br/><small>Specify blog post/page IDs seperated by comma, AffiLinker <strong>NEVER</strong> converts any keyword into link on these blog posts.</small>
				<br/> <br/>';

				if ($affl_postcontrol == 3)
				{
					echo '<input type="radio" name="affl_postcontrol" value="3" checked="yes" />&nbsp;Add Only on Below Blog Posts/Pages';
				}
				else
				{
					echo '<input type="radio" name="affl_postcontrol" value="3" />&nbsp;Add Only on Below Blog Posts/Pages';
				}

				echo '<br/><input type="text" name="affl_onlyposts" size="180" value="' . $affl_onlyposts . '"/> 
				<br/><small>Specify blog post/page IDs seperated by comma, AffiLinker converts keyword into link <strong>ONLY</strong> on these blog posts.</small>  <br/><br/>
				 </td>
		</tr>';

		echo '<tr  valign="top" >
			<td height="50px">Minimum word count required</td>
			<td height="50px"><input type="text" name="affl_num_of_wordcount" size="5" value="' . $affl_num_of_wordcount . '" disabled/><br/>
				<small>Replaces only the blog posts/pages which has more than the specified number of words. <strong>-1</strong> represents no limit.</small>
			</td>
		</tr>
		
		<tr  valign="top">
			<td height="50px">Donot Add Links on Homepage</td>
			<td height="50px">';
				if ($affl_link_on_homepage == 0)
				{
					echo '<input type="checkbox" name="affl_link_on_homepage" value="1" />&nbsp;Donot Add<br/>
					<small>Not recommended when you show only excerpts (instead of full blog post) on homepage.</small>';
				}
				else
				{
					echo '<input type="checkbox" name="affl_link_on_homepage" value="1" CHECKED/>&nbsp;Donot Add<br/>
					<small>Not recommended when you show only excerpts (instead of full blog post) on homepage.</small>';
				}
			echo '</td>
		</tr>

		<tr  valign="top">
			<td height="50px">Add Links on Comments</td>
			<td height="50px">';
				if ($affl_link_on_comments == 1)
				{
					echo '<input type="checkbox" name="affl_link_on_comments" value="1" CHECKED/>&nbsp;Enable<br/>';
				}
				else
				{
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
			<td height="80px">Priority Keyword </td>
			<td height="80px">';
				if ($affl_keyword_priority == 1)
				{
					echo '<input type="radio" name="affl_keyword_priority" value="1" checked="yes" disabled/>&nbsp;Enable<br/>
					<input type="radio" name="affl_keyword_priority" value="0" disabled/>&nbsp;Disable<br/>';
				}
				else
				{
					echo '<input type="radio" name="affl_keyword_priority" value="1" disabled/>&nbsp;Enable<br/>
					<input type="radio" name="affl_keyword_priority" value="0" checked="yes" disabled/>&nbsp;Disable<br/>';
				}
				echo '<small>When Enabled, AffiLinker will replace Priority Keywords into links first and then the replacement for Non-Priority Keywords. When Disabled, all keywords are treated as equal priority.</small>
			</td>
		</tr>

		<tr  valign="top">
			<td height="80px">Interactive Affiliate Links </td>
			<td height="80px">';
				if ($affl_interactive_afflinks == 1)
				{
					echo '<input type="radio" name="affl_interactive_afflinks" value="1" checked="yes" />&nbsp;Enable<br/>';
					echo '<input type="radio" name="affl_interactive_afflinks" value="0" />&nbsp;Disable<br/>';
				}
				else
				{
					echo '<input type="radio" name="affl_interactive_afflinks" value="1" />&nbsp;Enable<br/>';
					echo '<input type="radio" name="affl_interactive_afflinks" value="0" checked="yes" />&nbsp;Disable<br/>';
				}
				echo '<small>When Enabled, AffiLinker turns affiliate links into <em>interactive affiliate links</em> based on the font, size, color, link style settings as specified by you for each keyword. When Disabled, links are displayed in default style matching your blog.</small>
			</td>
		</tr>

		<tr  valign="top" >
			<td height="50px">Your choice of Link Term : </td>
			<td height="50px">http://www.yoursite.com/<input type="text" name="affl_link_term" size="15" value="' . $affl_link_term . '" disabled/>/keyword-here/<br/>
				<small>Spice up the links with your own Link Term.</small>
			</td>
		</tr>

		<tr  valign="top">';
				if (1 /*get_option("affl_num_enable")!=0 */){
			echo '<td height="50px"><input type="submit" class="button-primary" value="Save Changes" name="save-gs-changes" /></td>
			<td height="50px"><input type="hidden" name="affl_savegs_changes" value="ok" /></td>';}
		echo '</tr>

	</table>
	</form>';
?>
