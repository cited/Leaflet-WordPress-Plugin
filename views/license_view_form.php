<style type="text/css">
<!--
.style1 {
	color: #76401a;
	font-weight: bold;
}
.style2 {color: #76401a}
.style7 {font-size: 24px}
.style10 {color: #76401a; font-size: 18px; }
.style12 {font-size: 14px; }
.style22 {
	color: #FF0000;
	font-weight: bold;
}
.style24 {
	color: #000000;
	font-weight: bold;
}
.style29 {color: #993300}
-->
</style>
<ol class="breadcrumb breadcrumb-arrow" style="margin: 10px 15px 0 0;">
		<li><a href="#"><i class="fa fa-home"></i> Dashboard</a></li>
		<li><a href="#"><i class="fa fa-leaf"></i> <?=MF_PLUGIN_NAME_FORMATED?></a></li>
		<li class="active"><span><i class="fa fa-key"></i> License Key</span></li>
		<li class="active pull-right help"><span><a href="<?=MF_HELP_URL?>" title="Help?" target="_blank"><img src="<?=plugins_url('../images/question-mark.png', __FILE__)?>" style="height:30px;width:30px;"></a></span></li>
	</ol>

<?PHP
echo '
<form action="" method="post">
	<section id="social plugin" class="wrap" >
	<!-- this ludacris display is how WP renders an icon -->
	<div id="icon-themes" class="icon32"><br></div>
	<div class="col-md-12">
		<h2>License Settings</h2>';
		if(isset($msg) && $msg!=''):
			echo '<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				'.$msg.'
			</div>';
		elseif(isset($err) && $err!=''):
			echo '<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				'.$err.'
			</div>';
		endif;
?>
		<div class="col-md-12">
			<div class="wrap">
				<div class="settingContent">
						
						<div class="col-md-12">
						<label>License Key (<a target="_blank" href="https://www.mapfig.com/portal/cart.php?gid=1">click here</a> to get the License)</label>
						<br>
						<input type="text" class="form-control" required="required" name="mapfig_premium_licensekey" value="<?php echo get_option("mapfig_premium_licensekey"); ?>">
						</div>

						<div style="clear:both"></div>
						<br/>
						<input type="submit" name="submit" value="Save!" class="btn btn-info">
						
				</div>
			</div>
		</div>
	</div>
	
	
	
	<p>&nbsp;</p>
	<p>&nbsp;</p>

	<p align="center">Copyright @ 2015 MapFig | Envia LLC&nbsp;| <a href="http://www.acugis.com/" target="_blank">AcuGIS</a></p>
	<p align="center"><img src="<?php echo plugins_url('../screenshots/logo.png', __FILE__) ?>" ></p>
	<p align="center">We make GIS simple. </p>
	<p>&nbsp;</p>
	<p><strong>Enciva LLC</strong></p>
	<ul>
	  <li>
	    <p><strong>Address</strong>: 3635 S. Fort Apache Road Suite 200-234 Las Vegas, Nevada 89147</p>
      </li>
	  <li>
	    <p><strong>Tel</strong>: 702 922 7130</p>
      </li>
	  </ul>
	<p><strong>Enciva Europe </strong></p>
		<ul><li><p><strong>Tel</strong>: 44-208-819-9664</p>
      </li>
	  </ul>
	<p>&nbsp;</p>
	<p><br />
	  </p>
	<p>&nbsp;  </p>
  </div>

</section>
</form>

<?php include 'include/footer.php';?>