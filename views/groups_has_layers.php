<?PHP
	echo '
	<ol class="breadcrumb breadcrumb-arrow" style="margin: 10px 15px 0 0;">
		<li><a href="#"><i class="fa fa-home"></i> Dashboard</a></li>
		<li><a href="#"><i class="fa fa-leaf"></i> '.MF_PLUGIN_NAME_FORMATED.'</a></li>
		<li class="active"><span><i class="fa fa-plus"></i> Add Base Maps to Group</span></li>
		<li class="active pull-right help"><span><a href="'.MF_HELP_URL.'" title="Help?" target="_blank"><img src="'.plugins_url('../images/question-mark.png', __FILE__).'" style="height:30px;width:30px;"></a></span></li>
	</ol>
	';

echo '
<form action="" method="post">
	<section id="social plugin" class="wrap" >
	<!-- this ludacris display is how WP renders an icon -->
	<div id="icon-themes" class="icon32"><br></div>
	<div class="col-md-12">
		<h2>Assign Base Maps to Group ('.$group->name.')</h2>';
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
				<div class="panel-body">
					<div class="table-responsive">
						<input type="hidden" name="id" class="form-control" value="<?=$group->id?>">
						<table class="table table-bordered table-striped">
						  <tbody>
							 <tr>
								<td width="45%">
									<b>Available Base Maps</b>
									<select multiple="" class="form-control" id="leftSelect" style="height: 150px;">
										<?PHP 
											foreach($layers as $layer) {
												if(!in_array($layer->id, $assignedLayers))
													echo '<option value="'.$layer->id.'">'.$layer->name.'</option>';
											}
										?>
									</select>
								</td>
								<td width="5%">
									<br><br>
									<button onclick="return false;" id="btnRight" class="btn btn-info"><i class="fa fa-arrow-right"></i></button>
									<br><br>
									<button onclick="return false;" id="btnLeft" class="btn btn-info"><i class="fa fa-arrow-left"></i></button>
								</td>
								<td width="45%">
									<b>Assigned Base Maps</b>
									<select multiple="" name="assigned[]" id="rightSelect" class="form-control" style="height: 150px;">
										<?PHP 
											foreach($layers as $layer) {
												if(in_array($layer->id, $assignedLayers))
													echo '<option value="'.$layer->id.'">'.$layer->name.'</option>';
											}
										?>
									</select>
								</td>
							 </tr>
						  </tbody>
						</table>
						<br/>
						<div class="pull-right">
							<button name="submit" id="save" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
						</div>
					</div>
				 </div>
			</div>
		</div>
	</div>
</section>
</form>
<script>
	$(document).ready(function(){
		$("#btnLeft").click(function () {
			var selectedItem = $("#rightSelect option:selected");
			$("#leftSelect").append(selectedItem);
		});

		$("#btnRight").click(function () {
			var selectedItem = $("#leftSelect option:selected");
			$("#rightSelect").append(selectedItem);
		});
		
		$("#save").click(function () {
			$("#rightSelect option").attr('selected','selected');
		});
	});
</script>
<?php include 'include/footer-small.php';?>