<!-- the .wrap-class is required by WP to style the h2 like others in the admin (again, WP ftw!) -->


	<ol class="breadcrumb breadcrumb-arrow" style="margin: 10px 15px 0 0;">
		<li><a href="#"><i class="fa fa-home"></i> Dashboard</a></li>
		<li><a href="#"><i class="fa fa-leaf"></i> <?MF_PLUGIN_NAME_FORMATED?></a></li>
		<li class="active"><span><i class="fa fa-share"></i> Social Share</span></li>
		<li class="active pull-right help"><span><a href="<?=MF_HELP_URL?>" title="Help?" target="_blank"><img src="<?=plugins_url('../images/question-mark.png', __FILE__)?>" style="height:30px;width:30px;"></a></span></li>
		
	</ol>


<section id="social plugin" class="wrap" >



<!-- this ludacris display is how WP renders an icon -->



<div id="icon-themes" class="icon32"><br></div>


<h2>Social Share</h2>



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

	<td><?php echo $data->width;?></td>

	<td><?php echo $data->height;?></td>



	<td><?php echo $data->zoom;?></td>

                <td>
					<span class='st_sharethis_large' st_url="<?php echo admin_url('admin-ajax.php?action=view_map&id='.$data->mid); ?>" st_image="<?=plugins_url( '../images/share/default.png' , __FILE__ )?>" st_title="<?=$data->title?>" displayText='ShareThis'></span>
					<span class='st_facebook_large' st_url="<?php echo admin_url('admin-ajax.php?action=view_map&id='.$data->mid); ?>" st_image="<?=plugins_url( '../images/share/facebook.png' , __FILE__ )?>" st_title="<?=$data->title?>" displayText='Facebook'></span>
					<span class='st_twitter_large' st_url="<?php echo admin_url('admin-ajax.php?action=view_map&id='.$data->mid); ?>" st_image="<?=plugins_url( '../images/share/twitter.png' , __FILE__ )?>" st_title="<?=$data->title?>" displayText='Tweet'></span>
					<span class='st_linkedin_large' st_url="<?php echo admin_url('admin-ajax.php?action=view_map&id='.$data->mid); ?>" st_image="<?=plugins_url( '../images/share/linkedin.png' , __FILE__ )?>" st_title="<?=$data->title?>" displayText='LinkedIn'></span>
					<span class='st_pinterest_large' st_url="<?php echo admin_url('admin-ajax.php?action=view_map&id='.$data->mid); ?>" st_image="<?=plugins_url( '../images/share/pinterest.png' , __FILE__ )?>" st_title="<?=$data->title?>" displayText='Pinterest'></span>
					<span class='st_email_large' st_url="<?php echo admin_url('admin-ajax.php?action=view_map&id='.$data->mid); ?>" st_image="<?=plugins_url( '../images/share/email.png' , __FILE__ )?>" st_title="<?=$data->title?>" displayText='Email'></span>
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

 

<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "e9d95ec2-5d7f-4db8-88c5-4fc99c1099e4", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
<script>
jQuery(document).ready(function() {
<?PHP if(isset($result)&& count($result)>0){ ?>
	setTimeout(function(){
		jQuery('#example1').dataTable({
			 "aLengthMenu": [[5, 10, 25, 50, 75,100, -1], [5, 10,25, 50, 75,100, "All"]],
			"iDisplayLength": 10

		});
	}, 2000);
<?PHP } ?>
} );

</script>


<?php include 'include/footer-small.php';?>