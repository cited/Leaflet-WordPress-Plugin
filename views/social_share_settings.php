<?PHP
	echo '
	<ol class="breadcrumb breadcrumb-arrow" style="margin: 10px 15px 0 0;">
		<li><a href="#"><i class="fa fa-home"></i> Dashboard</a></li>
		<li><a href="#"><i class="fa fa-leaf"></i> '.MF_PLUGIN_NAME_FORMATED.'</a></li>
		<li class="active"><span><i class="fa fa-plus"></i> Social Share Settings</span></li>
		<li class="active pull-right help"><span><a href="'.MF_HELP_URL.'" title="Help?" target="_blank"><img src="'.plugins_url('../images/question-mark.png', __FILE__).'" style="height:30px;width:30px;"></a></span></li>
	</ol>
	';

echo '
<form action="" method="post" enctype="multipart/form-data">
	<section id="social plugin" class="wrap" >
	<!-- this ludacris display is how WP renders an icon -->
	<div id="icon-themes" class="icon32"><br></div>
	<div class="col-md-12">
		<h2>Social Share Settings</h2>';
		if(isset($msg) && $msg!='')
			echo '<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				'.$msg.'
			</div>';
		if(isset($err) && $err!='')
			echo '<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				'.$err.'
			</div>';
?>
		<div class="col-md-12">
			<div class="wrap">
				<div class="settingContent">
					<div class="col-md-5">
						<label>Default Share Image</label>
						<br>
						<input type="file" name="default">
					</div>
					<div class="col-md-7">
						<img src="<?=plugins_url( '../images/share/default.png' , __FILE__ )?>" style="max-height:100px; max-width:100px;">
					</div>
					<div style="clear: both;"></div>
					<hr>
					
					<div class="col-md-5">
						<label>Facebook Share Image</label>
						<br>
						<input type="file" name="facebook">
					</div>
					<div class="col-md-7">
						<img src="<?=plugins_url( '../images/share/facebook.png' , __FILE__ )?>" style="max-height:100px; max-width:100px;">
					</div>
					<div style="clear: both;"></div>
					<hr>
					
					<div class="col-md-5">
						<label>Twitter Share Image</label>
						<br>
						<input type="file" name="twitter">
					</div>
					<div class="col-md-7">
						<img src="<?=plugins_url( '../images/share/twitter.png' , __FILE__ )?>" style="max-height:100px; max-width:100px;">
					</div>
					<div style="clear: both;"></div>
					<hr>
					
					<div class="col-md-5">
						<label>Pinterest Share Image</label>
						<br>
						<input type="file" name="pinterest">
					</div>
					<div class="col-md-7">
						<img src="<?=plugins_url( '../images/share/pinterest.png' , __FILE__ )?>" style="max-height:100px; max-width:100px;">
					</div>
					<div style="clear: both;"></div>
					<hr>
					
					<div class="col-md-5">
						<label>LinkedIn Share Image</label>
						<br>
						<input type="file" name="linkedin">
					</div>
					<div class="col-md-7">
						<img src="<?=plugins_url( '../images/share/linkedin.png' , __FILE__ )?>" style="max-height:100px; max-width:100px;">
					</div>
					<div style="clear: both;"></div>
					<hr>
					
					<div class="col-md-5">
						<label>Email Share Image</label>
						<br>
						<input type="file" name="email">
					</div>
					<div class="col-md-7">
						<img src="<?=plugins_url( '../images/share/email.png' , __FILE__ )?>" style="max-height:100px; max-width:100px;">
					</div>
					
					<div style="clear:both"></div>
					<br/>
					<input type="submit" name="save" value="Save!" class="btn btn-info">
				</div>
			</div>
		</div>
	</div>
</section>
</form>

<?php include 'include/footer-small.php';?>