<?PHP
echo '
	<ol class="breadcrumb breadcrumb-arrow" style="margin: 10px 15px 0 0;">
		<li><a href="#"><i class="fa fa-home"></i> Dashboard</a></li>
		<li><a href="#"><i class="fa fa-leaf"></i> '.MF_PLUGIN_NAME_FORMATED.'</a></li>
		<li class="active"><span><i class="fa fa-plus"></i> '.$title.'</span></li>
		<li class="active pull-right help"><span><a href="'.MF_HELP_URL.'" title="Help?" target="_blank"><img src="'.plugins_url('../images/question-mark.png', __FILE__).'" style="height:30px;width:30px;"></a></span></li>
	</ol>
	';

echo '
	<section id="social plugin" class="wrap" >
	<!-- this ludacris display is how WP renders an icon -->
	<div id="icon-themes" class="icon32"><br></div>
	<div class="col-md-12">
		<h2>'.$title.'</h2>';
?>
		<div class="col-md-12">
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<center><h4>Error while creating a new Map.</h4></center>
		</div>
	</div>
</section>


<div style="clear:both;"></div>
</section>
<?php include 'include/footer-small.php';?>