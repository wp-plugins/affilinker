<?php
    
	global $wpdb;
	$table_name = $wpdb->prefix . "AffiLinker_db";

	if($_GET['AffiLinker_Do']=='sort') {
//		check_admin_referer('AffiLinker_sort');

		$myrows = $wpdb->get_results( "SELECT * FROM ". $table_name . " ORDER BY link_hit_count DESC");
	}
	else
	{
		$myrows = $wpdb->get_results( "SELECT * FROM ". $table_name );
	}
	
	echo '<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>';
	echo '<h2>Manage AffiLinker</h2>
	<br /><br />

	<form name="add-link" method="post">';


if ( function_exists('wp_nonce_field') )
	wp_nonce_field('AffiLinker_add_link');

		if (0 /*get_option("affl_num_enable")==0 */){
			echo 'Plugin Not Activated ! Please Go to <em>AffiLinker->Activate</em> and follow the activation form....';
			return;}
		echo '
		<div class="update-nag"><strong><a href="http://www.affilinker.com/affiliate-wordpress-plugin/" target = "_blank">Get AffiLinker Premium Version</a></strong> to manage unlimited Affiliate Links and more features.</div>
		<table class="widefat" cellspacing="10" cellpadding="10" style="background-color:#DBF1FF" width="100%" >
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
				<small>Example: <strong>Canon PowerShot, Canon Camera, canon camera, Digital Camera, Digital camera</strong></small><br/> Yes, keywords are case-sensitive to have more control.</td>
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
			<td height="50px">Link Font size :</td>
			<td height="50px">
				<select name="font_size" disabled>
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
				<small> When not selected, it takes the default anchor text font size matching to your blog.</small>
			</td>
		</tr>

		<tr  valign="top">
			<td height="50px">Link Font Name :</td>
			<td height="50px">
				<select name="font_family" disabled>
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
				<small> When not selected, it takes the default anchor text font name matching to your blog.</small>
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
<input type="checkbox" name="alt_link_keyword" value="1" CHECKED>&nbsp; Hide Link. <br/><small>Example: If the keyword is "buy product" and Link Term is "visit", your affiliate link will be automatically replaced by a professional link: <strong>'; echo bloginfo('url');  echo '/visit/buy-product/</strong></small>
			</td>
		</tr>

		<tr  valign="top">
			<td height="80px">Make this a <strong>Priority Keyword</strong> : </td>
			<td height="80px"> <input type="checkbox" name="keyword_priority" value="1" disabled>&nbsp;Priority Keyword<br/>
				<small>When you make it Priority Keyword, AffiLinker will replace these keywords into links first and then looks for Non-Priority Keywords. This helps when you limit the number of links per post, priority keywords are given more importance than other keywords.</small> </td>
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
	<div id="icon-options-general" class="icon32"><br /></div>
	<a id="up"></a>
	<h2>Manage All Links</h2>
<br/>		<div class="update-nag"><strong><a href="http://www.affilinker.com/affiliate-wordpress-plugin/" target = "_blank">Get AffiLinker Premium Version</a></strong> to manage unlimited Affiliate Links and more features.</div>';

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

<table class="widefat" cellspacing="0" id="active-plugins-table">
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

				foreach ($size_array as $i)
				{
					if ($i == $font_size)
					{
						echo '<option value="' . $i . '" selected>' . $i . '</option>';
					}
					else
					{
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

				foreach ($familyid_array as $i)
				{
					if ($i == $font_family)
					{
						echo '<option value="' . $i . '" selected>' . $family_array[$i] . '</option>';
					}
					else
					{
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

				if ($alt_link_keyword == 1)
				{
					echo '<input type="checkbox" name="alt_link_keyword[]" value="'. $id . '" CHECKED> Hide Affiliate Link<br/>';
				}
				else
				{
					echo '<input type="checkbox" name="alt_link_keyword[]" value="'. $id . '"> Hide Affiliate Link<br/>';
				}

				if ($link_nofollow == 1)
				{
					echo '<input type="checkbox" name="link_nofollow[]" value="'. $id . '" CHECKED> Add NoFollow<br/>';
				}
				else
				{
					echo '<input type="checkbox" name="link_nofollow[]" value="'. $id . '"> Add NoFollow<br/>';
				}
			?>
			<?php
				if ($link_target == 1)
				{
					echo '<input type="checkbox" name="link_target[]" value="'. $id . '" CHECKED> Same Window<br/>';
				}
				else
				{
					echo '<input type="checkbox" name="link_target[]" value="'. $id . '"> Same Window<br/>';
				}

				if ($link_style_bold == 1)
				{
					echo '<input type="checkbox" name="link_style_bold[]" value="'. $id . '" CHECKED> <strong>Bold</strong><br/>';
				}
				else
				{
					echo '<input type="checkbox" name="link_style_bold[]" value="'. $id . '"> <strong>Bold</strong><br/>';
				}

				if ($link_style_italics == 1)
				{
					echo '<input type="checkbox" name="link_style_italics[]" value="'. $id . '" CHECKED> <em>Italics</em><br/>';
				}
				else
				{
					echo '<input type="checkbox" name="link_style_italics[]" value="'. $id . '"> <em>Italics</em><br/>';
				}

				if ($include_keyword == 1)
				{
					echo '<input type="checkbox" name="include_keyword[]" value="'. $id . '" CHECKED> Show in Cloud<br/>';
				}
				else
				{
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
				foreach ($affl_underline_options_id_array as $i)
				{
					if ($i == $affl_underline_options)
					{
						echo '<option value="' . $i . '" selected>' . $affl_underline_options_name_array[$i] . '</option>';
					}
					else
					{
						echo '<option value="' . $i . '">' . $affl_underline_options_name_array[$i] . '</option>';
					}
				}
				echo '</select>';

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
	';

//	print_r($myrows);



?>
