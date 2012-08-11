<?php
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
	$table_name = $wpdb->prefix . "AffiLinker_db_stat";

	if($_POST['hitcountsort']=='Sort Up') {

//		check_admin_referer('AffiLinker_sort');

//		$myrows = $wpdb->get_results( "SELECT * FROM ". $table_name . " ORDER BY link_hit_count DESC");
		$myrows = $wpdb->get_results( "SELECT * FROM ". $table_name . " GROUP BY hit_keyword ORDER BY SUM(link_hit_count) DESC");
	}
	else 	if($_POST['hitcountsort']=='Sort Down') {
		$myrows = $wpdb->get_results( "SELECT * FROM ". $table_name . " GROUP BY hit_keyword ORDER BY SUM(link_hit_count) ASC");
	}
	else
	{	
		$myrows = $wpdb->get_results( "SELECT * FROM ". $table_name . " GROUP BY hit_keyword");
	}

	echo '<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>';
	echo '<h2>Track Affiliate Links</h2>
	<br /><br />
			<div class="update-nag"><strong><a href="http://www.affilinker.com/affiliate-wordpress-plugin/" target = "_blank">Get AffiLinker Premium Version</a></strong> to manage unlimited Affiliate Links and more features.</div>';

?>

<?php
echo ' 		<form name="clear-stats" method="post"><input type="submit" class="button-primary" name="stats" value="Clear All Stats" /> </form>
<table class="widefat" style="table-layout:fixed;" cellspacing="0">
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
	$table_name_stat_uniq = $wpdb->prefix . "AffiLinker_db_stat_uniq";
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
			<td><center><?php echo '<a href=javascript:elementHideShow("' . $keyword1 . '");>';  echo $keyword; ?></a> </center></td>
			<td><center>
			<?php 
				$query_sum = "SELECT SUM(link_hit_count) FROM " . $table_name . " WHERE hit_keyword='$keyword'";

				$result = mysql_query($query_sum);
$row = mysql_fetch_array($result);

				echo $row['SUM(link_hit_count)']; ?>
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
		foreach ($mysubrows as $subrow)
		{
			if ($countfortablehdr == 0)
			{
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

		if ($countfortablehdr == 1)
		{
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
	

?>
