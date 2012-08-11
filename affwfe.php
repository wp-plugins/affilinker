<?php
    /*
	$affl_widget_title = get_option("affl_widget_title");
	$affl_widget_no_keywords = get_option("affl_widget_no_keywords");
	$affl_widget_type = get_option("affl_widget_type");
	$affl_widget_font_startpx = get_option("affl_widget_font_startpx");
	$affl_widget_font_endpx = get_option("affl_widget_font_endpx");
	$affl_widget_interactive_opt = get_option("affl_widget_interactive_opt");
	$affl_widget_avoid_dup = get_option("affl_widget_avoid_dup");
*/
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
if ($affl_widget_type == 20)
{
echo '<option selected id="' . $this->get_field_id('affl_widget_type') . '" value="20" > Keywords as List</option>
<option id="' . $this->get_field_id('affl_widget_type') . '" value="21" >Keywords as Cloud</option></select>';
}
else
{
echo '<option id="' . $this->get_field_id('affl_widget_type') . '" value="20" > Keywords as List</option>
<option selected id="' . $this->get_field_id('affl_widget_type') . '" value="21" > Keywords as Cloud</option></select>';
}
echo '<br/>';

	echo '<br/>For Keywords as Cloud:<br/>   Minimum Font <input type="text" id="' . $this->get_field_id('affl_widget_font_startpx') . '" name="' . $this->get_field_name('affl_widget_font_startpx') . '" value = "' . $affl_widget_font_startpx . '" size="3"/>px<br/>   Maximum Font <input type="text" id="' . $this->get_field_id('affl_widget_font_endpx') . '" name="' . $this->get_field_name('affl_widget_font_endpx') . '" value = "' . $affl_widget_font_endpx . '" size="3"/>px';
/*
	if ($affl_widget_type == 3)
	{
		echo '<input type="radio" name="affl_widget_type" value="3" checked="yes"  />&nbsp; Keywords as Random Cloud<br/><br/>';
	}
	else
	{
		echo '<input type="radio" name="affl_widget_type" value="3"  />&nbsp; Keywords as Random Cloud<br/><br/>';
	}
*/
	if ($affl_widget_interactive_opt == 1)
	{
		echo '<br/><br/><input type="checkbox" id="' . $this->get_field_id('affl_widget_interactive_opt') . '" name="' . $this->get_field_name('affl_widget_interactive_opt') . '" value="1"  CHECKED />&nbsp; Enable Interactive AffiLinks';
	}
	else
	{
		echo '<br/><br/><input type="checkbox" id="' . $this->get_field_id('affl_widget_interactive_opt') . '" name="' . $this->get_field_name('affl_widget_interactive_opt') . '" value="1"  />&nbsp; Enable Interactive AffiLinks';
	}

	if ($affl_widget_avoid_dup == 1)
	{
		echo '<br/><input type="checkbox" id="' . $this->get_field_id('affl_widget_avoid_dup') . '" name="' . $this->get_field_name('affl_widget_avoid_dup') . '" value="1"  CHECKED />&nbsp; Show Only Unique AffiLinks';
	}
	else
	{
		echo '<br/><input type="checkbox" id="' . $this->get_field_id('affl_widget_avoid_dup') . '" name="' . $this->get_field_name('affl_widget_avoid_dup') . '" value="1"  />&nbsp; Show Only Unique AffiLinks';
	}
	echo '<input type="hidden" name="aff_widget_submit" id="aff_widget_submit" value="1" />';
?>
