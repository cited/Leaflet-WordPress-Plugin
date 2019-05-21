<!-- the .wrap-class is required by WP to style the h2 like others in the admin (again, WP ftw!) -->


	<ol class="breadcrumb breadcrumb-arrow" style="margin: 10px 15px 0 0;">
		<li><a href="#"><i class="fa fa-home"></i> Dashboard</a></li>
		<li><a href="#"><i class="fa fa-leaf"></i> <?=MF_PLUGIN_NAME_FORMATED?></a></li>
		<li class="active"><span><i class="fa fa-leaf"></i> My Maps</span></li>
		<li class="active pull-right help"><span><a href="<?=MF_HELP_URL?>" title="Help?" target="_blank"><img src="<?=plugins_url('../images/question-mark.png', __FILE__)?>" style="height:30px;width:30px;"></a></span></li>
	</ol>


<section id="social plugin" class="wrap" >



<!-- this ludacris display is how WP renders an icon -->



<div id="icon-themes" class="icon32"><br></div>


<h2>My Maps <a href="<?=admin_url().'admin.php?page=add-new-map'?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Map</a></h2>



<?php
	if(isset($msg) && $msg!=''):
		echo '
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			'.$msg.'
		</div>
		';
	endif;
?>



<div class="wrap">



<div class="settingContent">

		<table  id="example1"  class="table table-striped " cellspacing="0" width="100%" height="100%">

        <thead>

            <tr>

                <th><?php _e('MapCode', 'thepesta') ?></th>

                <th><?php _e('Title', 'thepesta') ?></th>

                <th><?php _e('Width', 'thepesta') ?></th>

                <th><?php _e('Height', 'thepesta') ?></th>



                <th><?php _e('Zoom', 'thepesta') ?></th>

                <th><?php _e('Manage', 'thepesta') ?></th>

            </tr>

        </thead>

 

        <tfoot>

            <tr>

                <th><?php _e('MapCode', 'thepesta') ?></th>

                <th><?php _e('Title', 'thepesta') ?></th>

                <th><?php _e('Width', 'thepesta') ?></th>

                <th><?php _e('Height', 'thepesta') ?></th>



                <th><?php _e('Zoom', 'thepesta') ?></th>

                <th><?php _e('Manage', 'thepesta') ?></th>

            </tr>

        </tfoot>

 

        <tbody>

		<?php if(isset($result)&& count($result)>0){

				foreach($result as $data): ?>

		

            <tr>

	<td>[<?=MF_PLUGIN_NAME_FORMATED?> mapid="<?php echo $data->mid;?>"]</td>

	<td><?php echo $data->title;?></td>

	<td><?php echo $data->width;?> <?php echo $data->width_parameter;?></td>

	<td><?php echo $data->height;?> <?php echo $data->height_parameter;?></td>



	<td><?php echo $data->zoom;?></td>

                <td>

					<a href="<?php echo admin_url('admin-ajax.php?action=view_map&id='.$data->mid); ?>" class="btn btn-info btn-sm"> <i class="fa fa-eye"></i> View</a>

					<a title="Edit" href="<?php echo admin_url().'admin.php?page=add-new-map&id='.$data->mid; ?>" class="btn btn-success btn-sm"> <i class="fa fa-pencil"></i> Edit</a>

					<a title="Delete" href="<?php echo admin_url().'admin.php?page=my-maps&action=delete&mapid='.$data->mid; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>
					
					<a title="Download HTML Map" href="<?=admin_url('admin-ajax.php?action=download_map&id='.$data->mid)?>" class="btn btn-warning btn-sm" target="_blank"><i class="fa fa-download"></i> HTML</a>
					
					<a title="Download JSON" href="<?=admin_url('admin-ajax.php?action=download_json&id='.$data->mid)?>" class="btn btn-warning btn-sm" target="_blank"><i class="fa fa-download"></i> JSON</a>
					
					<a title="Download Web App" href="<?=admin_url('admin-ajax.php?action=download_webapp&id='.$data->mid)?>" class="btn btn-warning btn-sm" target="_blank"><i class="fa fa-download"></i> Web App</a>

				</td>

            </tr>



		<?php endforeach;

		}else{		?>

		<tr>

		<td colspan="6"><br><br><br><p style="text-align:center;"><?php //_e('No data found', 'thepesta') ?><a href="<?php echo admin_url().'admin.php?page=add-new-map'; ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Map</a><br><br><br></p></td>

		</tr>

		<?php } ?>

	</tbody>	

</table>





</div>





</div>

 

<script>

jQuery(document).ready(function() {
<?PHP if(isset($result)&& count($result)>0){ ?>
    jQuery('#example1').dataTable({
         "aLengthMenu": [[5, 10, 25, 50, 75,100, -1], [5, 10,25, 50, 75,100, "All"]],
        "iDisplayLength": 10

    });
<?PHP } ?>
} );

</script>

<?php include 'include/footer-small.php';?>