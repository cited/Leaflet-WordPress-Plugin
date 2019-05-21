   <?php 	 global $wpdb;

	 $map=$wpdb->get_results( "SELECT * FROM ".MF_MAP_TABLE ); ?> 

	 

	<div id="mf-admin-input" style="display:none;">
<div id="mf-admin-input-container"> 
	<p class="form-group" >

		<label>Select Map</label>

		<br>

		<span class="mf-data">

		<select name="map_select" style="width:230px;" class="mfg_border_radis rs_form_w">

			<?php foreach($map as $maps){?>

				<option value="<?php echo $maps->mid;?>" ><?php echo $maps->title;?></option>

				<?php } ?>

		</select>		

		</span>

	</p><!--

	<p class="form-group">

		<label><input type="radio" class="my_mf_check_box" name="mf_insert" id="radio_1" value="icon" /> Insert Icon</label>	

	</p>



	<p class="form-group mhide">

		<label>Text</label>

		<br>

	<input type="input" class="mfg_border_radis rs_form_w" class="mf_text" name="mf_text" />

	</p>

-->

	<p class="form-group" style="display:none;">

		<label><input type="radio" class="my_mf_check_box" name="mf_insert" id="radio_2" value="direct" checked /> Insert Direct</label>	

	</p>





				<button type="button" id="mf-admin-btn" class="button button-primary button-large">Add Map</button></td>

				

</div>

	</div>