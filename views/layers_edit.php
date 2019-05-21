<?PHP
	echo '
	<ol class="breadcrumb breadcrumb-arrow" style="margin: 10px 15px 0 0;">
		<li><a href="#"><i class="fa fa-home"></i> Dashboard</a></li>
		<li><a href="#"><i class="fa fa-leaf"></i> '.MF_PLUGIN_NAME_FORMATED.'</a></li>
		<li class="active"><span><i class="fa fa-plus"></i> Edit Layer</span></li>
		<li class="active pull-right help"><span><a href="'.MF_HELP_URL.'" title="Help?" target="_blank"><img src="'.plugins_url('../images/question-mark.png', __FILE__).'" style="height:30px;width:30px;"></a></span></li>
	</ol>
	';

echo '
<form action="" method="post">
	<section id="social plugin" class="wrap" >
	<!-- this ludacris display is how WP renders an icon -->
	<div id="icon-themes" class="icon32"><br></div>
	<div class="col-md-12">
		<h2>Edit Layer</h2>';
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
						
						<div class="col-md-4">
						<label>Base Map Name</label>
						<br>
						<input type="text" class="form-control" required="required" name="name" value="<?php if(isset($row->name) && $row->name!='') echo $row->name; ?>">
						</div>

						<div class="col-md-4">
						<label>URL</label>
						<br>
						<input type="text" class="form-control" required="required" name="url" value="<?php if(isset($row->url) && $row->url!='') echo $row->url; ?>">
						</div>
						
						<div class="col-md-4">
						<label>Key</label>
						<br>
						<input type="text" class="form-control" name="lkey" value="<?php if(isset($row->lkey) && $row->lkey!='') echo $row->lkey; ?>">
						</div>
						
						<div class="col-md-4">
						<label>Access Token</label>
						<br>
						<input type="text" class="form-control" name="accesstoken" value="<?php if(isset($row->accesstoken) && $row->accesstoken!='') echo $row->accesstoken; ?>">
						</div>
						
						<div class="col-md-4">
						<label>Attribution</label>
						<br>
						<input type="text" class="form-control" name="attribution" value="<?php if(isset($row->attribution) && $row->attribution!='') echo stripslashes(htmlspecialchars($row->attribution)); ?>">
						</div>
						<div style="clear:both"></div>
						<br/>
						<input type="hidden" name="id" value="<?=$row->id?>">
						<input type="submit" name="submit" value="Save!" class="btn btn-info">
						
				</div>
			</div>
		</div>
	</div>
</section>
</form>

<?php include 'include/footer-small.php';?>