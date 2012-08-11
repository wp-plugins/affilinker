<?php
		echo '<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>';
	echo '<h2>'.$afflt[0].'</h2>
	<br />
		<table class="widefat" cellspacing="10" cellpadding="10" style="background-color:#DBF1FF" width="100%" >';
		if (0 /*get_option("affl_num_enable")==0*/){
		echo '<tr  valign="top" >
		<td COLSPAN="2">
		<p><strong>Plugin Not Activated !</strong></p>
		<br/>
		</td>
		</tr>
	<form name="license" method="post" action="http://www.affilinker.com/tester/">
		<tr  valign="top" >
			<td height="50px">Enter Order Number :</td>
			<td height="50px"><input type="text" name="affl_user_rcpt_id" size="65" value="" /></td>
		</tr>
		<tr  valign="top" >
			<td height="50px"><input type="submit" class="button-primary" value="Activate Plugin" name="getlicense" /></td>
		</tr>
	</form>
		<tr  valign="top" >
		<td COLSPAN="2">
		<p><strong>Note:</strong> Your purchase confirmation mail from Clickbank with subject <em>Receipt for your ClickBank Order</em> contains the Order Number under column PURCHASE INFORMATION.</p>
		<br/>
		</td>
		</tr>
		</table>
		</div>';
		}else{echo'<tr  valign="top" >
		<td COLSPAN="2">
		<p><strong>Plugin Activated !</strong></p>
		<br/>
		</td>
		</tr></table>
		</div>';}
?>
