<!-- the .wrap-class is required by WP to style the h2 like others in the admin (again, WP ftw!) -->


	<ol class="breadcrumb breadcrumb-arrow" style="margin: 10px 15px 0 0;">
		<li><a href="#"><i class="fa fa-home"></i> Dashboard</a></li>
		<li><a href="#"><i class="fa fa-leaf"></i> <?=MF_PLUGIN_NAME_FORMATED?></a></li>
		<li class="active"><span><i class="fa fa-leaf"></i> Groups</span></li>
		<li class="active pull-right help"><span><a href="<?=MF_HELP_URL?>" title="Help?" target="_blank"><img src="<?=plugins_url('../images/question-mark.png', __FILE__)?>" style="height:30px;width:30px;"></a></span></li>
	</ol>


<section id="social plugin" class="wrap" >



<!-- this ludacris display is how WP renders an icon -->



<div id="icon-themes" class="icon32"><br></div>


<h2>Groups <a href="<?=admin_url().'admin.php?page=groups-add'?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Group</a></h2>



<?php
	if(isset($msg) && $msg!=''):
		echo '
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			'.$msg.'
		</div>
		';
	endif;
	if(isset($err) && $err!=''):
		echo '
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			'.$err.'
		</div>
		';
	endif;
?>



<div class="wrap">



<div class="settingContent">

		<table  id="example1"  class="table table-striped " cellspacing="0" width="100%" height="100%">

        <thead>

            <tr>

                <th><?php _e('Group Id', 'thepesta') ?></th>

				<th><?php _e('Name', 'thepesta') ?></th>

                <th><?php _e('Manage', 'thepesta') ?></th>

            </tr>

        </thead>

 

        <tfoot>

            <tr>

                <th><?php _e('Group Id', 'thepesta') ?></th>

                <th><?php _e('Name', 'thepesta') ?></th>

                <th><?php _e('Manage', 'thepesta') ?></th>

            </tr>

        </tfoot>

 

	<tbody>
		<?php if(isset($result)&& count($result)>0){
				foreach($result as $data): ?>
            <tr>
				<td><?=$data->id;?></td>
				<td><?=$data->name;?></td>
				<td>
					<a href="<?php echo admin_url().'admin.php?page=groups&action=edit&id='.$data->id; ?>" class="btn btn-success btn-sm" title="Edit Group"> <i class="fa fa-edit"></i> </a>
					<a href="<?php echo admin_url().'admin.php?page=groups&action=groups_has_layers&id='.$data->id; ?>" class="btn btn-primary btn-sm"> <i class="fa fa-plus"></i> Add Base Maps</a>
					<a title="View Base Maps" href="<?php echo admin_url().'admin.php?page=layers&groupid='.$data->id; ?>" class="btn btn-default btn-sm"><i class="fa fa-eye"></i> View Base Maps</a>
					<a title="Delete" href="<?php echo admin_url().'admin.php?page=groups&id='.$data->id; ?>" class="btn btn-danger btn-sm" title="Delete Group"><i class="fa fa-remove"></i> </a>
				</td>
            </tr>
		<?php endforeach;
		}else{		?>
		<tr>
			<td colspan="6"><br><br><br><p style="text-align:center;"><?php //_e('No data found', 'thepesta') ?><a href="<?php echo admin_url().'admin.php?page=groups-add'; ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Group</a><br><br><br></p></td>
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